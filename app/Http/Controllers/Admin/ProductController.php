<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Material;
use App\Models\Product;
use App\Models\ProductQuantityPrice;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\Tag;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

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
        $colors = Color::where('is_active', true)->orderBy('order')->orderBy('name')->get();
        $sizes = Size::where('is_active', true)->orderBy('order')->orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'tags', 'materials', 'colors', 'sizes'));
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
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
            'materials' => ['nullable', 'array'],
            'materials.*' => ['exists:materials,id'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:5120'],
            'variants' => ['nullable', 'array'],
            'variants.*.color_id' => ['nullable', 'exists:colors,id'],
            'variants.*.size_id' => ['nullable', 'exists:sizes,id'],
            'variants.*.price' => ['nullable', 'numeric', 'min:0'],
            'variants.*.stock' => ['nullable', 'integer', 'min:0'],
            'variants.*.sku' => ['nullable', 'string', 'max:255'],
            'variants.*.image' => ['nullable', 'image', 'max:5120'],
            'quantity_prices' => ['nullable', 'array'],
            'quantity_prices.*.min_quantity' => ['nullable', 'integer', 'min:1'],
            'quantity_prices.*.max_quantity' => ['nullable', 'integer', 'min:1'],
            'quantity_prices.*.price' => ['nullable', 'numeric', 'min:0'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['show_price'] = $request->has('show_price');
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_new'] = $request->has('is_new');
        $validated['is_popular'] = $request->has('is_popular');

        $product = Product::create($validated);

        if ($request->has('tags') && is_array($request->tags) && count($request->tags) > 0) {
            $product->tags()->sync($request->tags);
        }

        if ($request->has('materials') && is_array($request->materials) && count($request->materials) > 0) {
            $product->materials()->sync($request->materials);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        // Criar variantes do produto
        if ($request->has('variants')) {
            foreach ($request->variants as $variantData) {
                if (!empty($variantData['color_id']) || !empty($variantData['size_id'])) {
                    $variantAttributes = [
                        'product_id' => $product->id,
                        'color_id' => $variantData['color_id'] ?? null,
                        'size_id' => $variantData['size_id'] ?? null,
                        'price' => $variantData['price'] ?? null,
                        'stock' => $variantData['stock'] ?? null,
                        'sku' => $variantData['sku'] ?? null,
                        'is_active' => true,
                    ];

                    // Salvar imagem da variante se fornecida
                    if (isset($variantData['image']) && $variantData['image']->isValid()) {
                        $imagePath = $variantData['image']->store('variants', 'public');
                        $variantAttributes['image_path'] = $imagePath;
                    }

                    ProductVariant::create($variantAttributes);
                }
            }
        }

        // Criar faixas de preço por quantidade
        if ($request->has('quantity_prices')) {
            foreach ($request->quantity_prices as $index => $priceData) {
                if (!empty($priceData['min_quantity']) && !empty($priceData['price'])) {
                    ProductQuantityPrice::create([
                        'product_id' => $product->id,
                        'min_quantity' => $priceData['min_quantity'],
                        'max_quantity' => $priceData['max_quantity'] ?? null,
                        'price' => $priceData['price'],
                        'order' => $index,
                        'is_active' => true,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produto criado com sucesso!');
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'images', 'tags', 'materials', 'variants.color', 'variants.size', 'allQuantityPrices']);

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $tags = Tag::all();
        $materials = Material::all();
        $colors = Color::where('is_active', true)->orderBy('order')->orderBy('name')->get();
        $sizes = Size::where('is_active', true)->orderBy('order')->orderBy('name')->get();
        $product->load(['tags', 'materials', 'variants.color', 'variants.size', 'allQuantityPrices']);

        return view('admin.products.edit', compact('product', 'categories', 'tags', 'materials', 'colors', 'sizes'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        // Verificação de segurança EXTRA - garantir que é realmente um UPDATE
        $requestMethod = $request->method();
        $intendedMethod = $request->input('_method');
        $routeName = $request->route()?->getName();
        
        Log::info('=== UPDATE PRODUTO INICIADO ===', [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'request_method' => $requestMethod,
            'intended_method' => $intendedMethod,
            'route_name' => $routeName,
            'has_update_flag' => $request->has('_update'),
            'has_product_id' => $request->has('product_id'),
            'url' => $request->fullUrl(),
            'referer' => $request->header('referer')
        ]);
        
        // Se tiver flag _update, é definitivamente um UPDATE, mesmo que o método seja DELETE
        // (pode ter vindo do destroy que redirecionou)
        if ($request->has('_update')) {
            // Forçar o método para PUT se for DELETE
            if ($requestMethod === 'DELETE' || $intendedMethod === 'DELETE') {
                Log::info('Corrigindo método DELETE para PUT (flag _update presente)', [
                    'product_id' => $product->id
                ]);
                // Continuar com o update normalmente
            }
        } else {
            // Se não tiver flag _update, bloquear DELETE
            if ($requestMethod === 'DELETE' || $intendedMethod === 'DELETE') {
                Log::error('Tentativa de DELETE no método UPDATE sem flag _update! BLOQUEADO!', [
                    'product_id' => $product->id,
                    'method' => $requestMethod,
                    'intended_method' => $intendedMethod,
                    'route_name' => $routeName,
                    'url' => $request->fullUrl()
                ]);
                abort(405, 'Método não permitido. Esta é uma operação de UPDATE, não DELETE.');
            }
        }
        
        // Garantir que o produto existe antes de atualizar
        if (!$product->exists) {
            Log::error('Produto não existe!', ['product_id' => $product->id]);
            abort(404, 'Produto não encontrado');
        }
        
        try {
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
            'tags' => ['nullable', 'array'],
            'tags.*' => ['nullable', 'exists:tags,id'],
            'materials' => ['nullable', 'array'],
            'materials.*' => ['nullable', 'exists:materials,id'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:5120'],
            // Variantes removidas - não serão processadas no update para evitar exclusões acidentais
            'quantity_prices' => ['nullable', 'array'],
            'quantity_prices.*.min_quantity' => ['nullable', 'integer', 'min:1'],
            'quantity_prices.*.max_quantity' => ['nullable', 'integer', 'min:1'],
            'quantity_prices.*.price' => ['nullable', 'numeric', 'min:0'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['show_price'] = $request->has('show_price');
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_new'] = $request->has('is_new');
        $validated['is_popular'] = $request->has('is_popular');

        // IMPORTANTE: Atualizar o produto - NUNCA deletar aqui
        $product->update($validated);
        
        // Garantir que o produto ainda existe após update
        $product->refresh();

        if ($request->has('tags') && is_array($request->tags) && count($request->tags) > 0) {
            $product->tags()->sync($request->tags);
        } else {
            $product->tags()->detach();
        }

        if ($request->has('materials') && is_array($request->materials) && count($request->materials) > 0) {
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

        // Variantes do produto - REMOVIDO para evitar exclusões acidentais
        // As variantes existentes serão mantidas e não serão alteradas durante a edição

        // Atualizar faixas de preço por quantidade
        // IMPORTANTE: Só atualizar faixas se houver faixas VÁLIDAS no request
        // Se não houver faixas válidas, manter as existentes (NÃO DELETAR)
        
        // Filtrar apenas faixas válidas (com min_quantity E price preenchidos)
        $validQuantityPrices = [];
        if ($request->has('quantity_prices') && is_array($request->quantity_prices)) {
            foreach ($request->quantity_prices as $index => $priceData) {
                $hasMinQty = isset($priceData['min_quantity']) && !empty($priceData['min_quantity']) && $priceData['min_quantity'] !== '';
                $hasPrice = isset($priceData['price']) && !empty($priceData['price']) && $priceData['price'] !== '';
                
                if ($hasMinQty && $hasPrice) {
                    $validQuantityPrices[] = [
                        'index' => $index,
                        'data' => $priceData
                    ];
                }
            }
        }
        
        // Só atualizar se houver faixas válidas
        if (count($validQuantityPrices) > 0) {
            Log::info('Atualizando faixas de preço', [
                'product_id' => $product->id,
                'faixas_validas' => count($validQuantityPrices)
            ]);
            // Remover faixas existentes apenas se houver novas válidas
            $product->allQuantityPrices()->delete();
            
            // Criar novas faixas
            foreach ($validQuantityPrices as $item) {
                ProductQuantityPrice::create([
                    'product_id' => $product->id,
                    'min_quantity' => $item['data']['min_quantity'],
                    'max_quantity' => !empty($item['data']['max_quantity']) ? $item['data']['max_quantity'] : null,
                    'price' => $item['data']['price'],
                    'order' => $item['index'],
                    'is_active' => true,
                ]);
            }
        }
        // Se não houver faixas válidas, manter as existentes (NÃO DELETAR)
        else {
            Log::info('Mantendo faixas de preço existentes', [
                'product_id' => $product->id,
                'faixas_existentes' => $product->allQuantityPrices()->count()
            ]);
        }

        // Verificar se o produto ainda existe antes de redirecionar
        $product->refresh();
        if (!$product->exists) {
            Log::error('ERRO CRÍTICO: Produto foi deletado durante update!', [
                'product_id' => $product->id ?? 'N/A'
            ]);
            abort(500, 'Erro ao atualizar produto. O produto não foi encontrado após a atualização.');
        }
        
        Log::info('Produto atualizado com sucesso', [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'variants_count' => $product->variants()->count(),
            'quantity_prices_count' => $product->allQuantityPrices()->count()
        ]);
        return redirect()->route('admin.products.index')->with('success', 'Produto atualizado com sucesso!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('=== ERRO DE VALIDAÇÃO ===', [
                'product_id' => $product->id,
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('=== ERRO AO ATUALIZAR PRODUTO ===', [
                'product_id' => $product->id,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'Erro ao atualizar produto: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Product $product): RedirectResponse
    {
        $request = request();
        $requestMethod = $request->method();
        $intendedMethod = $request->input('_method');
        
        Log::warning('=== DESTROY PRODUTO CHAMADO ===', [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'method' => $requestMethod,
            'intended_method' => $intendedMethod,
            'route_name' => $request->route()->getName(),
            'has_update_flag' => $request->has('_update'),
            'referer' => $request->header('referer'),
            'url' => $request->fullUrl()
        ]);
        
        // Verificação CRÍTICA: se tiver flag _update, NÃO é um DELETE - REDIRECIONAR para UPDATE
        if ($request->has('_update') || $intendedMethod === 'PUT' || $intendedMethod === 'PATCH') {
            Log::error('Tentativa de chamar destroy com flag _update ou método PUT/PATCH! REDIRECIONANDO para UPDATE!', [
                'product_id' => $product->id,
                'method' => $requestMethod,
                'intended_method' => $intendedMethod,
                'referer' => $request->header('referer'),
                'url' => $request->fullUrl()
            ]);
            // Redirecionar para o método update ao invés de bloquear
            return $this->update($request, $product);
        }
        
        // Verificar se realmente é um DELETE
        if ($requestMethod !== 'DELETE' && $intendedMethod !== 'DELETE') {
            Log::error('Tentativa de chamar destroy sem método DELETE!', [
                'product_id' => $product->id,
                'method' => $requestMethod,
                'intended_method' => $intendedMethod
            ]);
            abort(405, 'Método não permitido. DELETE requer método DELETE.');
        }
        
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
