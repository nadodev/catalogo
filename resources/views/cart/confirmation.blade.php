@extends('layouts.app')

@section('title', 'Pedido Confirmado - Lumez')

@section('content')
    <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Pedido Confirmado!</h1>
            <p class="text-xl text-green-100">Obrigado pela sua solicitação de orçamento</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 px-8 py-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-1">Detalhes do Pedido</h2>
                        <p class="text-gray-600">Data: {{ $orderData['created_at'] }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500 mb-1">Número do Pedido</div>
                        <div class="text-lg font-bold text-blue-600">#{{ strtoupper(substr(md5($orderData['email'] . $orderData['created_at']), 0, 8)) }}</div>
                    </div>
                </div>
            </div>

            <!-- Informações do Cliente -->
            <div class="px-8 py-6 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informações de Contato</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Nome</div>
                        <div class="font-semibold text-gray-900">{{ $orderData['name'] }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">E-mail</div>
                        <div class="font-semibold text-gray-900">{{ $orderData['email'] }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Telefone</div>
                        <div class="font-semibold text-gray-900">{{ $orderData['phone'] }}</div>
                    </div>
                </div>
            </div>

            <!-- Itens do Pedido -->
            <div class="px-8 py-6 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Itens do Pedido</h3>
                <div class="space-y-4">
                    @foreach($orderData['items'] as $item)
                    <div class="flex gap-4 p-4 bg-gray-50 rounded-xl">
                        <div class="w-20 h-20 bg-gray-200 rounded-lg flex-shrink-0 flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 mb-1">{{ $item['name'] ?? 'Produto' }}</h4>
                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                <span>Quantidade: <strong>{{ $item['quantity'] ?? 1 }}</strong></span>
                                @if(isset($item['price']) && $item['price'] > 0)
                                    <span>Preço unitário: <strong>R$ {{ number_format($item['price'], 2, ',', '.') }}</strong></span>
                                    <span class="ml-auto font-bold text-gray-900">Total: R$ {{ number_format(($item['price'] * ($item['quantity'] ?? 1)), 2, ',', '.') }}</span>
                                @else
                                    <span class="ml-auto font-bold text-blue-600">Sob Consulta</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Resumo -->
            <div class="px-8 py-6 bg-gray-50">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-600 font-semibold">Total de itens:</span>
                    <span class="text-xl font-bold text-gray-900">{{ $orderData['total_items'] }}</span>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                    <span class="text-lg font-bold text-gray-900">Total do pedido:</span>
                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        @if($orderData['total_value'] > 0)
                            R$ {{ number_format($orderData['total_value'], 2, ',', '.') }}
                        @else
                            Sob Consulta
                        @endif
                    </span>
                </div>
            </div>

            <!-- Observações -->
            @if(!empty($orderData['notes']))
            <div class="px-8 py-6 border-t border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Observações</h3>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $orderData['notes'] }}</p>
            </div>
            @endif

            <!-- Mensagem de Confirmação -->
            <div class="px-8 py-6 bg-blue-50 border-t border-gray-200">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-blue-900 mb-2">O que acontece agora?</h4>
                        <p class="text-blue-800 text-sm leading-relaxed">
                            Recebemos sua solicitação de orçamento com sucesso! Nossa equipe entrará em contato em breve através do e-mail ou telefone informado para apresentar o orçamento completo e tirar qualquer dúvida.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('home') }}" 
               class="px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-bold hover:shadow-lg hover:scale-105 transition-all text-center flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Voltar à Página Inicial
            </a>
            <a href="{{ route('products.index') }}" 
               class="px-8 py-4 bg-white border-2 border-gray-200 text-gray-700 rounded-xl font-bold hover:border-blue-600 hover:text-blue-600 transition-all text-center flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Continuar Comprando
            </a>
        </div>
    </div>

    @push('scripts')
    <script>
        // Limpar carrinho após confirmação
        document.addEventListener('DOMContentLoaded', function() {
            clearCart();
            updateCartCount();
        });
    </script>
    @endpush
@endsection

