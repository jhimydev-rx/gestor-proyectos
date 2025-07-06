@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-12 text-white px-4">
    <!-- Título -->
    <h1 class="text-3xl font-bold mb-8 flex items-center gap-3 text-transparent bg-clip-text bg-gradient-to-r from-[#9D4EDD] to-[#C77DFF]">
        <i class="fas fa-pen-to-square"></i> Editar Proyecto
    </h1>

    <!-- Formulario -->
    <form action="{{ route('proyectos.update', $proyecto) }}" method="POST"
          class="bg-[#1A0033] border-2 border-[#6A0DAD] rounded-2xl p-8 shadow-2xl space-y-6">
        @csrf
        @method('PUT')

        <!-- Título -->
        <div>
            <label for="titulo" class="block mb-2 font-semibold text-[#E0AAFF]">
                <i class="fas fa-heading mr-1"></i> Título del proyecto
            </label>
            <input id="titulo" type="text" name="titulo" value="{{ old('titulo', $proyecto->titulo) }}"
                   class="w-full bg-[#3A006D] border border-[#9D4EDD] text-white p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C77DFF] transition duration-300"
                   required>
            @error('titulo')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Descripción -->
        <div>
            <label for="descripcion" class="block mb-2 font-semibold text-[#E0AAFF]">
                <i class="fas fa-align-left mr-1"></i> Descripción
            </label>
            <textarea id="descripcion" name="descripcion" rows="4"
                      class="w-full bg-[#3A006D] border border-[#9D4EDD] text-white p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C77DFF] transition duration-300">{{ old('descripcion', $proyecto->descripcion) }}</textarea>
            @error('descripcion')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botones -->
        <div class="flex items-center gap-4 pt-6">
            <!-- Botón Guardar -->
            <button type="submit" class="btn-accion btn-crear">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>

            <!-- Botón Cancelar -->
            <a href="{{ route('proyectos.show', $proyecto) }}" class="btn-accion btn-cancelar">
                <i class="fas fa-arrow-left"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Estilos de botones -->
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
@endsection
