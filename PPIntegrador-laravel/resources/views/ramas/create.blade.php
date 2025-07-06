@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8 text-white">
    <div class="bg-[#1A0033] border-2 border-[#6A0DAD] rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#9D4EDD] to-[#C77DFF] mb-6 flex items-center">
            <i class="fas fa-code-branch mr-3"></i>Crear Rama para: <span class="ml-1">{{ $proyecto->titulo }}</span>
        </h1>

        <form action="{{ route('ramas.store', $proyecto) }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nombre -->
            <div>
                <label for="nombre" class="block text-sm font-semibold text-[#E0AAFF] mb-2">
                    <i class="fas fa-tag mr-1"></i>Nombre
                </label>
                <input id="nombre" name="nombre" type="text" required
                       class="w-full bg-[#1A0033] text-white border border-[#9D4EDD] rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#C77DFF] shadow-inner">
            </div>

            <!-- Descripción -->
            <div>
                <label for="descripcion" class="block text-sm font-semibold text-[#E0AAFF] mb-2">
                    <i class="fas fa-align-left mr-1"></i>Descripción
                </label>
                <textarea id="descripcion" name="descripcion" rows="4"
                          class="w-full bg-[#1A0033] text-white border border-[#9D4EDD] rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#C77DFF] shadow-inner"></textarea>
            </div>

            <!-- Botones -->
            <div class="flex justify-between items-center pt-6">
                <a href="{{ route('proyectos.ramas.admin', $proyecto) }}" class="btn-accion btn-ver">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>

                <button type="submit" class="btn-accion btn-crear">
                    <i class="fas fa-plus-circle"></i> Crear Rama
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Estilos personalizados para mantener coherencia visual -->
<style>
    .btn-accion {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
        border-radius: 8px;
        padding: 10px 18px;
        font-size: 14px;
        transition: all 0.2s ease-in-out;
        border: 1.5px solid;
        background-color: #1A0033;
        text-decoration: none;
    }

    .btn-ver {
        color: #50FA7B;
        border-color: #50FA7B;
    }

    .btn-ver:hover {
        background-color: #50FA7B;
        color: #1A0033;
    }

    .btn-crear {
        color: #FFD60A;
        border-color: #FFD60A;
    }

    .btn-crear:hover {
        background-color: #FFD60A;
        color: #1A0033;
    }

    .btn-accion i {
        font-size: 15px;
    }
</style>
@endsection