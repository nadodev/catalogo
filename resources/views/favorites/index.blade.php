@extends('layouts.app')

@section('title', 'Meus Favoritos - Lumez')

@section('content')
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Meus Favoritos</h1>
            <p class="text-blue-100 text-lg">Produtos que você adicionou aos favoritos</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @auth
            @if(isset($favorites) && $favorites->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($favorites as $product)
                        <x-product-card-modern :product="$product" :showQuantity="false" />
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $favorites->links() }}
                </div>
            @else
                <div class="text-center py-20">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Nenhum favorito ainda</h3>
                    <p class="text-gray-500 mb-6">Adicione produtos aos favoritos para vê-los aqui.</p>
                    <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Ver Produtos
                    </a>
                </div>
            @endif
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Acesso Restrito</h3>
                <p class="text-gray-500 mb-6">Você precisa estar logado para ver seus favoritos.</p>
                <div class="flex gap-4 justify-center">
                    <a href="{{ route('login') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Fazer Login
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-3 border-2 border-gray-200 text-gray-700 rounded-lg font-semibold hover:border-blue-600 hover:text-blue-600 transition-colors">
                        Criar Conta
                    </a>
                </div>
            </div>
        @endauth
    </div>

@endsection

