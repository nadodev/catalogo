@extends('layouts.app')

@section('title', 'Nossos Produtos - Lumez')

@section('content')
    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    </div>
    @endif

    <!-- Hero Section Profissional -->
    <section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 text-white">
        <!-- Overlay com padrão sutil -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        
        <!-- Formas decorativas modernas -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center py-20 md:py-32">
                <!-- Conteúdo -->
                <div class="text-center lg:text-left space-y-8 fade-in-up">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md rounded-full text-sm font-semibold border border-white/20">
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span>Produtos Premium para sua Marca</span>
                    </div>
                    
                    <!-- Título Principal -->
                    <h1 class="text-4xl md:text-6xl lg:text-6xl font-extrabold leading-tight">
                        Produtos Personalizados
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mt-2">
                            de Alta Qualidade
                        </span>
                    </h1>
                    
                    <!-- Descrição -->
                    <p class="text-xl md:text-2xl text-gray-300 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Transforme sua marca com brindes e produtos corporativos exclusivos. 
                        <span class="text-white font-semibold">Personalização profissional</span> que impressiona seus clientes.
                    </p>
                    
                    <!-- Features rápidas -->
                    <div class="flex flex-wrap gap-6 justify-center lg:justify-start text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Entrega Rápida</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Qualidade Garantida</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Atendimento Personalizado</span>
                        </div>
                    </div>
                    
                    <!-- CTAs -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-4">
                        <a href="{{ route('products.index') }}" class="group px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-bold hover:shadow-2xl hover:shadow-blue-500/50 hover:scale-105 transition-all flex items-center justify-center gap-2">
                            <span>Explorar Catálogo</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        <a href="{{ route('quotes.create') }}" class="px-8 py-4 bg-white/10 backdrop-blur-md border-2 border-white/30 text-white rounded-xl font-bold hover:bg-white/20 hover:scale-105 transition-all">
                            Solicitar Orçamento
                        </a>
                    </div>
                </div>
                
                <!-- Visual/Imagem do Produto (lado direito) -->
                @if(isset($heroProduct))
                <div class="hidden lg:block relative">
                    <div class="relative group">
                        <!-- Card flutuante com estatísticas -->
                        <div class="absolute -top-8 -left-8 bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-2xl animate-float z-10">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold">{{ \App\Models\Product::where('is_active', true)->count() }}+</div>
                                    <div class="text-sm text-gray-300">Produtos</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Card flutuante 2 -->
                        <div class="absolute -bottom-8 -right-8 bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-2xl animate-float z-10" style="animation-delay: 0.5s;">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold">100%</div>
                                    <div class="text-sm text-gray-300">Satisfação</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Container principal com imagem do produto -->
                        <a href="{{ route('products.show', $heroProduct->slug) }}" class="block relative group">
                            <div class="relative bg-gradient-to-br from-blue-600/20 to-purple-600/20 rounded-3xl overflow-hidden border border-white/10 backdrop-blur-sm shadow-2xl group-hover:shadow-blue-500/50 transition-all duration-500">
                                <!-- Imagem do produto -->
                                <div class="aspect-square relative overflow-hidden">
                                    @if($heroProduct->images->count() > 0)
                                        <img src="{{ $heroProduct->images->first()->url }}" 
                                             alt="{{ $heroProduct->name }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    @else
                                        <img src="{{ asset('images/product-placeholder.svg') }}" 
                                             alt="{{ $heroProduct->name }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    @endif
                                    
                                    <!-- Overlay gradiente -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                    
                                    <!-- Badges do produto -->
                                    <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
                                        @if($heroProduct->is_featured)
                                        <span class="px-3 py-1 bg-purple-500/90 backdrop-blur-sm text-white text-sm font-bold rounded-lg shadow-lg">⭐ Destaque</span>
                                        @endif
                                        @if($heroProduct->is_new)
                                        <span class="px-3 py-1 bg-green-500/90 backdrop-blur-sm text-white text-sm font-bold rounded-lg shadow-lg">🆕 Novo</span>
                                        @endif
                                    </div>
                                    
                                    <!-- Informações do produto no hover -->
                                    <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-full group-hover:translate-y-0 transition-transform duration-500">
                                        <h3 class="text-xl font-bold text-white mb-2">{{ $heroProduct->name }}</h3>
                                        @if($heroProduct->category)
                                        <p class="text-sm text-blue-200 mb-3">{{ $heroProduct->category->name }}</p>
                                        @endif
                                        <div class="flex items-center gap-2 text-white">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                            </svg>
                                            <span class="font-semibold">Ver Detalhes</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Efeito de brilho no hover -->
                            <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-blue-500/0 via-blue-500/20 to-purple-500/0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                        </a>
                    </div>
                </div>
                @else
                <!-- Fallback se não houver produto com imagem -->
                <div class="hidden lg:block relative">
                    <div class="relative bg-gradient-to-br from-blue-600/20 to-purple-600/20 rounded-3xl p-12 border border-white/10 backdrop-blur-sm">
                        <div class="aspect-square flex items-center justify-center">
                            <svg class="w-32 h-32 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Wave separator -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg class="w-full h-16 fill-white" viewBox="0 0 1440 100" preserveAspectRatio="none">
                <path d="M0,50 Q360,0 720,50 T1440,50 L1440,100 L0,100 Z"></path>
            </svg>
        </div>
    </section>

    <!-- Categories com Cards Modernos -->
    @if($categories->count() > 0)
    <section class="py-20 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 fade-in-up">
                <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Categorias</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 mt-2">Explore Nossas Categorias</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Encontre o produto perfeito para sua necessidade</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($categories->take(8) as $index => $category)
                <a href="{{ route('categories.show', $category->slug) }}" 
                   class="group relative overflow-hidden rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 h-56 transform hover:-translate-y-2"
                   style="animation-delay: {{ $index * 0.1 }}s">
                    
                    <!-- Imagem da categoria ou placeholder elegante -->
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" 
                             alt="{{ $category->name }}"
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                             onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');">
                    @endif
                    
                    <!-- Placeholder elegante com padrão geométrico (sempre presente, mas oculto se houver imagem) -->
                    <div class="absolute inset-0 {{ $category->image ? 'hidden' : '' }}" 
                         id="placeholder-{{ $index }}">
                        @php
                            $colors = [
                                ['bg-blue-400', 'bg-blue-500'],
                                ['bg-purple-400', 'bg-purple-500'],
                                ['bg-pink-400', 'bg-pink-500'],
                                ['bg-indigo-400', 'bg-indigo-500'],
                                ['bg-cyan-400', 'bg-cyan-500'],
                                ['bg-emerald-400', 'bg-emerald-500'],
                                ['bg-orange-400', 'bg-orange-500'],
                                ['bg-rose-400', 'bg-rose-500'],
                            ];
                            $color = $colors[$index % count($colors)];
                        @endphp
                        <div class="w-full h-full {{ $color[0] }} relative overflow-hidden">
                            <!-- Padrão geométrico decorativo -->
                            <div class="absolute inset-0 opacity-20">
                                <div class="absolute top-0 left-0 w-32 h-32 {{ $color[1] }} rounded-full blur-3xl"></div>
                                <div class="absolute bottom-0 right-0 w-40 h-40 {{ $color[1] }} rounded-full blur-3xl"></div>
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-24 h-24 {{ $color[1] }} rounded-full blur-2xl"></div>
                            </div>
                            <!-- Ícone central elegante -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="w-16 h-16 mx-auto mb-2 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </div>
                                    <p class="text-white/80 text-xs font-semibold uppercase tracking-wider px-2">{{ $category->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Overlay escuro sobre a imagem -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20 group-hover:from-black/90 transition-all duration-500"></div>
                    
                    <!-- Ícone decorativo -->
                    <div class="absolute top-4 right-4 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                    
                    <!-- Conteúdo -->
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform group-hover:translate-y-0 transition-transform">
                        <h3 class="text-xl font-bold mb-1">{{ $category->name }}</h3>
                        <p class="text-sm text-white/80">{{ $category->activeProducts->count() }} produtos</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Featured Products Premium -->
    @if($featuredProducts->count() > 0)
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 fade-in-up">
                <span class="text-purple-600 font-semibold text-sm uppercase tracking-wider">Destaques</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 mt-2">Produtos em Destaque</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Seleção especial dos nossos melhores produtos</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($featuredProducts as $product )
                    <x-product-card-modern :product="$product" :showQuantity="true" />
                @endforeach
            </div>

            <div class="text-center mt-16">
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-10 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-bold hover:shadow-2xl hover:scale-105 transition-all">
                    <span>Ver Todos os Produtos</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    @endif
    <!-- CTA Premium -->
    <section class="py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-purple-600 to-pink-500"></div>
        <div class="absolute top-0 left-0 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl"></div>
        
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Pronto para Personalizar?</h2>
            <p class="text-xl md:text-2xl mb-10 text-blue-50 max-w-3xl mx-auto">Entre em contato e receba um orçamento sem compromisso</p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('quotes.create') }}" class="group px-10 py-5 bg-white text-blue-600 rounded-xl font-bold hover:shadow-2xl hover:scale-105 transition-all flex items-center justify-center gap-2">
                    <span>Solicitar Orçamento</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                <a href="https://wa.me/5549999195407" target="_blank" class="px-10 py-5 bg-green-500 text-white rounded-xl font-bold hover:bg-green-600 hover:shadow-2xl hover:scale-105 transition-all flex items-center justify-center gap-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    <span>Chamar no WhatsApp</span>
                </a>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        // Armazenar dados dos produtos da home para uso no JavaScript
        window.homeProductsData = {};
        @foreach($featuredProducts as $product)
        window.homeProductsData[{{ $product->id }}] = {
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
            const product = window.homeProductsData[productId];
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