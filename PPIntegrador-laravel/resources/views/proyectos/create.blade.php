{{-- resources/views/proyectos/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-4">Crear nuevo proyecto</h1>

    <form action="{{ route('proyectos.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold">Título</label>
            <input type="text" name="titulo" class="w-full border p-2 rounded" required>
            @error('titulo') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Descripción</label>
            <textarea name="descripcion" rows="4" class="w-full border p-2 rounded"></textarea>
            @error('descripcion') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Crear</button>
        <a href="{{ route('proyectos.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
    </form>
</div>
@endsection
