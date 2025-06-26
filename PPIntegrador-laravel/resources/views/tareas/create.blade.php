@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 space-y-6 text-white">
    <h1 class="text-2xl font-bold text-violet-300">
        Crear nueva tarea para la rama: {{ $rama->nombre }}
    </h1>

    <form action="{{ route('tareas.store', $rama) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label for="titulo" class="block text-sm font-medium text-gray-300">Título</label>
            <input type="text" name="titulo" id="titulo" required
                   class="w-full mt-1 bg-gray-800 text-white border border-violet-500 rounded p-2">
        </div>

        <div>
            <label for="descripcion" class="block text-sm font-medium text-gray-300">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3"
                      class="w-full mt-1 bg-gray-800 text-white border border-violet-500 rounded p-2"></textarea>
        </div>

        <div>
            <label for="fecha_limite" class="block text-sm font-medium text-gray-300">Fecha límite</label>
            <input type="date" name="fecha_limite" id="fecha_limite"
                   class="w-full mt-1 bg-gray-800 text-white border border-violet-500 rounded p-2">
        </div>

        <div>
            <label for="archivo" class="block text-sm font-medium text-gray-300">Archivo plantilla (opcional)</label>
            <input type="file" name="archivo" id="archivo"
                   class="w-full mt-1 bg-gray-800 text-white border border-violet-500 rounded p-2">
            <p class="text-xs text-purple-300 mt-1">Puedes subir un documento o recurso base para la tarea.</p>
        </div>

        <div>
            <label for="comentario" class="block text-sm font-medium text-gray-300">Comentario (opcional)</label>
            <textarea name="comentario" id="comentario" rows="2"
                      class="w-full mt-1 bg-gray-800 text-white border border-violet-500 rounded p-2"></textarea>
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('proyectos.ramas.admin', $rama->proyecto) }}"
               class="text-violet-400 hover:text-violet-300">Cancelar</a>
            <button type="submit"
                    class="bg-violet-600 hover:bg-violet-700 text-white px-4 py-2 rounded">
                Crear tarea
            </button>
        </div>
    </form>
</div>
@endsection
