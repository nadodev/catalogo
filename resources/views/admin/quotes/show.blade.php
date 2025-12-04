@extends('layouts.dashboard')

@section('title', 'Orçamento #' . $quote->id . ' - Lumez')
@section('page-title', 'Detalhes do Orçamento')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">Orçamento #{{ $quote->id }}</h2>
            <form action="{{ route('admin.quotes.update-status', $quote) }}" method="POST" class="flex items-center gap-2">
                @csrf
                @method('PUT')
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="pending" {{ $quote->status === 'pending' ? 'selected' : '' }}>Pendente</option>
                    <option value="processed" {{ $quote->status === 'processed' ? 'selected' : '' }}>Processado</option>
                    <option value="cancelled" {{ $quote->status === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Atualizar Status
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Nome</h3>
                <p class="text-lg text-gray-900">{{ $quote->name }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">E-mail</h3>
                <p class="text-lg text-gray-900">{{ $quote->email }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Telefone</h3>
                <p class="text-lg text-gray-900">{{ $quote->phone }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Status</h3>
                <span class="px-3 py-1 text-sm font-medium rounded-full 
                    {{ $quote->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                       ($quote->status === 'processed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                    {{ ucfirst($quote->status) }}
                </span>
            </div>

            @if($quote->product)
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Produto</h3>
                <p class="text-lg text-gray-900">{{ $quote->product->name }}</p>
            </div>
            @endif

            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Quantidade</h3>
                <p class="text-lg text-gray-900">{{ $quote->quantity }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Data de Criação</h3>
                <p class="text-lg text-gray-900">{{ $quote->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">IP</h3>
                <p class="text-lg text-gray-900">{{ $quote->ip_address }}</p>
            </div>
        </div>

        @if($quote->notes)
        <div class="mt-6">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Observações</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                @php
                    $notes = $quote->notes;
                    $cartItems = null;
                    
                    // Tentar extrair JSON de produtos do carrinho
                    if (preg_match('/Produtos do carrinho:\s*(\[[\s\S]*?\])/i', $notes, $matches)) {
                        try {
                            $cartItems = json_decode($matches[1], true);
                            // Remover a parte do JSON das observações
                            $notes = preg_replace('/\n\nProdutos do carrinho:[\s\S]*$/i', '', $notes);
                            $notes = trim($notes);
                        } catch (\Exception $e) {
                            // Se não conseguir parsear, manter como está
                        }
                    }
                @endphp
                
                @if(!empty($notes))
                    <div class="text-gray-900 mb-4 whitespace-pre-wrap">{{ $notes }}</div>
                @endif
                
                @if($cartItems && is_array($cartItems) && count($cartItems) > 0)
                    <div class="mt-4">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Produtos do Carrinho</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 bg-white rounded-lg shadow-sm">
                                <thead class="bg-gradient-to-r from-blue-600 to-purple-600">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Produto</th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider">Quantidade</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-white uppercase tracking-wider">Preço Unitário</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-white uppercase tracking-wider">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php
                                        $grandTotal = 0;
                                    @endphp
                                    @foreach($cartItems as $item)
                                        @php
                                            $price = $item['price'] ?? 0;
                                            $quantity = $item['quantity'] ?? 1;
                                            $itemTotal = $price * $quantity;
                                            $grandTotal += $itemTotal;
                                        @endphp
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm text-gray-900">
                                                {{ $item['name'] ?? 'Produto' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-center text-gray-700">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $quantity }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-right text-gray-700">
                                                @if($price > 0)
                                                    R$ {{ number_format($price, 2, ',', '.') }}
                                                @else
                                                    <span class="text-blue-600 font-medium">Sob Consulta</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-sm text-right font-semibold text-gray-900">
                                                @if($price > 0)
                                                    R$ {{ number_format($itemTotal, 2, ',', '.') }}
                                                @else
                                                    <span class="text-blue-600">Sob Consulta</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-right text-sm font-bold text-gray-700">
                                            Total Geral:
                                        </td>
                                        <td class="px-4 py-3 text-right text-lg font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                            @if($grandTotal > 0)
                                                R$ {{ number_format($grandTotal, 2, ',', '.') }}
                                            @else
                                                <span class="text-blue-600">Sob Consulta</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="text-gray-900 whitespace-pre-wrap">{{ $quote->notes }}</div>
                @endif
            </div>
        </div>
        @endif

        @if($quote->artwork_file)
        <div class="mt-6">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Arquivo de Arte</h3>
            <a href="{{ asset('storage/' . $quote->artwork_file) }}" target="_blank" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Baixar Arquivo
            </a>
        </div>
        @endif
    </div>

    <div class="flex items-center justify-end gap-4">
        <a href="{{ route('admin.quotes.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
            Voltar
        </a>
    </div>
</div>
@endsection

