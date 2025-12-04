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
                       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors text-gray-700 hover:bg-gray-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Pedidos</span>
                    </a>
                    
                    <a href="{{ route('user.favorites') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors bg-blue-50 text-blue-600 font-semibold">
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
            @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            @if($favorites->count() > 0)
            <div id="favorites-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($favorites as $product)
                    <div id="favorite-product-{{ $product->id }}" class="relative">
                        <x-product-card-modern :product="$product" />
                        <button onclick="removeFavoriteFromDashboard({{ $product->id }}, '{{ addslashes($product->name) }}')" 
                                class="absolute top-2 right-2 p-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors shadow-lg z-10"
                                title="Remover dos favoritos">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $favorites->links() }}
            </div>
            @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Nenhum favorito ainda</h3>
                <p class="text-gray-500 mb-6">Adicione produtos aos favoritos para vê-los aqui.</p>
                <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    Ver Produtos
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
window.removeFavoriteFromDashboard = async function (productId, productName) {
    if (!confirm(`Deseja remover "${productName}" dos favoritos?`)) {
        return;
    }

    try {
        const response = await fetch(`/api/favoritos/${productId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            credentials: 'same-origin'
        });

        if (response.ok) {
            const data = await response.json();
            
            // Limpar cache global ANTES de atualizar
            if (typeof window.favoritesCache !== 'undefined') {
                window.favoritesCache = null;
            }
            if (typeof window.favoritesLoading !== 'undefined') {
                window.favoritesLoading = false;
            }
            
            // Atualizar UI completa de favoritos (contador e ícones) IMEDIATAMENTE
            if (typeof window.refreshFavoritesUI === 'function') {
                await window.refreshFavoritesUI();
            } else if (typeof window.updateFavoritesCount === 'function') {
                await window.updateFavoritesCount();
            }
            
            // Remover o card da interface com animação
            const productCard = document.getElementById(`favorite-product-${productId}`);
            if (productCard) {
                productCard.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
                productCard.style.opacity = '0';
                productCard.style.transform = 'scale(0.9) translateY(-10px)';
                
                setTimeout(() => {
                    productCard.remove();
                    
                    // Verificar se não há mais favoritos
                    const grid = document.getElementById('favorites-grid');
                    if (grid && grid.children.length === 0) {
                        // Recarregar página para mostrar mensagem de vazio
                        setTimeout(() => {
                            location.reload();
                        }, 100);
                    }
                }, 300);
            }
            
            // Mostrar toast de confirmação
            if (typeof window.showFavoriteToast === 'function') {
                window.showFavoriteToast(false, productName);
            } else {
                // Fallback: mostrar mensagem simples
                showSuccessMessage('Produto removido dos favoritos!');
            }
        } else {
            const errorData = await response.json().catch(() => ({ message: 'Erro desconhecido' }));
            alert('Erro ao remover favorito: ' + (errorData.message || 'Erro desconhecido'));
        }
    } catch (error) {
        console.error('Erro ao remover favorito:', error);
        alert('Erro ao remover favorito. Tente novamente.');
    }
};

function showSuccessMessage(message) {
    const notification = document.createElement('div');
    notification.className = 'fixed top-24 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2';
    notification.innerHTML = `
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span>${message}</span>
    `;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transition = 'opacity 0.3s';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
</script>
@endpush
@endsection

