@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 mt-10 rounded shadow text-black">
    <h2 class="text-xl font-bold mb-4">Crear nueva rama para: {{ $proyecto->titulo }}</h2>

    <form action="{{ route('ramas.store', $proyecto) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="nombre" class="block text-sm font-medium">Nombre de la rama</label>
            <input type="text" name="nombre" id="nombre" required class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label for="descripcion" class="block text-sm font-medium">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3" class="w-full border px-3 py-2 rounded"></textarea>
        </div>

        <div class="mb-6">
            <label for="archivo" class="block text-sm font-medium">Archivo (opcional)</label>
            <input type="file" name="archivo" id="archivo" class="w-full mt-1">
            <p class="text-xs text-gray-600 mt-1">Puedes subir un documento o archivo relacionado a la rama (opcional).</p>
        </div>

        <div class="flex gap-4">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                Crear rama
            </button>

            <a href="{{ route('proyectos.ramas.admin', $proyecto) }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
