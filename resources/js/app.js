import './bootstrap';

// Favorites System
let favoritesCache = null;

window.isUserLoggedIn = function () {
    return typeof window.userLoggedIn !== 'undefined' && window.userLoggedIn === true;
};

window.toggleFavorite = async function (productId, productName) {
    // Verificar se está logado
    if (!window.isUserLoggedIn()) {
        showLoginModal();
        return;
    }
    
    try {
        const response = await fetch(`/api/favoritos/${productId}/toggle`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            credentials: 'same-origin'
        });

        if (response.ok) {
            const data = await response.json();
            // Limpar cache
            favoritesCache = null;
            
            // Atualizar interface
            await refreshFavoritesUI();
            
            // Mostrar toast
            showFavoriteToast(data.favorited, productName);
        } else {
            const errorData = await response.json();
            alert('Erro ao favoritar: ' + (errorData.message || 'Erro desconhecido'));
        }
    } catch (error) {
        console.error('Erro ao favoritar:', error);
        alert('Erro ao favoritar. Tente novamente.');
    }
};

window.getFavoriteIds = async function () {
    if (!window.isUserLoggedIn()) {
        return [];
    }
    
    try {
        if (favoritesCache === null) {
            const response = await fetch('/api/favoritos/list', {
                method: 'GET',
                credentials: 'same-origin'
            });
            
            if (response.ok) {
                const data = await response.json();
                favoritesCache = data.favorites || [];
            } else {
                favoritesCache = [];
            }
        }
        return favoritesCache;
    } catch (error) {
        console.error('Erro ao carregar favoritos:', error);
        return [];
    }
};

window.refreshFavoritesUI = async function () {
    if (!window.isUserLoggedIn()) {
        // Se não estiver logado, remover todos os estados de favorito
        document.querySelectorAll('[class*="favorite-icon-"]').forEach(icon => {
            icon.classList.remove('fill-red-500', 'text-red-500');
            icon.classList.add('text-gray-400');
            icon.removeAttribute('fill');
        });
        return;
    }
    
    const favoriteIds = await getFavoriteIds();
    
    // Atualizar todos os botões de favorito
    document.querySelectorAll('button[onclick*="toggleFavorite"]').forEach(btn => {
        const onclick = btn.getAttribute('onclick');
        if (!onclick) return;
        
        const match = onclick.match(/toggleFavorite\s*\(\s*(\d+)/);
        if (match) {
            const productId = parseInt(match[1]);
            updateFavoriteButton(btn, productId, favoriteIds);
        }
    });
    
    // Atualizar ícones por classe
    document.querySelectorAll('[class*="favorite-icon-"]').forEach(icon => {
        // Usar classList para obter todas as classes como string
        const classList = Array.from(icon.classList).join(' ');
        const match = classList.match(/favorite-icon-(\d+)/);
        if (match) {
            const productId = parseInt(match[1]);
            const isFavorited = favoriteIds.includes(productId);
            
            if (isFavorited) {
                icon.classList.add('fill-red-500', 'text-red-500');
                icon.classList.remove('text-gray-400');
                icon.setAttribute('fill', 'currentColor');
            } else {
                icon.classList.remove('fill-red-500', 'text-red-500');
                icon.classList.add('text-gray-400');
                icon.removeAttribute('fill');
            }
        }
    });
    
    // Atualizar contador
    await updateFavoritesCount();
};

window.updateFavoriteButton = function (btn, productId, favoriteIds) {
    const svg = btn.querySelector('svg');
    if (!svg) return;
    
    const isFavorited = favoriteIds.includes(productId);
    
    if (isFavorited) {
        svg.classList.add('fill-red-500', 'text-red-500');
        svg.classList.remove('text-gray-400');
        svg.setAttribute('fill', 'currentColor');
    } else {
        svg.classList.remove('fill-red-500', 'text-red-500');
        svg.classList.add('text-gray-400');
        svg.removeAttribute('fill');
    }
};

window.updateFavoritesCount = async function () {
    if (!window.isUserLoggedIn()) {
        const countEl = document.getElementById('favorites-count');
        if (countEl) {
            countEl.textContent = '0';
            countEl.classList.add('hidden');
        }
        return;
    }
    
    const favoriteIds = await getFavoriteIds();
    const count = favoriteIds.length;
    
    const countEl = document.getElementById('favorites-count');
    if (countEl) {
        countEl.textContent = count;
        countEl.classList.toggle('hidden', count === 0);
    }
};

window.showLoginModal = function () {
    // Remover modais anteriores
    const existingModal = document.getElementById('login-modal-favorite');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Buscar rotas do meta tag ou usar URLs padrão
    const loginUrl = document.querySelector('meta[name="login-url"]')?.content || '/login';
    const registerUrl = document.querySelector('meta[name="register-url"]')?.content || '/cadastro';
    
    const modal = document.createElement('div');
    modal.id = 'login-modal-favorite';
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
    modal.innerHTML = `
        <div class="bg-white rounded-2xl max-w-md w-full p-8 relative">
            <button onclick="this.closest('.fixed').remove()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Faça login para favoritar</h2>
                <p class="text-gray-600">Você precisa estar logado para adicionar produtos aos favoritos.</p>
            </div>
            
            <div class="space-y-3">
                <a href="${loginUrl}" class="block w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:shadow-lg transition-all text-center">
                    Fazer Login
                </a>
                <a href="${registerUrl}" class="block w-full px-6 py-3 border-2 border-gray-200 text-gray-700 rounded-lg font-semibold hover:border-blue-600 hover:text-blue-600 transition-all text-center">
                    Criar Conta
                </a>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Fechar ao clicar fora
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.remove();
        }
    });
};

window.showFavoriteToast = function (favorited, productName) {
    // Remover toasts anteriores
    const existingToasts = document.querySelectorAll('.favorite-toast');
    existingToasts.forEach(toast => toast.remove());
    
    const notification = document.createElement('div');
    notification.className = 'favorite-toast fixed top-24 right-4 px-6 py-4 rounded-xl shadow-2xl z-50 flex items-center gap-3 animate-fade-in-up';
    
    if (favorited) {
        notification.className += ' bg-gradient-to-r from-red-500 to-pink-500 text-white';
        notification.innerHTML = `
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <div>
                <p class="font-bold">Adicionado aos favoritos!</p>
                <p class="text-sm opacity-90">${productName}</p>
            </div>
        `;
    } else {
        notification.className += ' bg-gray-700 text-white';
        notification.innerHTML = `
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <div>
                <p class="font-bold">Removido dos favoritos</p>
                <p class="text-sm opacity-90">${productName}</p>
            </div>
        `;
    }
    
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transition = 'opacity 0.3s ease-out';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
};

// Cart System
// Função para calcular preço baseado na quantidade
window.calculatePriceForQuantity = function (quantity, basePrice, quantityPrices) {
    if (!quantityPrices || quantityPrices.length === 0) {
        return basePrice || 0;
    }

    // Encontrar a faixa de preço correspondente
    let selectedPrice = basePrice || 0;
    let selectedTier = null;

    for (let tier of quantityPrices) {
        if (quantity >= tier.min_quantity) {
            if (tier.max_quantity === null || quantity <= tier.max_quantity) {
                if (!selectedTier || tier.min_quantity > selectedTier.min_quantity) {
                    selectedTier = tier;
                    selectedPrice = tier.price;
                }
            }
        }
    }

    return selectedPrice;
};

window.addToCart = function (productId, productName, productSlug, productPrice, productImage, quantityPrices = null) {
    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const existingItem = cart.find(item => item.id === productId);

    if (existingItem) {
        existingItem.quantity += 1;
        // Recalcular preço baseado na nova quantidade
        if (existingItem.quantityPrices) {
            existingItem.price = calculatePriceForQuantity(existingItem.quantity, existingItem.basePrice, existingItem.quantityPrices);
        }
    } else {
        cart.push({
            id: productId,
            name: productName,
            slug: productSlug,
            basePrice: productPrice, // Preço base original
            price: productPrice, // Preço atual (pode mudar com quantidade)
            image: productImage,
            quantityPrices: quantityPrices || null, // Faixas de preço por quantidade
            quantity: 1,
            addedAt: new Date().toISOString()
        });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    showCartNotification();
};

window.removeFromCart = function (productId) {
    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
    cart = cart.filter(item => item.id !== productId);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    if (typeof renderCart === 'function') {
        renderCart();
    }
};

window.updateCartQuantity = function (productId, quantity) {
    if (quantity <= 0) {
        removeFromCart(productId);
        return;
    }

    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const item = cart.find(item => item.id === productId);
    if (item) {
        item.quantity = parseInt(quantity);
        
        // Recalcular preço baseado na nova quantidade
        if (item.quantityPrices && item.quantityPrices.length > 0) {
            item.price = calculatePriceForQuantity(item.quantity, item.basePrice || item.price, item.quantityPrices);
        }
        
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
        if (typeof renderCart === 'function') {
            renderCart();
        }
    }
};

window.getCart = function () {
    return JSON.parse(localStorage.getItem('cart') || '[]');
};

window.clearCart = function () {
    localStorage.removeItem('cart');
    updateCartCount();
    if (typeof renderCart === 'function') {
        renderCart();
    }
};

window.updateCartCount = function () {
    const cart = getCart();
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    const countEl = document.getElementById('cart-count');
    const countElMobile = document.getElementById('cart-count-mobile');
    
    if (countEl) {
        countEl.textContent = totalItems;
        countEl.classList.toggle('hidden', totalItems === 0);
    }
    
    if (countElMobile) {
        countElMobile.textContent = totalItems;
        countElMobile.classList.toggle('hidden', totalItems === 0);
    }
};

window.showCartNotification = function () {
    const notification = document.createElement('div');
    notification.className = 'fixed top-24 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2 animate-fade-in-up';
    notification.innerHTML = `
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span>Produto adicionado ao carrinho!</span>
    `;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transition = 'opacity 0.3s';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
};

// Initialize on page load
document.addEventListener('DOMContentLoaded', async () => {
    // Carregar favoritos apenas se estiver logado
    await refreshFavoritesUI();
    updateCartCount();
});
