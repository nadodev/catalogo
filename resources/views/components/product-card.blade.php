@props(['product'])

<div class="product-card">
    <div class="relative">
        <a href="{{ route('products.show', $product->slug) }}" class="product-card-image block">
            @if($product->images->count() > 0)
                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                     alt="{{ $product->name }}"
                     loading="lazy">
            @else
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                    <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif
        </a>

        <!-- Badges -->
        @if($product->is_new)
            <span class="product-card-badge badge-new">Novo</span>
        @elseif($product->is_popular)
            <span class="product-card-badge badge-popular">Popular</span>
        @elseif($product->is_featured)
            <span class="product-card-badge badge-featured">Destaque</span>
        @endif

        <!-- Favorite Button -->
        <button 
            onclick="toggleFavorite({{ $product->id }}, '{{ $product->name }}')"
            class="absolute top-3 left-3 p-2 bg-white/90 rounded-full shadow-lg hover:bg-white transition-all"
            data-favorite-btn="{{ $product->id }}">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
        </button>
    </div>

    <div class="p-5">
        <div class="mb-2">
            <a href="{{ route('categories.show', $product->category->slug) }}" 
               class="text-xs text-blue-600 hover:text-blue-700 font-semibold uppercase tracking-wide">
                {{ $product->category->name }}
            </a>
        </div>

        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">
            <a href="{{ route('products.show', $product->slug) }}" class="hover:text-blue-600 transition-colors">
                {{ $product->name }}
            </a>
        </h3>

        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $product->description }}</p>

        <div class="flex items-center justify-between">
            <div>
                @if($product->show_price && $product->price)
                    <span class="price">{{ $product->getPriceDisplay() }}</span>
                @else
                    <span class="price-consult">Sob Consulta</span>
                @endif
            </div>

            <a href="{{ route('quotes.create', $product->slug) }}" 
               class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                Solicitar →
            </a>
        </div>
    </div>
</div>
