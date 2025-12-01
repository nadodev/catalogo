<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="login-url" content="{{ route('login') }}">
    <meta name="register-url" content="{{ route('register') }}">
    <title>@yield('title', 'Lumez - Produtos Personalizados de Alta Qualidade')</title>
    <script>
        window.userLoggedIn = @json(Auth::check());
        window.userId = @json(Auth::check() ? Auth::id() : null);
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation { animation: float 6s ease-in-out infinite; }
        .animate-float { animation: float 6s ease-in-out infinite; }
        
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px) translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateY(0) translateX(0);
            }
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.3s ease-out;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up { animation: fadeInUp 0.8s ease-out; }
        
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            letter-spacing: 0.5px;
        }
    </style>
    @stack('styles')
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');
            
            menu.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen flex flex-col">
    <!-- Top Bar - Informações de Contato -->
    <div class="bg-gray-900 text-gray-300 text-sm py-2 hidden md:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <a href="tel:+5511999999999" class="flex items-center gap-2 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>(11) 99999-9999</span>
                    </a>
                    <a href="mailto:contato@lumez.com.br" class="flex items-center gap-2 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>contato@lumez.com.br</span>
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-xs">🚚 Frete Grátis para pedidos acima de R$ 500</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Principal -->
    <header class="bg-white shadow-md sticky top-0 z-50 border-b-2 border-blue-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Primeira Linha: Logo e Ações -->
            <div class="flex items-center justify-between h-24 py-4">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group flex-shrink-0">
                    <img src="{{ asset('logo.svg') }}" 
                         alt="Lumez Logo" 
                         class="h-14 group-hover:scale-105 transition-transform duration-300">
                    <div class="hidden lg:block">
                        <div class="text-xs text-gray-500 font-medium">PRODUTOS PERSONALIZADOS</div>
                        <div class="text-sm text-gray-700 font-bold">Alta Qualidade</div>
                    </div>
                </a>
                
                <!-- Barra de Busca (Desktop) -->
                <div class="hidden lg:flex flex-1 max-w-2xl mx-8">
                    <form action="{{ route('products.index') }}" method="GET" class="w-full">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Buscar produtos..." 
                                   class="w-full px-6 py-3 pl-12 pr-4 border-2 border-gray-200 rounded-full focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all">
                            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors font-semibold text-sm">
                                Buscar
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Ações do Usuário -->
                <div class="hidden md:flex items-center gap-3">
                    <!-- Favoritos -->
                    @auth
                    <a href="{{ route('user.favorites') }}" class="relative p-3 text-gray-700 hover:text-red-500 transition-all hover:scale-105 group">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span id="favorites-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center hidden">0</span>
                        <span class="absolute -bottom-6 left-1/2 transform -translate-x-1/2 text-xs text-gray-600 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">Favoritos</span>
                    </a>
                    @endauth
                    
                    <!-- Carrinho -->
                    <a href="{{ route('cart.index') }}" class="relative p-3 text-gray-700 hover:text-blue-600 transition-all hover:scale-105 group">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span id="cart-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center hidden">0</span>
                        <span class="absolute -bottom-6 left-1/2 transform -translate-x-1/2 text-xs text-gray-600 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">Carrinho</span>
                    </a>
                    
                    <!-- Usuário -->
                    @auth
                        @if(Auth::user()->email === 'admin@lumez.com.br')
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-all text-sm">
                            Admin
                        </a>
                        @else
                        <a href="{{ route('user.dashboard') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 font-semibold transition-all text-sm flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="hidden lg:inline">Minha Conta</span>
                        </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 text-gray-700 hover:text-red-600 font-semibold transition-all text-sm">
                                Sair
                            </button>
                        </form>
                    @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 font-semibold transition-all text-sm">
                        Entrar
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-all text-sm">
                        Cadastrar
                    </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center gap-2">
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span id="cart-count-mobile" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center hidden">0</span>
                    </a>
                    <button class="p-2 text-gray-600 hover:text-blue-600" onclick="toggleMobileMenu()">
                        <svg id="menu-icon" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg id="close-icon" class="w-7 h-7 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Segunda Linha: Navegação -->
            <nav class="hidden md:flex items-center justify-center border-t border-gray-100 pt-4 pb-4">
                <div class="flex items-center gap-1">
                    <a href="{{ route('home') }}" class="px-5 py-2 text-gray-700 hover:text-blue-600 font-semibold transition-all rounded-lg hover:bg-blue-50 {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50' : '' }}">
                        Início
                    </a>
                    <a href="{{ route('products.index') }}" class="px-5 py-2 text-gray-700 hover:text-blue-600 font-semibold transition-all rounded-lg hover:bg-blue-50 {{ request()->routeIs('products.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                        Catálogo
                    </a>
                    <a href="{{ route('categories.index') }}" class="px-5 py-2 text-gray-700 hover:text-blue-600 font-semibold transition-all rounded-lg hover:bg-blue-50 {{ request()->routeIs('categories.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                        Categorias
                    </a>
                    <a href="{{ route('pages.about') }}" class="px-5 py-2 text-gray-700 hover:text-blue-600 font-semibold transition-all rounded-lg hover:bg-blue-50 {{ request()->routeIs('pages.about') ? 'text-blue-600 bg-blue-50' : '' }}">
                        Sobre Nós
                    </a>
                    <a href="{{ route('pages.contact') }}" class="px-5 py-2 text-gray-700 hover:text-blue-600 font-semibold transition-all rounded-lg hover:bg-blue-50 {{ request()->routeIs('pages.contact') ? 'text-blue-600 bg-blue-50' : '' }}">
                        Contato
                    </a>
                </div>
            </nav>
        </div>
        
        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200 shadow-lg">
            <div class="px-4 py-4 space-y-3">
                <!-- Busca Mobile -->
                <form action="{{ route('products.index') }}" method="GET" class="mb-4">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Buscar produtos..." 
                               class="w-full px-4 py-2 pl-10 pr-4 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </form>
                
                <nav class="flex flex-col space-y-2">
                    <a href="{{ route('home') }}" class="px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium rounded-lg transition-colors {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600' : '' }}">Início</a>
                    <a href="{{ route('products.index') }}" class="px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium rounded-lg transition-colors {{ request()->routeIs('products.*') ? 'bg-blue-50 text-blue-600' : '' }}">Catálogo</a>
                    <a href="{{ route('categories.index') }}" class="px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium rounded-lg transition-colors {{ request()->routeIs('categories.*') ? 'bg-blue-50 text-blue-600' : '' }}">Categorias</a>
                    <a href="{{ route('pages.about') }}" class="px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium rounded-lg transition-colors">Sobre Nós</a>
                    <a href="{{ route('pages.contact') }}" class="px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium rounded-lg transition-colors">Contato</a>
                    
                    @auth
                    <a href="{{ route('user.favorites') }}" class="px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        Favoritos
                    </a>
                    @endauth
                    
                    <a href="{{ route('quotes.create') }}" class="px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold text-center mt-4">
                        Solicitar Orçamento
                    </a>
                    
                    @auth
                    <div class="pt-4 border-t border-gray-200 mt-4">
                        <a href="{{ route('user.dashboard') }}" class="px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium rounded-lg transition-colors block">
                            Minha Conta
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button type="submit" class="w-full px-4 py-3 text-left text-red-600 hover:bg-red-50 font-medium rounded-lg transition-colors">
                                Sair
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="pt-4 border-t border-gray-200 mt-4 flex gap-2">
                        <a href="{{ route('login') }}" class="flex-1 px-4 py-3 text-center border-2 border-gray-200 text-gray-700 rounded-lg font-semibold hover:border-blue-600 hover:text-blue-600 transition-colors">
                            Entrar
                        </a>
                        <a href="{{ route('register') }}" class="flex-1 px-4 py-3 text-center bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            Cadastrar
                        </a>
                    </div>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer Premium -->
    <footer class="bg-gray-900 text-gray-300 py-16 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="relative">
                            <!-- Efeito de luz/glow -->
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-full blur-lg opacity-30"></div>
                            
                            <!-- Logo -->
                            <img src="{{ asset('logo.svg') }}" 
                                 alt="Lumez Logo" 
                                 class="relative w-[140px] object-cover">
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed">Produtos personalizados de alta qualidade para elevar sua marca.</p>
                </div>
                
                <div>
                    <h4 class="text-white font-bold mb-4 text-lg">Links Rápidos</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('products.index') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2">
                            <span>→</span> Produtos
                        </a></li>
                        <li><a href="{{ route('pages.about') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2">
                            <span>→</span> Sobre
                        </a></li>
                        <li><a href="{{ route('pages.contact') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2">
                            <span>→</span> Contato
                        </a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-bold mb-4 text-lg">Categorias</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-blue-400 transition-colors flex items-center gap-2">
                            <span>→</span> Canecas
                        </a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors flex items-center gap-2">
                            <span>→</span> Brindes
                        </a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors flex items-center gap-2">
                            <span>→</span> Corporativo
                        </a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-bold mb-4 text-lg">Contato</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            contato@lumez.com.br
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                            (11) 99999-9999
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; {{ date('Y') }} Lumez. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Premium -->
    <a href="https://wa.me/5511999999999" target="_blank" class="fixed bottom-8 right-8 z-50 group">
        <div class="relative">
            <div class="absolute inset-0 bg-green-500 rounded-full blur-xl opacity-50 group-hover:opacity-75 transition-opacity"></div>
            <div class="relative w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-all">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
            </div>
        </div>
    </a>
    @stack('scripts')
</body>
</html>