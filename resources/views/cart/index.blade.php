@extends('layouts.app')

@section('title', 'Carrinho de Compras - Lumez')

@section('content')
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Carrinho de Compras</h1>
            <p class="text-blue-100 text-lg">Revise seus produtos e solicite um orçamento.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div id="cart-container">
            <!-- O conteúdo do carrinho será renderizado aqui via JavaScript -->
            <div class="text-center py-20">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Seu carrinho está vazio</h3>
                <p class="text-gray-500 mb-6">Adicione produtos ao carrinho para continuar.</p>
                <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    Ver Produtos
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function renderCart() {
            const cart = getCart();
            const container = document.getElementById('cart-container');

            if (cart.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-20">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Seu carrinho está vazio</h3>
                        <p class="text-gray-500 mb-6">Adicione produtos ao carrinho para continuar.</p>
                        <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            Ver Produtos
                        </a>
                    </div>
                `;
                return;
            }

            let totalItems = 0;
            let html = `
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-4">
            `;

            cart.forEach(item => {
                totalItems += item.quantity;
                const itemTotal = (item.price || 0) * item.quantity;
                html += `
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex gap-4">
                            <div class="w-24 h-24 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                ${item.image ? `<img src="${item.image}" alt="${item.name}" class="w-full h-full object-cover">` : `
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                `}
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 mb-1">${item.name}</h3>
                                <p class="text-sm text-gray-500 mb-3">Código: ${item.id}</p>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center border border-gray-200 rounded-lg">
                                        <button onclick="updateCartQuantity(${item.id}, ${item.quantity - 1})" 
                                                class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                            </svg>
                                        </button>
                                        <span class="px-4 py-2 text-sm font-semibold">${item.quantity}</span>
                                        <button onclick="updateCartQuantity(${item.id}, ${item.quantity + 1})" 
                                                class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <div class="text-right">
                                        ${item.price ? `<p class="text-lg font-bold text-gray-900">R$ ${(itemTotal).toFixed(2).replace('.', ',')}</p>` : '<p class="text-lg font-bold text-blue-600">Sob Consulta</p>'}
                                        <button onclick="removeFromCart(${item.id})" class="text-sm text-red-600 hover:text-red-700 mt-1">
                                            Remover
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            html += `
                    </div>
                    
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Resumo do Pedido</h2>
                            
                            <div class="space-y-3 mb-6 pb-6 border-b border-gray-200">
                                <div class="flex justify-between text-gray-600">
                                    <span>Total de itens:</span>
                                    <span class="font-semibold">${totalItems}</span>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <a href="{{ route('cart.checkout') }}" 
                                   class="block w-full px-6 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-bold hover:shadow-lg hover:scale-105 transition-all text-center">
                                    Solicitar Orçamento
                                </a>
                                
                                <a href="{{ route('products.index') }}" 
                                   class="block w-full px-6 py-3 text-center border-2 border-gray-200 text-gray-700 rounded-xl font-semibold hover:border-blue-600 hover:text-blue-600 transition-all">
                                    Continuar Comprando
                                </a>
                                
                                <button onclick="clearCart()" 
                                        class="w-full px-6 py-3 text-red-600 hover:text-red-700 font-semibold">
                                    Limpar Carrinho
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.innerHTML = html;
        }


        // Renderizar carrinho ao carregar a página
        document.addEventListener('DOMContentLoaded', () => {
            renderCart();
        });
    </script>
    @endpush
@endsection

