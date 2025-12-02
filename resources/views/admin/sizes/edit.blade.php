@extends('layouts.dashboard')

@section('title', 'Editar Tamanho - Lumez')
@section('page-title', 'Editar Tamanho')

@section('content')
<form action="{{ route('admin.sizes.update', $size) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                <input type="text" name="name" value="{{ old('name', $size->name) }}" required
                       placeholder="Ex: 473 ml, P, M, G, etc."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ordem</label>
                <input type="number" name="order" value="{{ old('order', $size->order ?? 0) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div>
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $size->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Ativo</span>
            </label>
        </div>
    </div>

    <div class="flex items-center justify-end gap-4">
        <a href="{{ route('admin.sizes.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
            Cancelar
        </a>
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
            Atualizar Tamanho
        </button>
    </div>
</form>
@endsection

