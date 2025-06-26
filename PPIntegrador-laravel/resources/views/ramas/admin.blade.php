@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 text-white">
    <h1 class="text-3xl font-bold text-[#E0AAFF] mb-6">
        <i class="fas fa-cogs mr-2"></i> Administración de Ramas - {{ $proyecto->titulo }}
    </h1>

    <a href="{{ route('ramas.create', $proyecto) }}"
       class="bg-gradient-to-r from-purple-600 to-indigo-500 hover:from-purple-700 hover:to-indigo-600 text-white px-4 py-2 rounded-lg font-semibold shadow transition-all duration-300 mb-6 inline-block">
        <i class="fas fa-plus-circle mr-1"></i> Crear nueva rama
    </a>

    @forelse ($ramas as $rama)
        <div class="bg-[#1A0033] border border-[#9D4EDD] rounded-xl p-6 mb-4">
            <h2 class="text-2xl font-semibold text-[#C77DFF] mb-2">
                <i class="fas fa-code-branch mr-2"></i>{{ $rama->nombre }}
            </h2>
            <p class="text-[#C7B8E0] mb-4">{{ $rama->descripcion }}</p>

            <!-- Botones de acción de rama -->
            <div class="flex flex-wrap gap-3 mb-4">
                <a href="{{ route('ramas.edit', $rama) }}"
                class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm shadow transition-all duration-300">
                    <i class="fas fa-edit mr-1"></i> Editar rama
                </a>

                <form action="{{ route('ramas.destroy', $rama) }}" method="POST"
                    onsubmit="return confirm('¿Estás seguro de eliminar esta rama? Esta acción no se puede deshacer.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm shadow transition-all duration-300">
                        <i class="fas fa-trash-alt mr-1"></i> Eliminar rama
                    </button>
                </form>

                <a href="{{ route('tareas.create', $rama) }}"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm shadow transition-all duration-300">
                    <i class="fas fa-plus mr-1"></i> Agregar tarea
                </a>
            </div>

            <!-- Lista de tareas -->
            @if ($rama->tareas->isNotEmpty())
                <div class="bg-[#2B0052] rounded-lg p-4">
                    <h3 class="text-lg font-bold text-[#E0AAFF] mb-2">
                        <i class="fas fa-tasks mr-2"></i>Tareas de esta rama
                    </h3>
                    <ul class="space-y-2 text-sm text-[#A5FFD6]">
                        @foreach ($rama->tareas as $tarea)
                            <li class="flex justify-between items-center bg-[#3A006D] px-4 py-2 rounded-md border border-[#6A0DAD]">
                                <div>
                                    <strong>{{ $tarea->titulo }}</strong> <br>
                                    <span class="text-[#C7B8E0] text-xs">{{ $tarea->descripcion }}</span>
                                </div>
                                <a href="{{ route('tareas.edit', $tarea) }}"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-xs shadow">
                                    <i class="fas fa-edit mr-1"></i> Editar tarea
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <p class="text-[#C7B8E0] text-sm italic">No hay tareas aún en esta rama.</p>
            @endif
        </div>
    @empty
        <p class="text-[#C7B8E0]"><i class="fas fa-info-circle mr-1"></i>Este proyecto no tiene ramas aún.</p>
    @endforelse

    <!-- Botón para regresar al proyecto -->
    <div class="mt-10 text-center">
        <a href="{{ route('proyectos.show', $proyecto) }}"
           class="inline-block bg-gradient-to-r from-[#6A0DAD] to-[#9D4EDD] hover:from-[#7B2CBF] hover:to-[#B56EFF] text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Volver
        </a>
    </div>
</div>
@endsection