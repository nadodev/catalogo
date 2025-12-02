@extends('layouts.dashboard')

@section('title', 'Nova Cor - Lumez')
@section('page-title', 'Nova Cor')

@section('content')
<form action="{{ route('admin.colors.store') }}" method="POST" class="space-y-6">
    @csrf
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Código Hex (opcional)</label>
                <div class="flex items-center gap-2">
                    <input type="text" name="hex_code" value="{{ old('hex_code') }}" placeholder="#000000"
                           pattern="^#[0-9A-Fa-f]{6}$"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @if(old('hex_code'))
                        <span class="w-12 h-12 rounded-lg border border-gray-300" style="background-color: {{ old('hex_code') }}"></span>
                    @endif
                </div>
                <p class="text-xs text-gray-500 mt-1">Formato: #RRGGBB (ex: #FF0000 para vermelho)</p>
                @error('hex_code')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ordem</label>
                <input type="number" name="order" value="{{ old('order', 0) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div>
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Ativo</span>
            </label>
        </div>
    </div>

    <div class="flex items-center justify-end gap-4">
        <a href="{{ route('admin.colors.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
            Cancelar
        </a>
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
            Salvar Cor
        </button>
    </div>
</form>
@endsection

