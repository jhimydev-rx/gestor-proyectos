@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Crear perfil</h2>

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('perfil.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Tipo de perfil --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Tipo de perfil</label>

            <select name="tipo" required class="w-full border border-gray-300 p-2 rounded"
                    @if(isset($tipoPredefinido)) disabled @endif>
                <option value="">Selecciona un tipo</option>
                <option value="creador"
                    {{ old('tipo', $tipoPredefinido ?? '') === 'creador' ? 'selected' : '' }}>
                    Creador
                </option>
                <option value="colaborador"
                    {{ old('tipo', $tipoPredefinido ?? '') === 'colaborador' ? 'selected' : '' }}>
                    Colaborador
                </option>
            </select>

            {{-- Campo oculto si está deshabilitado --}}
            @if(isset($tipoPredefinido))
                <input type="hidden" name="tipo" value="{{ $tipoPredefinido }}">
            @endif

            @error('tipo')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nombre del perfil --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Nombre del perfil</label>
            <input type="text" name="nombre_perfil" required
                   class="w-full border border-gray-300 p-2 rounded"
                   value="{{ old('nombre_perfil') }}">
            @error('nombre_perfil')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Bio --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Biografía (opcional)</label>
            <textarea name="bio" rows="3"
                      class="w-full border border-gray-300 p-2 rounded">{{ old('bio') }}</textarea>
            @error('bio')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Foto --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Foto de perfil (opcional)</label>
            <input type="file" name="foto" accept="image/*"
                   class="w-full border border-gray-300 p-2 rounded">
            @error('foto')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Botón --}}
        <div class="text-center">
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Crear Perfil
            </button>
        </div>
    </form>
</div>
@endsection
