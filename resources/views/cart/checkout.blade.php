@extends('layouts.app')

@section('title', 'Finalizar Orçamento - Lumez')

@section('content')
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Finalizar Orçamento</h1>
            <p class="text-blue-100 text-lg">Preencha seus dados para solicitar o orçamento</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Formulário -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Dados de Contato</h2>
                    
                    <form id="quote-form" action="{{ route('cart.quote') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nome Completo *</label>
                                <input type="text" 
                                       name="name" 
                                       value="{{ Auth::check() ? Auth::user()->name : old('name') }}"
                                       required 
                                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Telefone *</label>
                                <input type="tel" 
                                       name="phone" 
                                       value="{{ old('phone') }}"
                                       required 
                                       placeholder="(11) 99999-9999"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">E-mail *</label>
                            <input type="email" 
                                   name="email" 
                                   value="{{ Auth::check() ? Auth::user()->email : old('email') }}"
                                   required 
                                   class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Observações</label>
                            <textarea name="notes" 
                                      rows="4" 
                                      placeholder="Informe detalhes adicionais sobre seu pedido..."
                                      class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('notes') }}</textarea>
                            @error('notes')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-4">Como deseja receber o orçamento? *</label>
                            <div class="space-y-3">
                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-500 transition-colors group">
                                    <input type="radio" 
                                           name="contact_method" 
                                           value="email" 
                                           checked 
                                           class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <div class="ml-4 flex-1">
                                        <div class="font-semibold text-gray-900 group-hover:text-blue-600">Por E-mail</div>
                                        <div class="text-sm text-gray-500">Receba o orçamento detalhado no seu e-mail</div>
                                    </div>
                                    <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </label>
                                
                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-green-500 transition-colors group">
                                    <input type="radio" 
                                           name="contact_method" 
                                           value="whatsapp" 
                                           class="w-5 h-5 text-green-600 border-gray-300 focus:ring-green-500">
                                    <div class="ml-4 flex-1">
                                        <div class="font-semibold text-gray-900 group-hover:text-green-600">Por WhatsApp</div>
                                        <div class="text-sm text-gray-500">Receba o orçamento via WhatsApp de forma rápida</div>
                                    </div>
                                    <svg class="w-6 h-6 text-gray-400 group-hover:text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                </label>
                            </div>
                        </div>
                        
                        <input type="hidden" name="cart_items" id="cart-items-input">
                        
                        <div class="flex items-center gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('cart.index') }}" 
                               class="px-6 py-3 border-2 border-gray-200 text-gray-700 rounded-lg font-semibold hover:border-gray-300 transition-colors">
                                Voltar ao Carrinho
                            </a>
                            <button type="submit" 
                                    class="flex-1 px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                                Enviar Solicitação de Orçamento
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Resumo do Pedido -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Resumo do Pedido</h2>
                    
                    <div id="checkout-summary" class="space-y-4 mb-6 pb-6 border-b border-gray-200">
                        <!-- Será preenchido via JavaScript -->
                    </div>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Total de itens:</span>
                            <span class="font-semibold text-gray-900" id="total-items">0</span>
                        </div>
                    </div>
                    
                    <div class="pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-500 text-center">
                            Após enviar sua solicitação, entraremos em contato em breve com o orçamento completo.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function renderCheckoutSummary() {
            const cart = getCart();
            const summaryContainer = document.getElementById('checkout-summary');
            const totalItemsEl = document.getElementById('total-items');
            const cartItemsInput = document.getElementById('cart-items-input');
            
            if (cart.length === 0) {
                window.location.href = '{{ route('cart.index') }}';
                return;
            }

            let totalItems = 0;
            let html = '';
            const cartData = [];

            cart.forEach(item => {
                totalItems += item.quantity;
                const itemTotal = (item.price || 0) * item.quantity;
                
                cartData.push({
                    id: item.id,
                    name: item.name,
                    quantity: item.quantity,
                    price: item.price
                });

                html += `
                    <div class="flex gap-3">
                        <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                            ${item.image ? `<img src="${item.image}" alt="${item.name}" class="w-full h-full object-cover">` : `
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            `}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-gray-900 text-sm mb-1 truncate">${item.name}</h4>
                            <p class="text-xs text-gray-500">Qtd: ${item.quantity}</p>
                            ${item.price ? `<p class="text-sm font-bold text-gray-900 mt-1">R$ ${(itemTotal).toFixed(2).replace('.', ',')}</p>` : '<p class="text-sm font-bold text-blue-600 mt-1">Sob Consulta</p>'}
                        </div>
                    </div>
                `;
            });

            summaryContainer.innerHTML = html;
            totalItemsEl.textContent = totalItems;
            cartItemsInput.value = JSON.stringify(cartData);
        }

        document.getElementById('quote-form').addEventListener('submit', function(e) {
            const cart = getCart();
            if (cart.length === 0) {
                e.preventDefault();
                alert('Seu carrinho está vazio!');
                window.location.href = '{{ route('cart.index') }}';
                return;
            }

            const contactMethod = document.querySelector('input[name="contact_method"]:checked').value;
            
            if (contactMethod === 'whatsapp') {
                e.preventDefault();
                
                const formData = new FormData(this);
                const cart = getCart();
                const cartData = cart.map(item => ({
                    id: item.id,
                    name: item.name,
                    quantity: item.quantity,
                    price: item.price
                }));

                const message = encodeURIComponent(
                    `Olá! Gostaria de solicitar um orçamento para os seguintes produtos:\n\n` +
                    `${cartData.map(item => `• ${item.name} - Quantidade: ${item.quantity}`).join('\n')}\n\n` +
                    `Nome: ${formData.get('name')}\n` +
                    `E-mail: ${formData.get('email')}\n` +
                    `Telefone: ${formData.get('phone')}` +
                    (formData.get('notes') ? `\n\nObservações: ${formData.get('notes')}` : '')
                );
                
                window.open(`https://wa.me/5511999999999?text=${message}`, '_blank');
                clearCart();
                window.location.href = '{{ route('cart.index') }}';
            }
        });

        // Renderizar resumo ao carregar a página
        document.addEventListener('DOMContentLoaded', () => {
            renderCheckoutSummary();
        });
    </script>
    @endpush
@endsection

