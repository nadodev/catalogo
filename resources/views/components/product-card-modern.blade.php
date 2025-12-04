@props(['product'])

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

        <!-- Botão Ver Mais -->
        <div class="pt-4 border-t border-gray-100">
            <a href="{{ route('products.show', $product->slug) }}" 
               class="cursor-pointer block w-full px-4 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition-all text-center text-sm flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                <span>Ver Mais</span>
            </a>
        </div>
    </div>
</div>

