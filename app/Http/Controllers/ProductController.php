<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Material;
use App\Models\Product;
use App\Models\Tag;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query()->with(['category', 'images', 'tags', 'materials'])->active();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($categoryId = $request->input('category')) {
            $query->where('category_id', $categoryId);
        }

        // Filter by tags
        if ($tagIds = $request->input('tags')) {
            $query->whereHas('tags', function ($q) use ($tagIds) {
                $q->whereIn('tags.id', (array) $tagIds);
            });
        }

        // Filter by materials
        if ($materialIds = $request->input('materials')) {
            $query->whereHas('materials', function ($q) use ($materialIds) {
                $q->whereIn('materials.id', (array) $materialIds);
            });
        }

        // Filter by price range
        if ($minPrice = $request->input('min_price')) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice = $request->input('max_price')) {
            $query->where('price', '<=', $maxPrice);
        }

        // Filter by flags
        if ($request->input('new')) {
            $query->new();
        }
        if ($request->input('popular')) {
            $query->popular();
        }
        if ($request->input('featured')) {
            $query->featured();
        }

        // Sorting
        $sort = $request->input('sort', 'recent');
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name' => $query->orderBy('name', 'asc'),
            'popular' => $query->orderBy('views_count', 'desc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12);

        $categories = Category::query()->where('is_active', true)->orderBy('order')->get();
        $tags = Tag::all();
        $materials = Material::all();

        return view('products.index', compact('products', 'categories', 'tags', 'materials'));
    }

    public function show(string $slug): View
    {
        $product = Product::query()
            ->with(['category', 'images', 'tags', 'materials', 'variants.color', 'variants.size', 'quantityPrices'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $product->incrementViews();

        $relatedProducts = $product->getRelatedProducts();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        // Se IDs foram fornecidos, buscar por IDs
        if ($ids = $request->input('ids')) {
            $idsArray = explode(',', $ids);
            $products = Product::query()
                ->with(['category', 'images'])
                ->where('is_active', true)
                ->whereIn('id', $idsArray)
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'category_name' => $product->category->name ?? '',
                        'price_display' => $product->getPriceDisplay(),
                        'primary_image' => $product->images->first()?->image_path,
                    ];
                });

            return response()->json($products);
        }

        // Busca normal por texto
        $search = $request->input('q');

        $products = Product::query()
            ->where('is_active', true)
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'slug']);

        return response()->json($products);
    }

    public function mostViewed(): View
    {
        $products = Product::query()
            ->with(['category', 'images'])
            ->active()
            ->orderBy('views_count', 'desc')
            ->limit(12)
            ->get();

        return view('products.most-viewed', compact('products'));
    }

    public function viewCatalogPdf()
    {
        // Buscar produtos ativos agrupados por categoria
        $categories = Category::where('is_active', true)
            ->with(['products' => function ($query) {
                $query->where('is_active', true)
                    ->with('images')
                    ->orderBy('name');
            }])
            ->orderBy('order')
            ->orderBy('name')
            ->get()
            ->filter(function ($category) {
                return $category->products->count() > 0;
            });

        $pdf = Pdf::loadView('admin.products.pdf-catalog', compact('categories'))
            ->setPaper('a4', 'portrait')
            ->setOption('enable-local-file-access', true);

        return $pdf->stream('catalogo-produtos.pdf');
    }
}
