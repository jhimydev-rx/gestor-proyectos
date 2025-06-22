@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10 text-white">
    <h1 class="text-2xl font-bold text-[#E0AAFF] mb-4">
        <i class="fas fa-edit mr-2"></i>Editar Rama
    </h1>

    <form method="POST" action="{{ route('ramas.update', $rama) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $rama->nombre) }}"
                class="w-full bg-[#1A0033] text-white border border-[#9D4EDD] rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Descripción</label>
            <textarea name="descripcion" rows="3"
                class="w-full bg-[#1A0033] text-white border border-[#9D4EDD] rounded p-2">{{ old('descripcion', $rama->descripcion) }}</textarea>
        </div>

        <button type="submit"
            class="bg-[#6A0DAD] hover:bg-[#7B2CBF] text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300">
            Guardar cambios
        </button>
    </form>
</div>
@endsection
