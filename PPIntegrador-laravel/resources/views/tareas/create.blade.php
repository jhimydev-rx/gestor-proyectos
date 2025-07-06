@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-white">
    <div class="bg-[#1A0033] border-2 border-[#6A0DAD] rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#9D4EDD] to-[#C77DFF] mb-6 flex items-center">
            <i class="fas fa-tasks mr-2"></i> Crear nueva tarea para la rama: {{ $rama->nombre }}
        </h1>

        <form action="{{ route('tareas.store', $rama) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <input type="hidden" name="previous_url" value="{{ old('previous_url', url()->previous()) }}">

            <!-- Título -->
            <div>
                <label for="titulo" class="block text-sm font-semibold text-[#E0AAFF] mb-1">
                    <i class="fas fa-heading mr-1 text-[#C77DFF]"></i> Título
                </label>
                <input type="text" name="titulo" id="titulo" required
                    class="w-full bg-[#2c004d] border border-[#9D4EDD] text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#C77DFF] shadow-inner" />
            </div>

            <!-- Descripción -->
            <div>
                <label for="descripcion" class="block text-sm font-semibold text-[#E0AAFF] mb-1">
                    <i class="fas fa-align-left mr-1 text-[#C77DFF]"></i> Descripción
                </label>
                <textarea name="descripcion" id="descripcion" rows="3"
                    class="w-full bg-[#2c004d] border border-[#9D4EDD] text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#C77DFF] shadow-inner"></textarea>
            </div>

            <!-- Fecha límite -->
            <div>
                <label for="fecha_limite" class="block text-sm font-semibold text-[#E0AAFF] mb-1">
                    <i class="fas fa-calendar-alt mr-1 text-[#C77DFF]"></i> Fecha límite
                </label>
                <input type="date" name="fecha_limite" id="fecha_limite"
                    class="w-full bg-[#2c004d] border border-[#9D4EDD] text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#C77DFF] shadow-inner" />
            </div>

            <!-- Botones -->
            <div class="flex justify-between items-center pt-6">
                <a href="{{ old('previous_url', url()->previous()) }}" class="btn-accion btn-ver">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>

                <button type="submit" class="btn-accion btn-crear">
                    <i class="fas fa-check-circle"></i> Crear tarea
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Estilos personalizados para botones -->
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