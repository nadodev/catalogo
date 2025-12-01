@extends('layouts.app')

@section('title', 'Sobre Nós - Lumez')

@section('content')
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Sobre a Lumez</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                Transformando ideias em produtos personalizados que contam a história da sua marca.
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div class="space-y-6">
                <h2 class="text-3xl font-bold text-gray-900">Nossa História</h2>
                <div class="prose prose-lg text-gray-600">
                    <p>
                        A Lumez nasceu da paixão por criar conexões duradouras entre marcas e pessoas. Entendemos que um brinde corporativo não é apenas um objeto, mas uma ferramenta poderosa de marketing e relacionamento.
                    </p>
                    <p>
                        Com anos de experiência no mercado promocional, nos especializamos em oferecer soluções criativas e de alta qualidade para empresas de todos os portes. Nossa missão é ajudar sua marca a se destacar e ser lembrada.
                    </p>
                    <p>
                        Trabalhamos com tecnologia de ponta em personalização e uma curadoria rigorosa de produtos, garantindo que cada item entregue supere as expectativas de nossos clientes.
                    </p>
                </div>
            </div>
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-purple-500 rounded-3xl transform rotate-3 opacity-20"></div>
                <div class="relative bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center p-6 bg-blue-50 rounded-2xl">
                            <span class="block text-4xl font-bold text-blue-600 mb-2">10+</span>
                            <span class="text-sm text-gray-600 font-medium">Anos de Experiência</span>
                        </div>
                        <div class="text-center p-6 bg-purple-50 rounded-2xl">
                            <span class="block text-4xl font-bold text-purple-600 mb-2">5k+</span>
                            <span class="text-sm text-gray-600 font-medium">Clientes Atendidos</span>
                        </div>
                        <div class="text-center p-6 bg-green-50 rounded-2xl">
                            <span class="block text-4xl font-bold text-green-600 mb-2">1M+</span>
                            <span class="text-sm text-gray-600 font-medium">Produtos Entregues</span>
                        </div>
                        <div class="text-center p-6 bg-orange-50 rounded-2xl">
                            <span class="block text-4xl font-bold text-orange-600 mb-2">99%</span>
                            <span class="text-sm text-gray-600 font-medium">Satisfação</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Values -->
        <div class="mt-24">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900">Nossos Valores</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all text-center group">
                    <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Qualidade</h3>
                    <p class="text-gray-600">Compromisso inegociável com a excelência em cada produto e personalização.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all text-center group">
                    <div class="w-16 h-16 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Agilidade</h3>
                    <p class="text-gray-600">Processos otimizados para garantir entregas rápidas e dentro do prazo.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all text-center group">
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Parceria</h3>
                    <p class="text-gray-600">Construímos relacionamentos de longo prazo baseados em confiança e resultados.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
