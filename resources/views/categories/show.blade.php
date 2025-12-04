@extends('layouts.app')

@section('title', $category->name . ' - Lumez')

@section('content')
    <!-- Breadcrumbs -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-sm text-blue-100 mb-4">
                <a href="{{ route('home') }}" class="hover:text-white">Início</a>
                <span class="mx-2">/</span>
                <a href="{{ route('products.index') }}" class="hover:text-white">Produtos</a>
                <span class="mx-2">/</span>
                <span class="text-white font-medium">{{ $category->name }}</span>
            </nav>
            <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $category->name }}</h1>
            <p class="text-blue-100 text-lg">{{ $products->total() }} produtos encontrados</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Categoria Info -->
        <div class="mb-12">
            <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                    <!-- Imagem da categoria ou placeholder elegante -->
                    <div class="relative h-64 md:h-auto min-h-[300px] bg-gradient-to-br from-blue-50 to-purple-50">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" 
                                 alt="{{ $category->name }}"
                                 class="w-full h-full object-cover"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <div class="w-full h-full hidden" style="display: none;">
                        @else
                            <div class="w-full h-full">
                        @endif
                            <!-- Placeholder elegante com padrão geométrico -->
                            <div class="w-full h-full bg-blue-400 relative overflow-hidden">
                                <!-- Padrão geométrico decorativo -->
                                <div class="absolute inset-0 opacity-20">
                                    <div class="absolute top-0 left-0 w-64 h-64 bg-blue-500 rounded-full blur-3xl"></div>
                                    <div class="absolute bottom-0 right-0 w-80 h-80 bg-purple-500 rounded-full blur-3xl"></div>
                                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-48 h-48 bg-indigo-500 rounded-full blur-2xl"></div>
                                </div>
                                <!-- Ícone central elegante -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="text-center">
                                        <div class="w-32 h-32 mx-auto mb-4 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center shadow-xl">
                                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                        </div>
                                        <p class="text-white/90 text-lg font-bold uppercase tracking-wider">{{ $category->name }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    </div>
                    
                    <div class="p-8 md:p-12 flex flex-col justify-center">
                        <div class="mb-4">
                            <span class="inline-block px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-bold uppercase tracking-wider">
                                Categoria
                            </span>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $category->name }}</h2>
                        @if($category->description)
                        <p class="text-gray-600 text-lg leading-relaxed">{{ $category->description }}</p>
                        @endif
                        <div class="mt-6 flex items-center gap-4 text-sm text-gray-500">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                <span class="font-semibold text-gray-700">{{ $products->total() }} produtos</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produtos -->
        @if($products->count() > 0)
        <div>
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Produtos desta Categoria</h2>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600">
                        Mostrando <span class="font-bold">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</span> de <span class="font-bold">{{ $products->total() }}</span>
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <x-product-card-modern :product="$product" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
        @else
        <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-gray-100">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Nenhum produto encontrado</h3>
            <p class="text-gray-500 mb-6">Esta categoria ainda não possui produtos cadastrados.</p>
            <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                Ver Todos os Produtos
            </a>
        </div>
        @endif
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
            image: @if($product->images->count() > 0) @json($product->images->first()->url) @else null @endif
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

