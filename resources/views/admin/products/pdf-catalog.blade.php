<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Produtos - Lumez</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            color: #1a1a1a;
            line-height: 1.4;
            font-size: 10px;
        }
        
        .header {
            background-color: #1e3a8a;
            background: #1e3a8a;
            color: #ffffff !important;
            padding: 20px 30px;
            text-align: center;
            margin-bottom: 15px;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #ffffff !important;
        }
        
        .header p {
            font-size: 11px;
            color: #ffffff !important;
            opacity: 1;
        }
        
        .category-section {
            margin-bottom: 15px;
        }
        
        .category-title {
            background: #1e3a8a;
            color: white;
            padding: 8px 15px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
            border-left: 4px solid #5b21b6;
            page-break-after: avoid;
        }
        
        .products-grid {
            width: 100%;
            margin-bottom: 12px;
        }
        
        .product-row {
            width: 100%;
            margin-bottom: 10px;
            page-break-inside: avoid;
            overflow: hidden;
        }
        
        .product-card {
            border: 1px solid #d1d5db;
            border-radius: 4px;
            padding: 8px;
            background: #ffffff;
            width: 24%;
            float: left;
            margin-right: 1.33%;
            min-height: 200px;
            page-break-inside: avoid;
            box-sizing: border-box;
        }
        
        .product-card:nth-child(4n) {
            margin-right: 0;
        }
        
        .product-row::after {
            content: "";
            display: table;
            clear: both;
        }
        
        .product-image-container {
            width: 100%;
            height: 120px;
            margin-bottom: 6px;
            overflow: hidden;
            border-radius: 3px;
            background: #f3f4f6;
            text-align: center;
            line-height: 120px;
        }
        
        .product-image {
            max-width: 95%;
            max-height: 120px;
            width: auto;
            height: auto;
            vertical-align: middle;
        }
        
        .no-image {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #e0e7ff 0%, #f3e8ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 9px;
        }
        
        .product-name {
            font-size: 9px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 2px;
            line-height: 1.1;
            min-height: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .product-code {
            font-size: 7px;
            color: #6b7280;
            margin-bottom: 2px;
        }
        
        .product-price {
            font-size: 10px;
            font-weight: bold;
            color: #059669;
            margin-top: auto;
            padding-top: 3px;
            border-top: 1px solid #e5e7eb;
        }
        
        .product-badges {
            display: flex;
            gap: 3px;
            margin-top: 4px;
            flex-wrap: wrap;
        }
        
        .badge {
            font-size: 7px;
            padding: 2px 5px;
            border-radius: 3px;
            font-weight: bold;
        }
        
        .badge-featured {
            background: #a855f7;
            color: white;
        }
        
        .badge-new {
            background: #10b981;
            color: white;
        }
        
        .badge-popular {
            background: #f59e0b;
            color: white;
        }
        
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #1e3a8a;
            text-align: center;
            color: #4b5563;
            font-size: 9px;
        }
        
        .footer-info {
            margin-top: 5px;
            line-height: 1.6;
        }
        
        .company-info {
            background: #f9fafb;
            padding: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #1e3a8a;
            font-size: 9px;
            color: #374151;
        }
        
        @page {
            margin: 8mm;
            size: A4;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        /* Evitar quebras de página dentro de cards */
        .product-card,
        .product-image-container,
        .product-name,
        .product-code,
        .product-price {
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        /* Permitir que o grid quebre naturalmente */
        .products-grid {
            page-break-inside: auto;
        }
        
        /* Evitar que categoria fique sozinha no final da página */
        .category-section {
            orphans: 3;
            widows: 3;
        }
        
        .intro-section {
            background: #f9fafb;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 4px;
            font-size: 9px;
            line-height: 1.6;
            color: #374151;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header" style="background-color: #1e3a8a; color: #ffffff;">
        <h1 style="color: #ffffff !important; font-size: 24px; font-weight: bold; margin-bottom: 5px;">CATÁLOGO DE PRODUTOS</h1>
        <p style="color: #ffffff !important; font-size: 11px; margin-bottom: 3px;">Lumez - Produtos Personalizados de Alta Qualidade</p>
        <p style="color: #ffffff !important; font-size: 9px; margin-top: 3px;">Gerado em {{ date('d/m/Y H:i') }}</p>
    </div>

    <!-- Informações da Empresa -->
    <div class="company-info">
        <strong>LUMEZ - PRODUTOS PERSONALIZADOS</strong><br>
        Email: contato@lumez.com.br | Telefone: (11) 99999-9999<br>
        Transforme sua marca com brindes e produtos corporativos exclusivos que impressionam.
    </div>

    <!-- Categorias e Produtos -->
    @foreach($categories as $index => $category)
        <div class="category-section">
            <div class="category-title">
                {{ strtoupper($category->name) }}
            </div>
            
            <div class="products-grid">
                @foreach($category->products->chunk(4) as $productRow)
                    <div class="product-row">
                        @foreach($productRow as $product)
                            <div class="product-card">
                        <!-- Imagem -->
                        <div class="product-image-container">
                            @if($product->images->count() > 0)
                                @php
                                    $imagePath = $product->images->first()->image_path;
                                    $fullPath = public_path('storage/' . $imagePath);
                                @endphp
                                @if(file_exists($fullPath))
                                    <img src="{{ $fullPath }}" 
                                         alt="{{ $product->name }}" 
                                         class="product-image"
                                         style="max-width: 95%; max-height: 120px; width: auto; height: auto; display: inline-block; vertical-align: middle;">
                                @else
                                    <div class="no-image">Sem imagem</div>
                                @endif
                            @else
                                <div class="no-image">Sem imagem</div>
                            @endif
                        </div>
                        
                        <!-- Nome -->
                        <div class="product-name">{{ $product->name }}</div>
                        
                        <!-- Código -->
                        @if($product->code)
                        <div class="product-code">Ref: {{ $product->code }}</div>
                        @endif
                        
                        <!-- Badges -->
                        @if($product->is_featured || $product->is_new || $product->is_popular)
                        <div class="product-badges">
                            @if($product->is_featured)
                                <span class="badge badge-featured">⭐</span>
                            @endif
                            @if($product->is_new)
                                <span class="badge badge-new">NOVO</span>
                            @endif
                            @if($product->is_popular)
                                <span class="badge badge-popular">🔥</span>
                            @endif
                        </div>
                        @endif
                        
                        <!-- Preço -->
                        <div class="product-price">
                            {{ $product->getPriceDisplay() }}
                        </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <!-- Footer -->
    <div class="footer">
        <div style="font-weight: bold; color: #1e3a8a; margin-bottom: 5px; font-size: 10px;">
            LUMEZ - PRODUTOS PERSONALIZADOS DE ALTA QUALIDADE
        </div>
        <div class="footer-info">
            <div><strong>Contato:</strong> contato@lumez.com.br | (11) 99999-9999</div>
            <div style="margin-top: 5px; font-size: 8px; color: #6b7280;">
                Este catálogo contém todos os produtos ativos disponíveis. Preços sujeitos a alteração sem aviso prévio.
            </div>
        </div>
    </div>
</body>
</html>
