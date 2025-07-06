@extends('layouts.app') {{-- Extiende la plantilla principal de la aplicación --}}

@section('content') {{-- Inicia la sección de contenido --}}
<div class="max-w-3xl mx-auto mt-12 text-white">

    <h1 class="text-3xl font-bold mb-8 flex items-center gap-3 text-transparent bg-clip-text bg-gradient-to-r from-[#9D4EDD] to-[#C77DFF]">
        <i class="fas fa-plus-circle"></i> Crear nuevo proyecto
    </h1>

    <form action="{{ route('proyectos.store') }}" method="POST" class="bg-[#1A0033] border-2 border-[#6A0DAD] rounded-2xl p-8 shadow-2xl">
        @csrf {{-- Protección CSRF --}}

        <!-- Campo: Título -->
        <div class="mb-6">
            <label class="block mb-2 font-semibold text-[#E0AAFF]">
                <i class="fas fa-heading mr-1"></i> Título del proyecto
            </label>
            <input type="text" name="titulo"
                   class="w-full bg-[#3A006D] border border-[#9D4EDD] text-white p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C77DFF] transition duration-300"
                   required>
            @error('titulo')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Campo: Descripción -->
        <div class="mb-6">
            <label class="block mb-2 font-semibold text-[#E0AAFF]">
                <i class="fas fa-align-left mr-1"></i> Descripción
            </label>
            <textarea name="descripcion" rows="4"
                      class="w-full bg-[#3A006D] border border-[#9D4EDD] text-white p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C77DFF] transition duration-300"></textarea>
            @error('descripcion')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botones -->
        <div class="flex items-center gap-4 mt-8">
            <!-- Guardar -->
            <button type="submit" class="btn-accion btn-crear">
                <i class="fas fa-save"></i> Guardar
            </button>

            <!-- Cancelar -->
            <a href="{{ route('proyectos.index') }}" class="btn-accion btn-cancelar">
                <i class="fas fa-arrow-left"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Estilos unificados -->
<style>
    .btn-accion {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        border-radius: 8px;
        padding: 10px 16px;
        font-size: 14px;
        transition: all 0.2s ease-in-out;
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

    .btn-cancelar {
        color: #C7B8E0;
        border-color: #C7B8E0;
    }

    .btn-cancelar:hover {
        background-color: #C7B8E0;
        color: #1A0033;
    }

    .btn-accion i {
        font-size: 15px;
    }
</style>
@endsection {{-- Finaliza la sección de contenido --}}
