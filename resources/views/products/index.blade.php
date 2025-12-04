@extends('layouts.app')

@section('title', 'Nossos Produtos - Lumez')

@section('content')
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Nossos Produtos</h1>
            <p class="text-blue-100 text-lg max-w-2xl">Explore nossa coleção completa de produtos personalizados de alta qualidade.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-1/4 space-y-8">
                <!-- Search -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Buscar</h3>
                    <form action="{{ route('products.index') }}" method="GET">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar produtos..." 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </form>
                </div>

                <!-- Categories -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Categorias</h3>
                    <div class="space-y-2 max-h-60 overflow-y-auto custom-scrollbar">
                        @foreach($categories as $category)
                        <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                           class="flex items-center justify-between group hover:bg-blue-50 p-2 rounded-lg transition-colors {{ request('category') == $category->id ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600' }}">
                            <span>{{ $category->name }}</span>
                            <span class="text-xs bg-gray-100 text-gray-500 py-1 px-2 rounded-full group-hover:bg-blue-100 group-hover:text-blue-600 transition-colors">
                                {{ $category->products_count ?? $category->activeProducts()->count() }}
                            </span>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Preço</h3>
                    <form action="{{ route('products.index') }}" method="GET" class="space-y-4">
                        @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                        @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs text-gray-500 mb-1 block">Mínimo</label>
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="R$ 0"
                                       class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 mb-1 block">Máximo</label>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="R$ 999"
                                       class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                        </div>
                        <button type="submit" class="w-full py-2 bg-gray-900 text-white rounded-lg text-sm font-medium hover:bg-blue-600 transition-colors">
                            Filtrar Preço
                        </button>
                    </form>
                </div>

                <!-- Tags -->
                @if($tags->count() > 0)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                        <a href="{{ route('products.index', ['tags[]' => $tag->id]) }}" 
                           class="px-3 py-1 text-xs rounded-full border border-gray-200 hover:border-blue-500 hover:text-blue-600 transition-colors {{ in_array($tag->id, (array)request('tags')) ? 'bg-blue-50 border-blue-500 text-blue-600' : 'text-gray-600' }}">
                            {{ $tag->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </aside>

            <!-- Main Content -->
            <div class="w-full lg:w-3/4">
                <!-- Toolbar -->
                <div class="flex flex-col sm:flex-row justify-between items-center mb-8 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-gray-600 mb-4 sm:mb-0">
                        Mostrando <span class="font-bold text-gray-900">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</span> de <span class="font-bold text-gray-900">{{ $products->total() }}</span> produtos
                    </p>
                    
                    <div class="flex items-center gap-4">
                        <label class="text-sm text-gray-600">Ordenar por:</label>
                        <select onchange="window.location.href=this.value" class="border-none bg-gray-50 rounded-lg text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 cursor-pointer py-2 pl-3 pr-8">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'recent']) }}" {{ request('sort') == 'recent' ? 'selected' : '' }}>Mais Recentes</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}" {{ request('sort') == 'popular' ? 'selected' : '' }}>Mais Populares</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Menor Preço</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Maior Preço</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'name']) }}" {{ request('sort') == 'name' ? 'selected' : '' }}>Nome (A-Z)</option>
                        </select>
                    </div>
                </div>

                <!-- Product Grid -->
                @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <x-product-card-modern :product="$product" :showQuantity="true" />
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $products->withQueryString()->links() }}
                </div>
                @else
                <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Nenhum produto encontrado</h3>
                    <p class="text-gray-500 mb-6">Tente ajustar seus filtros ou buscar por outro termo.</p>
                    <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Limpar Filtros
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Armazenar dados dos produtos para uso no JavaScript
        window.productsData = {};
        @foreach($products as $product)
        window.productsData[{{ $product->id }}] = {
            id: {{ $product->id }},
            name: @json($product->name),
            slug: @json($product->slug),
            price: {{ $product->price ?? 0 }},
            image: @if($product->images->count() > 0) @json($product->images->first()->url) @else null @endif,
            hasStock: {{ $product->hasStock() ? 'true' : 'false' }},
            variants: [
                @foreach($product->variants->where('is_active', true) as $variant)
                {
                    id: {{ $variant->id }},
                    colorId: {{ $variant->color_id ?? 'null' }},
                    sizeId: {{ $variant->size_id ?? 'null' }},
                    stock: {{ $variant->stock ?? 'null' }},
                    hasStock: {{ ($variant->stock === null || $variant->stock > 0) ? 'true' : 'false' }}
                }@if(!$loop->last),@endif
                @endforeach
            ]
        };
        @endforeach

        function updateProductQuantityCard(productId, change, newValue = null) {
            const input = document.getElementById('qty-input-card-' + productId);
            if (!input) return;
            
            let currentValue = parseInt(input.value) || 1;
            
            if (newValue !== null) {
                currentValue = parseInt(newValue) || 1;
            } else {
                currentValue += change;
            }
            
            if (currentValue < 1) currentValue = 1;
            input.value = currentValue;
        }

        function addProductToCartCard(productId) {
            const product = window.productsData[productId];
            if (!product) {
                console.error('Produto não encontrado:', productId);
                return;
            }

            // Verificar se o produto tem estoque
            if (!product.hasStock) {
                alert('Este produto está sem estoque disponível.');
                return;
            }

            const quantityInput = document.getElementById('qty-input-card-' + productId);
            const quantity = quantityInput ? parseInt(quantityInput.value) || 1 : 1;
            
            // Adicionar a quantidade especificada
            for (let i = 0; i < quantity; i++) {
                addToCart(
                    product.id,
                    product.name,
                    product.slug,
                    product.price,
                    product.image
                );
            }
        }
    </script>
    @endpush
@endsection
