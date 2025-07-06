@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-white">
    <div class="bg-[#1A0033] border-2 border-[#6A0DAD] rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#9D4EDD] to-[#C77DFF] mb-6">
            <i class="fas fa-edit mr-2"></i> Editar Tarea
        </h1>

        <form method="POST" action="{{ route('tareas.update', $tarea->id) }}">
            @csrf
            @method('PUT')

            <input type="hidden" name="previous_url" value="{{ old('previous_url', url()->previous()) }}">

            <!-- Título -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-[#C7B8E0] mb-1">
                    <i class="fas fa-heading mr-1 text-[#C77DFF]"></i> Título
                </label>
                <input type="text" name="titulo" value="{{ old('titulo', $tarea->titulo) }}"
                    class="w-full bg-[#2c004d] border border-[#9D4EDD] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#C77DFF] shadow-inner" required>
            </div>

            <!-- Descripción -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-[#C7B8E0] mb-1">
                    <i class="fas fa-align-left mr-1 text-[#C77DFF]"></i> Descripción
                </label>
                <textarea name="descripcion" rows="3"
                    class="w-full bg-[#2c004d] border border-[#9D4EDD] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#C77DFF] shadow-inner">{{ old('descripcion', $tarea->descripcion) }}</textarea>
            </div>

            <!-- Fecha límite -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-[#C7B8E0] mb-1">
                    <i class="fas fa-calendar-alt mr-1 text-[#C77DFF]"></i> Fecha Límite
                </label>
                <input type="date" name="fecha_limite" value="{{ old('fecha_limite', $tarea->fecha_limite) }}"
                    class="w-full bg-[#2c004d] border border-[#9D4EDD] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#C77DFF] shadow-inner">
            </div>

            <!-- Colaboradores -->
            <div class="mb-6">
                <label for="colaboradores" class="block text-sm font-semibold text-[#C7B8E0] mb-1">
                    <i class="fas fa-user-friends mr-1 text-[#C77DFF]"></i> Asignar Colaboradores
                </label>
                <select name="colaboradores[]" id="colaboradores" multiple
                    class="w-full bg-[#2c004d] text-white border border-[#9D4EDD] rounded-lg px-4 py-2 shadow-inner">
                    @foreach ($colaboradores as $colaborador)
                        <option value="{{ $colaborador->id }}"
                            {{ in_array($colaborador->id, $tarea->colaboradores->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ ucfirst($colaborador->tipo) }} - {{ $colaborador->nombre_perfil }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-purple-300 mt-1">
                    <i class="fas fa-keyboard mr-1"></i> Usa Ctrl o Shift para seleccionar múltiples.
                </p>
            </div>

            <!-- Botones -->
            <div class="flex justify-between items-center pt-6">
                <a href="{{ old('previous_url', url()->previous()) }}" class="btn-accion btn-ver">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>

                <button type="submit" class="btn-accion btn-editar">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Estilos de botones -->
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

    .btn-editar {
        color: #4FC3F7;
        border-color: #4FC3F7;
    }

    .btn-editar:hover {
        background-color: #4FC3F7;
        color: #1A0033;
    }

    .btn-eliminar {
        color: #FF6B6B;
        border-color: #FF6B6B;
    }

    .btn-eliminar:hover {
        background-color: #FF6B6B;
        color: #1A0033;
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