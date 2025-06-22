{{-- resources/views/proyectos/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-4">Mis Proyectos</h1>

    <a href="{{ route('proyectos.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mb-6 inline-block">Crear nuevo proyecto</a>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse ($proyectos as $proyecto)
            <div class="p-4 bg-white border rounded shadow">
                <h2 class="text-xl font-semibold">{{ $proyecto->titulo }}</h2>
                <p class="text-gray-600">{{ $proyecto->descripcion }}</p>
                <div class="mt-3 flex gap-2">
                    <a href="{{ route('proyectos.show', $proyecto) }}" class="text-blue-600 hover:underline">Ver</a>
                    <a href="{{ route('proyectos.edit', $proyecto) }}" class="text-yellow-600 hover:underline">Editar</a>
                    <form action="{{ route('proyectos.destroy', $proyecto) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este proyecto?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500">No tienes proyectos aún.</p>
        @endforelse
    </div>
</div>
@endsection
