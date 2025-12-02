@extends('layouts.dashboard')

@section('title', 'Editar Produto - Lumez')
@section('page-title', 'Editar Produto')

@section('content')
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $product->slug) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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

    <div class="flex items-center justify-end gap-4">
        <a href="{{ route('admin.products.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
            Cancelar
        </a>
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
            Atualizar Produto
        </button>
    </div>
</form>
@endsection

