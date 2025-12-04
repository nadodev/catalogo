@props(['product', 'showQuantity' => true])

<div class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 transform hover:-translate-y-2">
    <!-- Imagem -->
    <div class="relative aspect-square overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
        <a href="{{ route('products.show', $product->slug) }}" class="block w-full h-full">
            @if($product->images->count() > 0)
                <img src="{{ $product->images->first()->url }}" 
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            @else
                <img src="{{ asset('storage/images/product-placeholder.svg') }}" 
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            @endif
        </a>
        
        <!-- Overlay com gradiente no hover -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        <!-- Badges -->
        <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
            @if($product->is_featured)
            <span class="px-3 py-1.5 bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs font-bold rounded-full shadow-lg backdrop-blur-sm">
                ⭐ Destaque
            </span>
            @endif
            @if($product->is_new)
            <span class="px-3 py-1.5 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xs font-bold rounded-full shadow-lg backdrop-blur-sm">
                🆕 Novo
            </span>
            @endif
        </div>

        <!-- Botões de ação no hover -->
        <div class="absolute top-4 right-4 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
            <button onclick="toggleFavorite({{ $product->id }}, '{{ addslashes($product->name) }}')" 
                    class="p-2.5 bg-white/95 backdrop-blur-sm rounded-full text-gray-400 hover:text-red-500 hover:bg-white transition-all shadow-lg">
                <svg class="w-5 h-5 favorite-icon-{{ $product->id }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </button>
            
            <a href="{{ route('products.show', $product->slug) }}" 
               class="p-2.5 bg-white/95 backdrop-blur-sm rounded-full text-gray-400 hover:text-blue-600 hover:bg-white transition-all shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </a>
        </div>
    </div>

    <!-- Conteúdo -->
    <div class="p-6">
        <!-- Categoria -->
        <div class="mb-3">
            <a href="{{ route('products.index', ['category' => $product->category->id]) }}" 
               class="inline-block text-xs font-bold text-blue-600 hover:text-blue-700 uppercase tracking-wider bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-full transition-colors">
                {{ $product->category->name }}
            </a>
        </div>

        <!-- Título -->
        <h3 class="font-bold text-gray-900 mb-3 line-clamp-2 min-h-[3rem] group-hover:text-blue-600 transition-colors">
            <a href="{{ route('products.show', $product->slug) }}">
                {{ $product->name }}
            </a>
        </h3>

        <!-- Preço -->
        <div class="mb-4">
            @if($product->show_price && $product->price)
                <div class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    R$ {{ number_format($product->price, 2, ',', '.') }}
                </div>
            @else
                <div class="text-lg font-bold text-blue-600">Sob Consulta</div>
            @endif
        </div>

        @if($showQuantity)
        <!-- Quantidade e Botão -->
        <div class="space-y-3 pt-4 border-t border-gray-100">
            <div class="flex items-center gap-2">
                <label class="text-xs font-semibold text-gray-600">Qtd:</label>
                <div class="flex items-center border-2 border-gray-200 rounded-xl flex-1 hover:border-blue-400 transition-colors">
                    <button onclick="updateProductQuantityCard({{ $product->id }}, -1)" 
                            class="cursor-pointer px-3 py-2 text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition-colors rounded-l-xl" 
                            id="qty-decrease-card-{{ $product->id }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                        </svg>
                    </button>
                    <input type="number" 
                           id="qty-input-card-{{ $product->id }}" 
                           value="1" 
                           min="1" 
                           class="w-full text-center border-0 focus:ring-0 text-sm font-bold bg-transparent"
                           onchange="updateProductQuantityCard({{ $product->id }}, 0, this.value)">
                    <button onclick="updateProductQuantityCard({{ $product->id }}, 1)" 
                            class="cursor-pointer px-3 py-2 text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition-colors rounded-r-xl"
                            id="qty-increase-card-{{ $product->id }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="flex gap-2">
                <a href="{{ route('products.show', $product->slug) }}" 
                   class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-colors text-center text-sm flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span>Ver</span>
                </a>
                
                @php
                    $hasStock = $product->hasStock();
                @endphp
                <button onclick="addProductToCartCard({{ $product->id }})" 
                        @if(!$hasStock) disabled @endif
                        class="@if($hasStock) cursor-pointer flex-1 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition-all flex items-center justify-center gap-1.5 @else flex-1 px-4 py-2.5 bg-gray-300 text-gray-500 rounded-xl font-semibold cursor-not-allowed flex items-center justify-center gap-1.5 @endif"
                        id="add-cart-btn-card-{{ $product->id }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>@if($hasStock) Adicionar @else Sem Estoque @endif</span>
                </button>
            </div>
        </div>
        @else
        <!-- Apenas botão de detalhes -->
        <div class="pt-4 border-t border-gray-100">
            <a href="{{ route('products.show', $product->slug) }}" 
               class="cursor-pointer block w-full px-4 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition-all text-center text-sm">
                Ver Detalhes
            </a>
        </div>
        @endif
    </div>
</div>

