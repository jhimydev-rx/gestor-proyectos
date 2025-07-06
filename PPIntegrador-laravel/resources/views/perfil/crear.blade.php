@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-[#1A0033] text-white p-8 rounded-2xl shadow-2xl border-2 border-[#6A0DAD]">

    <!-- Título -->
    <h2 class="text-4xl font-extrabold mb-8 text-center text-transparent bg-clip-text bg-gradient-to-r from-[#9D4EDD] to-[#C77DFF] animate-pulse">
        <i class="fas fa-id-badge mr-2"></i> Crear perfil
    </h2>

    @if (session('error'))
        <div class="bg-red-900 border border-red-700 text-red-300 p-4 mb-4 rounded-lg shadow-md">
            {{ session('error') }}
        </div>
    @endif

    <!-- Formulario -->
    <form method="POST" action="{{ route('perfil.store') }}">
        @csrf

        <!-- Tipo de perfil -->
        <div class="mb-5">
            <label class="block mb-2 font-semibold text-[#E0AAFF]">Tipo de perfil</label>
            <select name="tipo" required
                class="w-full bg-[#2B0039] border border-[#9D4EDD] text-white p-3 rounded-xl focus:ring-2 focus:ring-[#C77DFF] transition-all duration-300"
                @if(isset($tipoPredefinido)) disabled @endif>
                <option value="">Selecciona un tipo</option>
                <option value="creador" {{ old('tipo', $tipoPredefinido ?? '') === 'creador' ? 'selected' : '' }}>Creador</option>
                <option value="colaborador" {{ old('tipo', $tipoPredefinido ?? '') === 'colaborador' ? 'selected' : '' }}>Colaborador</option>
            </select>
            @if(isset($tipoPredefinido))
                <input type="hidden" name="tipo" value="{{ $tipoPredefinido }}">
            @endif
            @error('tipo')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nombre del perfil -->
        <div class="mb-5">
            <label class="block mb-2 font-semibold text-[#E0AAFF]">Nombre del perfil</label>
            <input type="text" name="nombre_perfil" required
                class="w-full bg-[#2B0039] border border-[#9D4EDD] text-white p-3 rounded-xl focus:ring-2 focus:ring-[#C77DFF] transition-all duration-300"
                value="{{ old('nombre_perfil') }}">
            @error('nombre_perfil')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Bio -->
        <div class="mb-5">
            <label class="block mb-2 font-semibold text-[#E0AAFF]">Biografía (opcional)</label>
            <textarea name="bio" rows="4"
                class="w-full bg-[#2B0039] border border-[#9D4EDD] text-white p-3 rounded-xl focus:ring-2 focus:ring-[#C77DFF] transition-all duration-300">{{ old('bio') }}</textarea>
            @error('bio')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botón -->
        <div class="text-center mt-6">
            <button type="submit" class="btn-accion btn-crear text-base px-6 py-3">
                <i class="fas fa-plus-circle mr-2"></i> Crear Perfil
            </button>
        </div>
    </form>
</div>

<!-- Estilos de botones -->
<style>
    .btn-accion {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
        border-radius: 8px;
        padding: 8px 16px;
        transition: all 0.2s ease-in-out;
        font-size: 14px;
        border: 1.5px solid;
        background-color: #1A0033;
        text-decoration: none;
    }

    .btn-crear {
        color: #5EEAD4;
        border-color: #5EEAD4;
    }

    .btn-crear:hover {
        background-color: #5EEAD4;
        color: #1A0033;
    }

    .btn-accion i {
        font-size: 15px;
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
