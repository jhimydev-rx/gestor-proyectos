{{-- resources/views/proyectos/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-4">Editar proyecto</h1>

    <form action="{{ route('proyectos.update', $proyecto) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold">Título</label>
            <input type="text" name="titulo" class="w-full border p-2 rounded" value="{{ old('titulo', $proyecto->titulo) }}" required>
            @error('titulo') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Descripción</label>
            <textarea name="descripcion" rows="4" class="w-full border p-2 rounded">{{ old('descripcion', $proyecto->descripcion) }}</textarea>
            @error('descripcion') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar</button>
        <a href="{{ route('proyectos.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
    </form>
</div>
@endsection
