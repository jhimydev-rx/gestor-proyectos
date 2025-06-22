@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Proyectos Asignados</h1>

    @if ($proyectos->isEmpty())
        <p>No tienes proyectos asignados por el momento.</p>
    @else
        <ul class="space-y-4">
            @foreach ($proyectos as $proyecto)
                <li class="border p-4 rounded hover:bg-gray-50">
                    <h2 class="text-xl font-semibold">{{ $proyecto->titulo }}</h2>
                    <p class="text-gray-600">{{ $proyecto->descripcion }}</p>
                    <a href="{{ route('colaborador.proyectos.show', $proyecto) }}" class="text-blue-600 hover:underline font-semibold text-sm mt-2 inline-block">
                        Ver proyecto
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
