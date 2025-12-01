@extends('layouts.app')

@section('title', $product->name . ' - Lumez')

@section('content')
    <!-- Breadcrumbs -->
    <div class="bg-gray-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Início</a>
                <span class="mx-2">/</span>
                <a href="{{ route('products.index') }}" class="hover:text-blue-600">Produtos</a>
                <span class="mx-2">/</span>
                <a href="{{ route('products.index', ['category' => $product->category->id]) }}" class="hover:text-blue-600">{{ $product->category->name }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900 font-medium">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Image Gallery -->
            <div class="space-y-4">
                <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden border border-gray-100 relative group">
                    @if($product->images->count() > 0)
                        <img id="main-image" src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 cursor-zoom-in"
                             onclick="openImageModal('{{ asset('storage/' . $product->images->first()->image_path) }}')">
                    @else
                        <img id="main-image" src="{{ asset('images/product-placeholder.svg') }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @endif

                    <!-- Badges -->
                    <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
                        @if($product->is_featured)
                        <span class="px-3 py-1 bg-purple-500 text-white text-sm font-bold rounded-lg shadow-lg">⭐ Destaque</span>
                        @endif
                        @if($product->is_new)
                        <span class="px-3 py-1 bg-green-500 text-white text-sm font-bold rounded-lg shadow-lg">🆕 Novo</span>
                        @endif
                    </div>

                    <!-- Botão de zoom/fullscreen -->
                    @if($product->images->count() > 0)
                    <button onclick="openImageModal('{{ asset('storage/' . $product->images->first()->image_path) }}')" 
                            class="absolute bottom-4 right-4 p-3 bg-white/90 backdrop-blur-sm rounded-full shadow-lg hover:bg-white transition-all z-10">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                        </svg>
                    </button>
                    @endif
                </div>

                @if($product->images->count() > 1)
                <div class="grid grid-cols-4 gap-4">
                    @foreach($product->images as $index => $image)
                    <button onclick="changeMainImage('{{ asset('storage/' . $image->image_path) }}')" 
                            class="aspect-square bg-gray-100 rounded-xl overflow-hidden border-2 border-transparent hover:border-blue-500 focus:border-blue-500 transition-all group relative">
                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors"></div>
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
                <!-- Título e Código -->
                <div class="border-b border-gray-200 pb-6">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">{{ $product->name }}</h1>
                    <div class="flex flex-wrap items-center gap-4 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="text-gray-500 font-medium">Código:</span>
                            <span class="text-gray-900 font-bold bg-gray-100 px-3 py-1 rounded-lg">{{ $product->code ?? 'N/A' }}</span>
                        </div>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('products.index', ['category' => $product->category->id]) }}" 
                           class="text-blue-600 hover:text-blue-700 font-semibold hover:underline flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            {{ $product->category->name }}
                        </a>
                    </div>
                </div>

                <!-- Preço -->
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-6 border border-blue-100">
                    @if($product->show_price)
                        <div class="text-sm text-gray-600 mb-1">Preço</div>
                        <div id="price-display">
                            @if($product->price)
                                <span class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                    R$ {{ number_format($product->price, 2, ',', '.') }}
                                </span>
                                <div class="text-sm text-gray-500 mt-1" id="price-per-unit"></div>
                            @else
                                <span class="text-3xl font-bold text-blue-600">Sob Consulta</span>
                            @endif
                        </div>
                        
                        @if($product->quantityPrices->count() > 0)
                        <div class="mt-4 pt-4 border-t border-blue-200">
                            <div class="text-xs font-semibold text-gray-600 mb-2">Tabela de Preços por Quantidade:</div>
                            <div class="space-y-1">
                                @foreach($product->quantityPrices as $priceTier)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">{{ $priceTier->getRangeDescription() }}:</span>
                                    <span class="font-bold text-blue-600">R$ {{ number_format($priceTier->price, 2, ',', '.') }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="text-sm text-gray-600 mb-1">Preço</div>
                        <span class="text-3xl font-bold text-blue-600">Sob Consulta</span>
                    @endif
                </div>

                <!-- Descrição -->
                <div class="prose prose-lg max-w-none">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Descrição</h3>
                    <div class="text-gray-600 leading-relaxed">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>

                @if($product->materials->count() > 0)
                <div>
                    <h3 class="font-bold text-gray-900 mb-2">Materiais:</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->materials as $material)
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">
                            {{ $material->name }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($product->variants->count() > 0)
                <div class="pt-6 border-t border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Opções Disponíveis:</h3>
                    <div class="space-y-4">
                        @php
                            $variantsByColor = $product->variants->groupBy('color_id');
                            $variantsBySize = $product->variants->groupBy('size_id');
                        @endphp
                        
                        @if($variantsByColor->count() > 1 || ($variantsByColor->first() && $variantsByColor->first()->first()->color))
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cores:</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($variantsByColor as $colorId => $variants)
                                    @if($variants->first()->color)
                                        <div class="relative group">
                                            <button type="button" 
                                                    class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:border-blue-500 transition-all font-medium text-sm"
                                                    onclick="selectVariantColor({{ $colorId }})">
                                                <span class="flex items-center gap-2">
                                                    @if($variants->first()->color->hex_code)
                                                        <span class="w-5 h-5 rounded-full border border-gray-300" style="background-color: {{ $variants->first()->color->hex_code }}"></span>
                                                    @endif
                                                    {{ $variants->first()->color->name }}
                                                </span>
                                            </button>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($variantsBySize->count() > 1 || ($variantsBySize->first() && $variantsBySize->first()->first()->size))
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tamanhos:</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($variantsBySize as $sizeId => $variants)
                                    @if($variants->first()->size)
                                        <button type="button" 
                                                class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:border-blue-500 transition-all font-medium text-sm variant-size-btn"
                                                onclick="selectVariantSize({{ $sizeId }})">
                                            {{ $variants->first()->size->name }}
                                        </button>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Lista de todas as variantes disponíveis -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Variantes Disponíveis:</label>
                            <div class="space-y-2">
                                @foreach($product->variants->where('is_active', true) as $variant)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex items-center gap-3">
                                            @if($variant->color)
                                                <span class="flex items-center gap-2">
                                                    @if($variant->color->hex_code)
                                                        <span class="w-4 h-4 rounded-full border border-gray-300" style="background-color: {{ $variant->color->hex_code }}"></span>
                                                    @endif
                                                    <span class="font-medium">{{ $variant->color->name }}</span>
                                                </span>
                                            @endif
                                            @if($variant->color && $variant->size)
                                                <span class="text-gray-400">•</span>
                                            @endif
                                            @if($variant->size)
                                                <span class="font-medium">{{ $variant->size->name }}</span>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            @if($variant->price)
                                                <span class="font-bold text-blue-600">R$ {{ number_format($variant->price, 2, ',', '.') }}</span>
                                            @elseif($product->show_price && $product->price)
                                                <span class="font-bold text-blue-600">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                                            @else
                                                <span class="font-bold text-blue-600">Sob Consulta</span>
                                            @endif
                                            @if($variant->stock !== null)
                                                <div class="text-xs text-gray-500 mt-1">Estoque: {{ $variant->stock }}</div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="pt-6 border-t border-gray-100 space-y-4">
                    <div class="flex items-center gap-2">
                        <label class="text-sm font-semibold text-gray-700">Quantidade:</label>
                        <div class="flex items-center border border-gray-200 rounded-lg">
                            <button onclick="updateProductQuantity({{ $product->id }}, -1)" 
                                    class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </button>
                            <input type="number" 
                                   id="qty-input-{{ $product->id }}" 
                                   value="1" 
                                   min="1" 
                                   class="w-20 text-center border-0 focus:ring-2 focus:ring-blue-500 text-base font-semibold"
                                   onchange="updateProductQuantity({{ $product->id }}, 0, this.value)">
                            <button onclick="updateProductQuantity({{ $product->id }}, 1)" 
                                    class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <button onclick="addProductToCart({{ $product->id }})" 
                                class="flex-1 px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-bold text-center hover:shadow-lg hover:scale-105 transition-all flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span>Adicionar ao Carrinho</span>
                        </button>
                        
                        <button onclick="toggleFavorite({{ $product->id }}, '{{ addslashes($product->name) }}')" 
                                class="px-6 py-4 bg-white border-2 border-gray-200 text-gray-700 rounded-xl font-bold hover:border-red-500 hover:text-red-500 transition-all flex items-center justify-center gap-2 group">
                            <svg class="w-6 h-6 favorite-icon-{{ $product->id }} group-hover:fill-current" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                        
                        <a href="https://wa.me/5511999999999?text=Olá, gostaria de saber mais sobre o produto: {{ $product->name }}" 
                           target="_blank"
                           class="px-6 py-4 bg-green-500 text-white rounded-xl font-bold hover:bg-green-600 hover:shadow-lg transition-all flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-24 pt-12 border-t border-gray-200">
            <div class="text-center mb-12">
                <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Recomendações</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 mt-2">Produtos Similares</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Você também pode se interessar por estes produtos</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                    <div class="relative aspect-square overflow-hidden bg-gray-100">
                        <a href="{{ route('products.show', $related->slug) }}">
                            @if($related->images->count() > 0)
                                <img src="{{ asset('storage/' . $related->images->first()->image_path) }}" 
                                     alt="{{ $related->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <img src="{{ asset('images/product-placeholder.svg') }}" 
                                     alt="{{ $related->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @endif
                        </a>
                        
                        <!-- Badge de novo -->
                        @if($related->is_new)
                        <div class="absolute top-3 left-3 px-2 py-1 bg-green-500 text-white text-xs font-bold rounded-lg">
                            Novo
                        </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <div class="mb-2">
                            <a href="{{ route('products.index', ['category' => $related->category->id]) }}" 
                               class="text-xs text-blue-600 hover:text-blue-700 font-semibold uppercase">
                                {{ $related->category->name }}
                            </a>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2 line-clamp-2 min-h-[3rem]">
                            <a href="{{ route('products.show', $related->slug) }}" class="hover:text-blue-600 transition-colors">
                                {{ $related->name }}
                            </a>
                        </h3>
                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                            @if($related->show_price && $related->price)
                                <span class="text-lg font-bold text-gray-900">R$ {{ number_format($related->price, 2, ',', '.') }}</span>
                            @else
                                <span class="text-base font-bold text-blue-600">Sob Consulta</span>
                            @endif
                            <a href="{{ route('products.show', $related->slug) }}" 
                               class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    @push('scripts')
    <script>
        window.productData = {
            id: {{ $product->id }},
            name: '{{ addslashes($product->name) }}',
            slug: '{{ $product->slug }}',
            price: {{ $product->price ?? 0 }},
            image: @if($product->images->count() > 0) '{{ asset('storage/' . $product->images->first()->image_path) }}' @else null @endif,
            quantityPrices: @json($product->quantityPrices->map(function($tier) {
                return [
                    'min_quantity' => $tier->min_quantity,
                    'max_quantity' => $tier->max_quantity,
                    'price' => (float)$tier->price
                ];
            }))
        };

        function updateProductQuantity(productId, change, newValue = null) {
            const input = document.getElementById('qty-input-' + productId);
            let currentValue = parseInt(input.value) || 1;
            
            if (newValue !== null) {
                currentValue = parseInt(newValue) || 1;
            } else {
                currentValue += change;
            }
            
            if (currentValue < 1) currentValue = 1;
            input.value = currentValue;
            
            // Atualizar preço baseado na quantidade
            updatePriceForQuantity(currentValue);
        }

        function updatePriceForQuantity(quantity) {
            const product = window.productData;
            if (!product || !product.quantityPrices || product.quantityPrices.length === 0) {
                return;
            }

            // Encontrar a faixa de preço correspondente
            let selectedPrice = null;
            let selectedTier = null;

            for (let tier of product.quantityPrices) {
                if (quantity >= tier.min_quantity) {
                    if (tier.max_quantity === null || quantity <= tier.max_quantity) {
                        if (!selectedTier || tier.min_quantity > selectedTier.min_quantity) {
                            selectedTier = tier;
                            selectedPrice = tier.price;
                        }
                    }
                }
            }

            // Se não encontrou faixa específica, usar preço padrão
            if (selectedPrice === null) {
                selectedPrice = product.price || 0;
            }

            // Atualizar exibição do preço
            const priceDisplay = document.getElementById('price-display');
            if (priceDisplay && selectedPrice > 0) {
                const totalPrice = selectedPrice * quantity;
                const pricePerUnit = selectedPrice;
                
                priceDisplay.innerHTML = `
                    <div>
                        <span class="text-2xl font-bold text-gray-600">Total: </span>
                        <span class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            R$ ${totalPrice.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                        </span>
                    </div>
                    <div class="text-sm text-gray-500 mt-1" id="price-per-unit">
                        R$ ${pricePerUnit.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} por unidade
                    </div>
                `;
            }
        }

        // Atualizar preço quando a página carregar
        document.addEventListener('DOMContentLoaded', function() {
            const qtyInput = document.getElementById('qty-input-{{ $product->id }}');
            if (qtyInput) {
                updatePriceForQuantity(parseInt(qtyInput.value) || 1);
            }
        });

        function addProductToCart(productId) {
            const product = window.productData;
            if (!product || product.id !== productId) return;

            const quantity = parseInt(document.getElementById('qty-input-' + productId).value) || 1;
            
            // Calcular preço baseado na quantidade
            let priceToUse = product.price || 0;
            if (product.quantityPrices && product.quantityPrices.length > 0) {
                priceToUse = calculatePriceForQuantity(quantity, product.price, product.quantityPrices);
            }
            
            // Adicionar ao carrinho com a quantidade e preço corretos
            addToCart(
                product.id,
                product.name,
                product.slug,
                priceToUse,
                product.image,
                product.quantityPrices || null
            );
            
            // Se a quantidade for maior que 1, adicionar itens adicionais
            if (quantity > 1) {
                for (let i = 1; i < quantity; i++) {
                    addToCart(
                        product.id,
                        product.name,
                        product.slug,
                        priceToUse,
                        product.image,
                        product.quantityPrices || null
                    );
                }
            }
        }

        function changeMainImage(imageSrc) {
            document.getElementById('main-image').src = imageSrc;
        }

        function openImageModal(imageSrc) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4';
            modal.innerHTML = `
                <div class="relative max-w-7xl max-h-full">
                    <img src="${imageSrc}" alt="Imagem ampliada" class="max-w-full max-h-[90vh] object-contain rounded-lg">
                    <button onclick="this.closest('.fixed').remove()" 
                            class="absolute top-4 right-4 p-3 bg-white/90 backdrop-blur-sm rounded-full hover:bg-white transition-all">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            `;
            document.body.appendChild(modal);
            
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.remove();
                }
            });
        }
    </script>
    @endpush
@endsection
