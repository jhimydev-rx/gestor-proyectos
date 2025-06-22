@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 space-y-6 text-white">
    <h1 class="text-2xl font-bold text-violet-300">Editar Tarea</h1>

    <form method="POST" action="{{ route('tareas.update', $tarea->id) }}">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-300">Título</label>
            <input type="text" name="titulo" value="{{ old('titulo', $tarea->titulo) }}"
                class="w-full mt-1 bg-gray-800 text-white border border-violet-500 rounded p-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300">Descripción</label>
            <textarea name="descripcion" rows="3"
                class="w-full mt-1 bg-gray-800 text-white border border-violet-500 rounded p-2">{{ old('descripcion', $tarea->descripcion) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300">Fecha Límite</label>
            <input type="date" name="fecha_limite" value="{{ old('fecha_limite', $tarea->fecha_limite) }}"
                class="w-full mt-1 bg-gray-800 text-white border border-violet-500 rounded p-2">
        </div>

        <div>
            <label for="colaboradores" class="block text-sm font-medium text-gray-300">Asignar Colaboradores</label>
            <select name="colaboradores[]" id="colaboradores" multiple
                class="mt-1 w-full bg-gray-800 text-white border border-violet-500 rounded p-2">
                @foreach ($colaboradores as $colaborador)
                    <option value="{{ $colaborador->id }}"
                        {{ in_array($colaborador->id, $tarea->colaboradores->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ ucfirst($colaborador->tipo) }} - {{ $colaborador->nombre_perfil }}
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-purple-300 mt-1">Usa Ctrl o Shift para seleccionar múltiples.</p>
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('proyectos.show', $tarea->rama->proyecto_id) }}"
               class="text-violet-400 hover:text-violet-300">Cancelar</a>
            <button type="submit"
                class="bg-violet-600 hover:bg-violet-700 text-white px-4 py-2 rounded">Guardar Cambios</button>
        </div>
    </form>
</div>
@endsection
