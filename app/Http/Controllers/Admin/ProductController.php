<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Material;
use App\Models\Product;
use App\Models\Tag;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'images']);

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        $products = $query->latest()->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $tags = Tag::all();
        $materials = Material::all();

        return view('admin.products.create', compact('categories', 'tags', 'materials'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],
            'code' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'show_price' => ['boolean'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
            'is_new' => ['boolean'],
            'is_popular' => ['boolean'],
            'tags' => ['array'],
            'tags.*' => ['exists:tags,id'],
            'materials' => ['array'],
            'materials.*' => ['exists:materials,id'],
            'images' => ['array'],
            'images.*' => ['image', 'max:5120'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['show_price'] = $request->has('show_price');
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_new'] = $request->has('is_new');
        $validated['is_popular'] = $request->has('is_popular');

        $product = Product::create($validated);

        if ($request->has('tags')) {
            $product->tags()->sync($request->tags);
        }

        if ($request->has('materials')) {
            $product->materials()->sync($request->materials);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produto criado com sucesso!');
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'images', 'tags', 'materials']);

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $tags = Tag::all();
        $materials = Material::all();
        $product->load(['tags', 'materials']);

        return view('admin.products.edit', compact('product', 'categories', 'tags', 'materials'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,'.$product->id],
            'description' => ['nullable', 'string'],
            'code' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'show_price' => ['boolean'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
            'is_new' => ['boolean'],
            'is_popular' => ['boolean'],
            'tags' => ['array'],
            'tags.*' => ['exists:tags,id'],
            'materials' => ['array'],
            'materials.*' => ['exists:materials,id'],
            'images' => ['array'],
            'images.*' => ['image', 'max:5120'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['show_price'] = $request->has('show_price');
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_new'] = $request->has('is_new');
        $validated['is_popular'] = $request->has('is_popular');

        $product->update($validated);

        if ($request->has('tags')) {
            $product->tags()->sync($request->tags);
        } else {
            $product->tags()->detach();
        }

        if ($request->has('materials')) {
            $product->materials()->sync($request->materials);
        } else {
            $product->materials()->detach();
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product): RedirectResponse
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produto excluído com sucesso!');
    }

    public function deleteImage($imageId): RedirectResponse
    {
        $image = \App\Models\ProductImage::findOrFail($imageId);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Imagem excluída com sucesso!');
    }

    public function exportPdf()
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

        $filename = 'catalogo-produtos-'.date('Y-m-d').'.pdf';

        return $pdf->download($filename);
    }
}
