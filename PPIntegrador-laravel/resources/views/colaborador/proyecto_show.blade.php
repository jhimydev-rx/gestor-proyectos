@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 space-y-6">
    {{-- Información del proyecto --}}
    <div class="bg-white shadow rounded p-6">
        <h1 class="text-3xl font-bold">{{ $proyecto->titulo }}</h1>
        <p class="text-gray-600 mt-2">{{ $proyecto->descripcion }}</p>
    </div>

    {{-- Ramas con tareas asignadas --}}
    <div class="bg-white shadow rounded p-6">
        <h2 class="text-2xl font-semibold mb-4">Tus asignaciones en este proyecto</h2>

        @if ($ramas->isEmpty())
            <p class="text-gray-500">No tienes tareas asignadas en este proyecto.</p>
        @else
            <ul class="space-y-4">
                @foreach ($ramas as $rama)
                    <li class="border rounded p-4">
                        <h3 class="font-bold text-lg">{{ $rama->nombre }}</h3>
                        <p class="text-gray-500 text-sm mb-2">{{ $rama->descripcion }}</p>

                        <ul class="list-disc list-inside text-sm text-gray-700">
                            @foreach ($rama->tareas->where('perfil_id', session('perfil_activo')) as $tarea)
                                <li>{{ $tarea->titulo }} - <span class="text-gray-500 italic">{{ $tarea->estado }}</span></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
