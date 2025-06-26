@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <!-- Crear Rama -->
    <div class="bg-[#1A0033] rounded-xl border border-[#6A0DAD] shadow-lg p-6">
        <h1 class="text-2xl font-bold text-[#E0AAFF] mb-6 flex items-center">
            <i class="fas fa-code-branch mr-2"></i>Crear Rama para: {{ $proyecto->titulo }}
        </h1>

        <form action="{{ route('ramas.store', $proyecto) }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2 text-[#E0AAFF]">Nombre</label>
                <input type="text" name="nombre" required
                       class="w-full bg-[#1A0033] text-white border border-[#9D4EDD] rounded-lg p-3 focus:ring-2 focus:ring-[#9D4EDD] focus:border-transparent">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2 text-[#E0AAFF]">Descripción</label>
                <textarea name="descripcion" rows="4"
                          class="w-full bg-[#1A0033] text-white border border-[#9D4EDD] rounded-lg p-3 focus:ring-2 focus:ring-[#9D4EDD] focus:border-transparent"></textarea>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('proyectos.ramas.admin', $proyecto) }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>Cancelar
                </a>

                <button type="submit"
                        class="bg-[#6A0DAD] hover:bg-[#7B2CBF] text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i>Crear Rama
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
