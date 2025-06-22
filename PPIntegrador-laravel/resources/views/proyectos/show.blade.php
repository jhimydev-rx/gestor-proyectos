@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 space-y-6">
    <div class="bg-white shadow rounded p-6">
        <h1 class="text-3xl font-bold">{{ $proyecto->titulo }}</h1>
        <p class="text-gray-600 mt-2">{{ $proyecto->descripcion }}</p>

        <div class="mt-4 flex gap-4">
            <a href="{{ route('proyectos.edit', $proyecto) }}" class="text-blue-600 hover:underline">Editar proyecto</a>

            <form action="{{ route('proyectos.destroy', $proyecto) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este proyecto?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
            </form>
        </div>
    </div>

    {{-- Gestión de ramas --}}
    <div class="bg-white shadow rounded p-6">
        <h2 class="text-2xl font-semibold mb-4">Ramas del proyecto</h2>
        <a href="#" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 mb-4 inline-block">Crear nueva rama</a>

        <ul class="space-y-2 mt-2">
            @forelse ($proyecto->ramas as $rama)
                <li class="border p-4 rounded">
                    <strong>{{ $rama->nombre }}</strong>
                    <p class="text-sm text-gray-500">{{ $rama->descripcion }}</p>
                    {{-- Aquí se podrían agregar botones para ver tareas, editar o eliminar la rama --}}
                </li>
            @empty
                <p class="text-gray-500">Este proyecto aún no tiene ramas.</p>
            @endforelse
        </ul>
    </div>

    {{-- Colaboradores --}}
    <div class="bg-white shadow rounded p-6">
        <h2 class="text-2xl font-semibold mb-4">Colaboradores</h2>
        <a href="{{ route('proyectos.colaboradores.form', $proyecto) }}" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Agregar colaborador</a>

        <ul class="mt-4 list-disc list-inside">
            @forelse ($colaboradores as $colaborador)
                <li>
                    {{ $colaborador->nombre_perfil }}
                    <span class="text-gray-500 text-sm">({{ $colaborador->tipo }})</span>
                </li>
            @empty
                <li class="text-gray-500">No hay colaboradores aún.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
