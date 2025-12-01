@extends('layouts.app')

@section('title', 'Categorias - Lumez')

@section('content')
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Nossas Categorias</h1>
            <p class="text-blue-100 text-xl max-w-2xl">Explore nossa ampla variedade de categorias de produtos personalizados</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($categories->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($categories as $index => $category)
            <a href="{{ route('categories.show', $category->slug) }}" 
               class="group relative overflow-hidden rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 h-64 transform hover:-translate-y-2">
                
                <!-- Imagem da categoria ou placeholder elegante -->
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" 
                         alt="{{ $category->name }}"
                         class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <div class="absolute inset-0 hidden" style="display: none;">
                @else
                    <div class="absolute inset-0">
                @endif
                    <!-- Placeholder elegante com padrão geométrico -->
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
                                    <div class="w-20 h-20 mx-auto mb-3 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </div>
                                    <p class="text-white/80 text-xs font-semibold uppercase tracking-wider">{{ $category->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                
                <!-- Overlay escuro sobre a imagem -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-black/30 group-hover:from-black/90 transition-all duration-500"></div>
                
                <!-- Ícone decorativo -->
                <div class="absolute top-4 right-4 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center group-hover:scale-110 group-hover:bg-white/30 transition-all">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </div>
                
                <!-- Conteúdo -->
                <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform group-hover:translate-y-0 transition-transform">
                    <h3 class="text-2xl font-bold mb-2">{{ $category->name }}</h3>
                    <div class="flex items-center gap-2 text-sm text-white/90">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span class="font-semibold">{{ $category->active_products_count ?? 0 }} produtos</span>
                    </div>
                    @if($category->description)
                    <p class="text-sm text-white/80 mt-2 line-clamp-2">{{ $category->description }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-gray-100">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Nenhuma categoria encontrada</h3>
            <p class="text-gray-500">Não há categorias disponíveis no momento.</p>
        </div>
        @endif
    </div>
@endsection

