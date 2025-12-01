@extends('layouts.app')

@section('title', 'Meus Pedidos - Lumez')

@section('content')
<div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-bold mb-4">Meus Pedidos</h1>
        <p class="text-blue-100 text-lg">Histórico de seus orçamentos solicitados</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <nav class="space-y-2">
                    <a href="{{ route('user.dashboard') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors text-gray-700 hover:bg-gray-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('user.profile') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors text-gray-700 hover:bg-gray-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Perfil</span>
                    </a>
                    
                    <a href="{{ route('user.orders') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors bg-blue-50 text-blue-600 font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Pedidos</span>
                    </a>
                    
                    <a href="{{ route('user.favorites') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors text-gray-700 hover:bg-gray-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span>Favoritos</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Conteúdo -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                @if($quotes->count() > 0)
                <div class="space-y-4">
                    @foreach($quotes as $quote)
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">
                                    @if($quote->product)
                                        {{ $quote->product->name }}
                                    @else
                                        Orçamento #{{ $quote->id }}
                                    @endif
                                </h3>
                                <p class="text-sm text-gray-500">Solicitado em {{ $quote->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                {{ $quote->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($quote->status === 'processed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($quote->status === 'pending' ? 'Pendente' : ($quote->status === 'processed' ? 'Processado' : 'Cancelado')) }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Quantidade</p>
                                <p class="font-semibold text-gray-900">{{ $quote->quantity }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Telefone</p>
                                <p class="font-semibold text-gray-900">{{ $quote->phone }}</p>
                            </div>
                        </div>
                        
                        @if($quote->notes)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-500 mb-1">Observações</p>
                            <p class="text-gray-900">{{ $quote->notes }}</p>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $quotes->links() }}
                </div>
                @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Nenhum pedido encontrado</h3>
                    <p class="text-gray-500 mb-6">Você ainda não solicitou nenhum orçamento.</p>
                    <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Ver Produtos
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

