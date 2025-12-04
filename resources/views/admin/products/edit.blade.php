@extends('layouts.dashboard')

@section('title', 'Editar Produto - Lumez')
@section('page-title', 'Editar Produto')

@section('content')
@if($errors->any())
<div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-red-800">Erros de Validação</h3>
            <div class="mt-2 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endif

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="product-edit-form" data-product-id="{{ $product->id }}">
    @csrf
    @method('PUT')
    <input type="hidden" name="_update" value="1">
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                <input type="text" name="name" id="product-name" value="{{ old('name', $product->name) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                <input type="text" name="slug" id="product-slug" value="{{ old('slug', $product->slug) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">Gerado automaticamente a partir do nome</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Código</label>
                <input type="text" name="code" value="{{ old('code', $product->code) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Categoria *</label>
                <select name="category_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Preço</label>
                <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ordem</label>
                <input type="number" name="order" value="{{ old('order', $product->order ?? 0) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
            <textarea name="description" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <label class="flex items-center">
                <input type="checkbox" name="show_price" value="1" {{ old('show_price', $product->show_price) ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Mostrar Preço</span>
            </label>

            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Ativo</span>
            </label>

            <label class="flex items-center">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Destaque</span>
            </label>

            <label class="flex items-center">
                <input type="checkbox" name="is_new" value="1" {{ old('is_new', $product->is_new) ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Novo</span>
            </label>

            <label class="flex items-center">
                <input type="checkbox" name="is_popular" value="1" {{ old('is_popular', $product->is_popular) ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Popular</span>
            </label>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                @foreach($tags as $tag)
                <label class="flex items-center">
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ $product->tags->contains($tag->id) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">{{ $tag->name }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Materiais</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                @foreach($materials as $material)
                <label class="flex items-center">
                    <input type="checkbox" name="materials[]" value="{{ $material->id }}" {{ $product->materials->contains($material->id) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">{{ $material->name }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Preços por Quantidade</label>
            <div id="quantity-prices-container" class="space-y-4">
                @if($product->allQuantityPrices->count() > 0)
                    @foreach($product->allQuantityPrices as $index => $priceTier)
                    <div class="quantity-price-item border border-gray-200 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Quantidade Mínima *</label>
                                <input type="number" name="quantity_prices[{{ $index }}][min_quantity]" min="1" value="{{ $priceTier->min_quantity }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Quantidade Máxima (opcional)</label>
                                <input type="number" name="quantity_prices[{{ $index }}][max_quantity]" min="1" value="{{ $priceTier->max_quantity }}" placeholder="Deixe vazio para sem limite"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Preço *</label>
                                <input type="number" name="quantity_prices[{{ $index }}][price]" step="0.01" min="0" value="{{ $priceTier->price }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div class="flex items-end">
                                <button type="button" onclick="this.closest('.quantity-price-item').remove()" class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 text-sm font-medium">
                                    Remover
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="quantity-price-item border border-gray-200 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Quantidade Mínima *</label>
                                <input type="number" name="quantity_prices[0][min_quantity]" min="1" value="1"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Quantidade Máxima (opcional)</label>
                                <input type="number" name="quantity_prices[0][max_quantity]" min="1" placeholder="Deixe vazio para sem limite"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Preço *</label>
                                <input type="number" name="quantity_prices[0][price]" step="0.01" min="0"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div class="flex items-end">
                                <button type="button" onclick="this.closest('.quantity-price-item').remove()" class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 text-sm font-medium">
                                    Remover
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <button type="button" onclick="addQuantityPrice()" class="mt-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium">
                + Adicionar Faixa de Preço
            </button>
            <p class="text-xs text-gray-500 mt-2">Configure preços diferentes baseados na quantidade comprada (ex: 1-9 unidades = R$ 10, 10+ unidades = R$ 8)</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Variantes Existentes</label>
            <div id="variants-container" class="space-y-4">
                @foreach($product->variants as $index => $variant)
                <div class="variant-item border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Variante {{ $index + 1 }}</span>
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="variants[{{ $variant->id }}][delete]" value="1" 
                                   class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                            <span class="text-red-500 hover:text-red-700">Marcar para excluir</span>
                        </label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cor</label>
                            <select name="variants[{{ $variant->id }}][color_id]" class="variant-color w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Selecione uma cor...</option>
                                @foreach($colors as $color)
                                    <option value="{{ $color->id }}" {{ $variant->color_id == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tamanho</label>
                            <select name="variants[{{ $variant->id }}][size_id]" class="variant-size w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Selecione um tamanho...</option>
                                @foreach($sizes as $size)
                                    <option value="{{ $size->id }}" {{ $variant->size_id == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preço (opcional)</label>
                            <input type="number" name="variants[{{ $variant->id }}][price]" step="0.01" min="0" value="{{ $variant->price }}"
                                   placeholder="Preço específico desta combinação"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">Deixe vazio para usar o preço padrão do produto</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estoque (opcional)</label>
                            <input type="number" name="variants[{{ $variant->id }}][stock]" min="0" value="{{ $variant->stock }}"
                                   placeholder="Estoque"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">SKU (opcional)</label>
                            <input type="text" name="variants[{{ $variant->id }}][sku]" value="{{ $variant->sku }}"
                                   placeholder="SKU da variante"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Imagem da Variante (opcional)</label>
                            @if($variant->image_path)
                            <div class="mb-2">
                                <img src="{{ $variant->image_url }}" alt="Imagem da variante" class="w-20 h-20 object-cover rounded-lg border border-gray-300">
                                <p class="text-xs text-gray-500 mt-1">Imagem atual</p>
                            </div>
                            @endif
                            <input type="file" name="variants[{{ $variant->id }}][image]" accept="image/*"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">Deixe vazio para manter a imagem atual ou selecione uma nova</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addVariant()" class="mt-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium">
                + Adicionar Nova Variante
            </button>
            <p class="text-xs text-gray-500 mt-2">
                <strong>Dica:</strong> Você pode editar as variantes existentes ou adicionar novas. Cada combinação pode ter um preço e imagem diferentes!
            </p>
        </div>

        @if($product->images->count() > 0)
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Imagens Atuais</label>
            <div class="grid grid-cols-4 gap-4">
                @foreach($product->images as $image)
                <div class="relative">
                    <img src="{{ $image->url }}" alt="Imagem" class="w-full h-32 object-cover rounded-lg">
                    <a href="{{ route('admin.products.delete-image', $image->id) }}" 
                       onclick="return confirm('Tem certeza?')"
                       class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full hover:bg-red-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Adicionar Novas Imagens</label>
            <input type="file" name="images[]" multiple accept="image/*"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
    </div>

    @push('scripts')
    <script>
        let quantityPriceIndex = {{ $product->allQuantityPrices->count() }};
        
        // Função para gerar slug a partir do texto
        function generateSlug(text) {
            return text
                .toString()
                .toLowerCase()
                .trim()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '') // Remove acentos
                .replace(/\s+/g, '-') // Substitui espaços por hífens
                .replace(/[^\w\-]+/g, '') // Remove caracteres especiais
                .replace(/\-\-+/g, '-') // Remove múltiplos hífens
                .replace(/^-+/, '') // Remove hífens do início
                .replace(/-+$/, ''); // Remove hífens do fim
        }
        
        // Gerar slug automaticamente quando o nome for digitado
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('product-name');
            const slugInput = document.getElementById('product-slug');
            let slugManuallyEdited = false;
            
            // Verificar se a slug já foi editada manualmente (ao carregar a página)
            if (slugInput.value && slugInput.value !== generateSlug(nameInput.value)) {
                slugManuallyEdited = true;
            }
            
            // Gerar slug quando o nome for digitado
            nameInput.addEventListener('input', function() {
                if (!slugManuallyEdited) {
                    slugInput.value = generateSlug(this.value);
                }
            });
            
            // Marcar que a slug foi editada manualmente se o usuário digitar diretamente
            slugInput.addEventListener('input', function() {
                slugManuallyEdited = true;
            });
            
            // Se a slug estiver vazia, gerar automaticamente
            if (!slugInput.value && nameInput.value) {
                slugInput.value = generateSlug(nameInput.value);
            }
        });
        
        let variantIndex = {{ $product->variants->count() }};
        
        function addVariant() {
            const container = document.getElementById('variants-container');
            const newVariant = document.createElement('div');
            newVariant.className = 'variant-item border border-gray-200 rounded-lg p-4';
            newVariant.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Nova Variante ${variantIndex + 1}</span>
                    <button type="button" onclick="this.closest('.variant-item').remove()" class="text-red-500 hover:text-red-700 text-sm">
                        Remover
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cor</label>
                        <select name="variants[new_${variantIndex}][color_id]" class="variant-color w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Selecione uma cor...</option>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tamanho</label>
                        <select name="variants[new_${variantIndex}][size_id]" class="variant-size w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Selecione um tamanho...</option>
                            @foreach($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preço (opcional)</label>
                        <input type="number" name="variants[new_${variantIndex}][price]" step="0.01" min="0" placeholder="Preço específico desta combinação"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Deixe vazio para usar o preço padrão do produto</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estoque (opcional)</label>
                        <input type="number" name="variants[new_${variantIndex}][stock]" min="0" placeholder="Estoque"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
                <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">SKU (opcional)</label>
                        <input type="text" name="variants[new_${variantIndex}][sku]" placeholder="SKU da variante"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Imagem da Variante (opcional)</label>
                        <input type="file" name="variants[new_${variantIndex}][image]" accept="image/*"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Imagem específica desta combinação de cor/tamanho</p>
                    </div>
                </div>
            `;
            container.appendChild(newVariant);
            variantIndex++;
        }
        
        function addQuantityPrice() {
            const container = document.getElementById('quantity-prices-container');
            const newPriceTier = document.createElement('div');
            newPriceTier.className = 'quantity-price-item border border-gray-200 rounded-lg p-4';
            newPriceTier.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantidade Mínima *</label>
                        <input type="number" name="quantity_prices[${quantityPriceIndex}][min_quantity]" min="1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantidade Máxima (opcional)</label>
                        <input type="number" name="quantity_prices[${quantityPriceIndex}][max_quantity]" min="1" placeholder="Deixe vazio para sem limite"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preço *</label>
                        <input type="number" name="quantity_prices[${quantityPriceIndex}][price]" step="0.01" min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div class="flex items-end">
                        <button type="button" onclick="this.closest('.quantity-price-item').remove()" class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 text-sm font-medium">
                            Remover
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(newPriceTier);
            quantityPriceIndex++;
        }
    </script>
    @endpush

    <div class="flex items-center justify-end gap-4">
        <a href="{{ route('admin.products.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
            Cancelar
        </a>
        <button type="submit" id="submit-btn" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold" form="product-edit-form">
            Atualizar Produto
        </button>
    </div>
</form>

{{-- JavaScript removido temporariamente para teste --}}
@push('scripts')
<script>
    // TESTE: Verificar se o formulário está sendo submetido
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('product-edit-form');
        const btn = document.getElementById('submit-btn');
        
        // IMPORTANTE: Adicionar listeners nos formulários de delete de imagem ANTES do listener principal
        // Isso garante que eles não sejam interceptados
        // Usar setTimeout para garantir que os formulários já existam no DOM
        setTimeout(function() {
            document.querySelectorAll('.delete-image-form').forEach(function(deleteForm) {
                console.log('🔒 Protegendo formulário de delete de imagem:', deleteForm.action);
                
                // Salvar a action original ANTES de qualquer listener
                const originalAction = deleteForm.action;
                
                // Adicionar listener com capture phase para garantir execução primeiro
                deleteForm.addEventListener('submit', function(e) {
                    console.log('✅ Formulário de delete de imagem - deixando passar normalmente:', deleteForm.action);
                    
                    // Garantir que a action não foi alterada - restaurar se necessário
                    if (deleteForm.action !== originalAction) {
                        console.warn('⚠️ Action foi alterada! Restaurando:', deleteForm.action, '->', originalAction);
                        deleteForm.action = originalAction;
                    }
                    
                    // Garantir que o evento não seja interceptado pelo form principal
                    e.stopImmediatePropagation(); // Para todos os outros listeners
                    e.stopPropagation(); // Para propagação
                    // NÃO fazer preventDefault - deixar o evento seguir normalmente
                }, true); // Usar capture phase para garantir que seja executado primeiro
            });
        }, 100);
        
        if (form && btn) {
            console.log('✅ Formulário encontrado:', form.action);
            
            // Listener no botão
            btn.addEventListener('click', function(e) {
                console.log('🖱️ Botão clicado!');
            });
            
            // Listener no formulário - IMPORTANTE: verificar ANTES de qualquer coisa
            // Usar bubble phase (false) para não interferir com forms filhos
            form.addEventListener('submit', function(e) {
                const targetForm = e.target;
                
                // VERIFICAÇÃO CRÍTICA: Se não é o formulário principal (por ID), deixar passar imediatamente
                // Esta é a verificação mais importante - se o target não é o form principal, não fazer nada
                if (targetForm !== form || (targetForm && targetForm.id !== 'product-edit-form')) {
                    console.log('⚠️ Submit de formulário diferente - deixando passar:', {
                        target: targetForm?.id || 'N/A',
                        action: targetForm?.action || 'N/A',
                        isMainForm: targetForm === form
                    });
                    // NÃO fazer preventDefault nem stopPropagation - deixar o evento seguir normalmente
                    return; // Deixar o submit normal acontecer (ex: delete de imagem)
                }
                
                // SEGUNDA VERIFICAÇÃO: Se o formulário tem data-form-type="delete-image", deixar passar
                if (targetForm && targetForm.dataset.formType === 'delete-image') {
                    console.log('⚠️ Submit de formulário delete-image (data-form-type) - deixando passar:', targetForm.action);
                    return; // Deixar o submit normal acontecer
                }
                
                // TERCEIRA VERIFICAÇÃO: Se o formulário tem action de delete-image, deixar passar
                if (targetForm && targetForm.action && targetForm.action.includes('delete-image')) {
                    console.log('⚠️ Submit de formulário delete-image (action) - deixando passar:', targetForm.action);
                    return; // Deixar o submit normal acontecer
                }
                
                // QUARTA VERIFICAÇÃO: Se tem método DELETE e não tem flag _update, pode ser delete de imagem
                const checkMethodInput = targetForm.querySelector('input[name="_method"]');
                if (checkMethodInput && checkMethodInput.value === 'DELETE' && !targetForm.querySelector('input[name="_update"]')) {
                    console.log('⚠️ Submit com método DELETE sem flag _update - deixando passar (delete imagem)');
                    return; // Deixar o submit normal acontecer
                }
                
                // QUINTA VERIFICAÇÃO: Se tem classe delete-image-form, deixar passar
                if (targetForm && targetForm.classList.contains('delete-image-form')) {
                    console.log('⚠️ Submit de formulário delete-image (classe) - deixando passar:', targetForm.action);
                    return; // Deixar o submit normal acontecer
                }
                
                // Se chegou aqui, é o formulário principal
                // PREVENIR submit temporariamente para garantir correções
                e.preventDefault();
                e.stopPropagation();
                
                console.log('📤 FORMULÁRIO PRINCIPAL SUBMETIDO - PREVENIDO TEMPORARIAMENTE!');
                console.log('Action ANTES:', form.action);
                console.log('Method:', form.method);
                
                // FORÇAR método PUT - CRÍTICO
                let methodInput = form.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    form.appendChild(methodInput);
                }
                // SEMPRE forçar PUT, não importa o que estava antes
                methodInput.value = 'PUT';
                console.log('✅ _method FORÇADO para PUT:', methodInput.value);
                
                // REMOVER qualquer input _method com valor DELETE APENAS do formulário principal
                // NÃO remover dos formulários de delete de imagem (eles precisam do DELETE)
                // Usar apenas form.querySelectorAll para pegar apenas inputs dentro do form principal
                const formMethodInputs = form.querySelectorAll('input[name="_method"]');
                formMethodInputs.forEach(function(input) {
                    // Verificar se o input está diretamente no form principal (não em um form filho)
                    if (input.value === 'DELETE' && input.closest('form') === form) {
                        console.warn('⚠️ Removendo input _method com valor DELETE do formulário principal!');
                        input.remove();
                    }
                });
                
                // Garantir que o campo _update existe
                if (!form.querySelector('input[name="_update"]')) {
                    const updateInput = document.createElement('input');
                    updateInput.type = 'hidden';
                    updateInput.name = '_update';
                    updateInput.value = '1';
                    form.appendChild(updateInput);
                }
                
                // GARANTIR que a action está correta (deve terminar com /update)
                // IMPORTANTE: Só fazer isso se for realmente o formulário principal
                // VERIFICAÇÕES MÚLTIPLAS para garantir que não alteramos formulários de delete
                const productId = form.dataset.productId || form.querySelector('input[name="product_id"]')?.value;
                const currentAction = form.action;
                
                // VERIFICAÇÃO CRÍTICA: Se a action contém delete-image, NÃO ALTERAR
                if (currentAction.includes('delete-image')) {
                    console.log('⚠️ Action é de delete-image - NÃO alterar!');
                    return; // Sair imediatamente - não processar mais nada
                }
                
                // VERIFICAÇÃO: Se o formulário tem classe delete-image-form, NÃO ALTERAR
                if (form.classList.contains('delete-image-form')) {
                    console.log('⚠️ Formulário tem classe delete-image-form - NÃO alterar!');
                    return; // Sair imediatamente
                }
                
                // VERIFICAÇÃO: Se o formulário tem data-form-type="delete-image", NÃO ALTERAR
                if (form.dataset.formType === 'delete-image') {
                    console.log('⚠️ Formulário tem data-form-type="delete-image" - NÃO alterar!');
                    return; // Sair imediatamente
                }
                
                // Se chegou aqui, é seguro alterar a action
                let expectedAction = currentAction;
                
                if (!currentAction.includes('/update')) {
                    expectedAction = currentAction.replace(/\/products\/\d+$/, '/update');
                }
                
                if (form.action !== expectedAction) {
                    form.action = expectedAction;
                    console.log('✅ Action corrigida para:', form.action);
                }
                
                // Limpar faixas de preço completamente vazias ANTES de enviar
                document.querySelectorAll('.quantity-price-item').forEach(function(item) {
                    const minQty = item.querySelector('input[name*="[min_quantity]"]');
                    const price = item.querySelector('input[name*="[price]"]');
                    if ((!minQty || !minQty.value || minQty.value === '') && 
                        (!price || !price.value || price.value === '')) {
                        console.log('Removendo faixa de preço vazia');
                        item.remove();
                    }
                });
                
                // Mudar botão
                btn.disabled = true;
                btn.innerHTML = 'Salvando...';
                
                console.log('✅ Formulário validado ANTES de enviar:', {
                    action: form.action,
                    method: form.method,
                    _method: methodInput.value,
                    product_id: productId,
                    all_method_inputs: Array.from(form.querySelectorAll('input[name="_method"]')).map(i => i.value)
                });
                
                // AGORA enviar o formulário manualmente
                setTimeout(function() {
                    // Verificar uma última vez antes de enviar que é realmente o form principal
                    if (form.id !== 'product-edit-form') {
                        console.error('❌ ERRO: Não é o formulário principal!');
                        return;
                    }
                    
                    // Verificar uma última vez antes de enviar
                    const finalMethodInput = form.querySelector('input[name="_method"]');
                    if (finalMethodInput && finalMethodInput.value !== 'PUT') {
                        console.error('❌ ERRO: _method ainda não é PUT! Forçando novamente...');
                        finalMethodInput.value = 'PUT';
                    }
                    
                    // Garantir que a action não foi alterada para delete-image
                    if (form.action.includes('delete-image')) {
                        console.error('❌ ERRO: Action foi alterada incorretamente para delete-image!');
                        return;
                    }
                    
                    console.log('🚀 Enviando formulário com:', {
                        action: form.action,
                        _method: finalMethodInput?.value
                    });
                    
                    // Enviar usando submit nativo
                    form.submit();
                }, 100);
            }, false); // false = usar bubble phase (não capture) para não interferir com forms filhos
        } else {
            console.error('❌ Formulário ou botão não encontrado!');
        }
    });
</script>
@endpush
@endsection

