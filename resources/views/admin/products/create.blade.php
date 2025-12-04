@extends('layouts.dashboard')

@section('title', 'Novo Produto - Lumez')
@section('page-title', 'Novo Produto')

@section('content')
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                <input type="text" name="name" id="product-name" value="{{ old('name') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                <input type="text" name="slug" id="product-slug" value="{{ old('slug') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">Gerado automaticamente a partir do nome</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Código</label>
                <input type="text" name="code" value="{{ old('code') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Categoria *</label>
                <select name="category_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Selecione...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Preço</label>
                <input type="number" name="price" step="0.01" value="{{ old('price') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ordem</label>
                <input type="number" name="order" value="{{ old('order', 0) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
            <textarea name="description" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <label class="flex items-center">
                <input type="checkbox" name="show_price" value="1" {{ old('show_price') ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Mostrar Preço</span>
            </label>

            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Ativo</span>
            </label>

            <label class="flex items-center">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Destaque</span>
            </label>

            <label class="flex items-center">
                <input type="checkbox" name="is_new" value="1" {{ old('is_new') ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Novo</span>
            </label>

            <label class="flex items-center">
                <input type="checkbox" name="is_popular" value="1" {{ old('is_popular') ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Popular</span>
            </label>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                @foreach($tags as $tag)
                <label class="flex items-center">
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
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
                    <input type="checkbox" name="materials[]" value="{{ $material->id }}"
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">{{ $material->name }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Preços por Quantidade</label>
            <div id="quantity-prices-container" class="space-y-4">
                <div class="quantity-price-item border border-gray-200 rounded-lg p-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantidade Mínima *</label>
                            <input type="number" name="quantity_prices[0][min_quantity]" min="1" value="1" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantidade Máxima (opcional)</label>
                            <input type="number" name="quantity_prices[0][max_quantity]" min="1" placeholder="Deixe vazio para sem limite"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preço *</label>
                            <input type="number" name="quantity_prices[0][price]" step="0.01" min="0" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div class="flex items-end">
                            <button type="button" onclick="this.closest('.quantity-price-item').remove()" class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 text-sm font-medium">
                                Remover
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" onclick="addQuantityPrice()" class="mt-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium">
                + Adicionar Faixa de Preço
            </button>
            <p class="text-xs text-gray-500 mt-2">Configure preços diferentes baseados na quantidade comprada (ex: 1-9 unidades = R$ 10, 10+ unidades = R$ 8)</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Variantes (Cores e Tamanhos)</label>
            <div id="variants-container" class="space-y-4">
                <div class="variant-item border border-gray-200 rounded-lg p-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cor</label>
                            <select name="variants[0][color_id]" class="variant-color w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Selecione uma cor...</option>
                                @foreach($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tamanho</label>
                            <select name="variants[0][size_id]" class="variant-size w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Selecione um tamanho...</option>
                                @foreach($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preço (opcional)</label>
                            <input type="number" name="variants[0][price]" step="0.01" placeholder="Deixe vazio para usar preço padrão"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estoque (opcional)</label>
                            <input type="number" name="variants[0][stock]" min="0" placeholder="Estoque"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    <div class="mt-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">SKU (opcional)</label>
                        <input type="text" name="variants[0][sku]" placeholder="SKU da variante"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
            </div>
            <button type="button" onclick="addVariant()" class="mt-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium">
                + Adicionar Variante
            </button>
            <p class="text-xs text-gray-500 mt-2">Adicione combinações de cores e tamanhos para este produto</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Imagens</label>
            <input type="file" name="images[]" multiple accept="image/*"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <p class="text-xs text-gray-500 mt-1">Você pode selecionar múltiplas imagens</p>
        </div>
    </div>

    @push('scripts')
    <script>
        let variantIndex = 1;
        let quantityPriceIndex = 1;
        
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
        
        function addQuantityPrice() {
            const container = document.getElementById('quantity-prices-container');
            const newPriceTier = document.createElement('div');
            newPriceTier.className = 'quantity-price-item border border-gray-200 rounded-lg p-4';
            newPriceTier.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantidade Mínima *</label>
                        <input type="number" name="quantity_prices[${quantityPriceIndex}][min_quantity]" min="1" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantidade Máxima (opcional)</label>
                        <input type="number" name="quantity_prices[${quantityPriceIndex}][max_quantity]" min="1" placeholder="Deixe vazio para sem limite"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preço *</label>
                        <input type="number" name="quantity_prices[${quantityPriceIndex}][price]" step="0.01" min="0" required
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
        
        function addVariant() {
            const container = document.getElementById('variants-container');
            const newVariant = document.createElement('div');
            newVariant.className = 'variant-item border border-gray-200 rounded-lg p-4';
            newVariant.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Variante ${variantIndex + 1}</span>
                    <button type="button" onclick="this.closest('.variant-item').remove()" class="text-red-500 hover:text-red-700 text-sm">
                        Remover
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cor</label>
                        <select name="variants[${variantIndex}][color_id]" class="variant-color w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Selecione uma cor...</option>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tamanho</label>
                        <select name="variants[${variantIndex}][size_id]" class="variant-size w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Selecione um tamanho...</option>
                            @foreach($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preço (opcional)</label>
                        <input type="number" name="variants[${variantIndex}][price]" step="0.01" placeholder="Deixe vazio para usar preço padrão"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estoque (opcional)</label>
                        <input type="number" name="variants[${variantIndex}][stock]" min="0" placeholder="Estoque"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
                <div class="mt-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">SKU (opcional)</label>
                    <input type="text" name="variants[${variantIndex}][sku]" placeholder="SKU da variante"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            `;
            container.appendChild(newVariant);
            variantIndex++;
        }
    </script>
    @endpush

    <div class="flex items-center justify-end gap-4">
        <a href="{{ route('admin.products.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
            Cancelar
        </a>
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
            Salvar Produto
        </button>
    </div>
</form>
@endsection

