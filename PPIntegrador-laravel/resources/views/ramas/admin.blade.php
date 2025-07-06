@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 text-white">

    <h1 class="text-3xl font-bold text-[#E0AAFF] mb-6">
        <i class="fas fa-code-branch mr-2"></i> Administración de Ramas – {{ $proyecto->titulo }}
    </h1>

    <div class="flex flex-wrap gap-3 mb-6">
        <a href="{{ route('proyectos.arbol', $proyecto) }}"
           class="btn-accion btn-ver">
            <i class="fas fa-sitemap"></i> Ver Árbol
        </a>

        <a href="{{ route('ramas.create', $proyecto) }}"
           class="btn-accion btn-crear">
            <i class="fas fa-plus"></i> Nueva Rama
        </a>
    </div>

    @forelse ($ramas as $rama)
        <div class="bg-[#1A0033] border border-[#6A0DAD] rounded-xl p-6 mb-6 shadow">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-xl font-semibold text-[#E0AAFF] mb-2 flex items-center gap-2">
                        <i class="fas fa-code-branch"></i> {{ $rama->nombre }}
                    </h2>
                    <p class="text-[#C7B8E0]">{{ $rama->descripcion }}</p>
                </div>
                <span class="bg-[#2B004A] text-[#E0AAFF] px-3 py-1 rounded-full text-sm">
                    {{ $rama->tareas->count() }} tarea(s)
                </span>
            </div>

            <div class="flex flex-wrap gap-3 mt-4">
                <a href="{{ route('ramas.edit', $rama) }}" class="btn-accion btn-editar">
                    <i class="fas fa-pen-to-square"></i> Editar
                </a>

                <form action="{{ route('ramas.destroy', $rama) }}" method="POST"
                      onsubmit="return confirm('¿Eliminar esta rama y todas sus tareas?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-accion btn-eliminar">
                        <i class="fas fa-trash-can"></i> Eliminar
                    </button>
                </form>

                <a href="{{ route('tareas.create', $rama) }}" class="btn-accion btn-crear">
                    <i class="fas fa-plus-circle"></i> Nueva Tarea
                </a>
            </div>

            @if ($rama->tareas->isNotEmpty())
                <div class="mt-5 bg-[#2B0052] rounded-lg p-4 border border-[#6A0DAD]">
                    <h3 class="text-base font-semibold text-[#E0AAFF] mb-3 flex items-center gap-2">
                        <i class="fas fa-tasks"></i> Tareas de esta rama
                    </h3>
                    
                    <ul class="space-y-3">
                        @foreach ($rama->tareas as $tarea)
                            <li class="bg-[#3A006D] px-4 py-3 rounded-md border border-[#6A0DAD] hover:bg-[#4A007D] transition">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-1">
                                            <strong class="text-[#E0AAFF]">{{ $tarea->titulo }}</strong>
                                            <span class="ml-2 text-xs px-2 py-1 rounded-full 
                                                @if($tarea->estado == 'completada') bg-green-900 text-green-300
                                                @elseif($tarea->estado == 'en_proceso') bg-blue-900 text-blue-300
                                                @else bg-yellow-900 text-yellow-300 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $tarea->estado)) }}
                                            </span>
                                        </div>
                                        <p class="text-[#C7B8E0] text-xs">{{ $tarea->descripcion }}</p>
                                        <p class="text-[#9D4EDD] text-xs mt-1">
                                            <i class="far fa-calendar-alt mr-1"></i>
                                            {{ $tarea->fecha_limite ? \Carbon\Carbon::parse($tarea->fecha_limite)->format('d/m/Y') : 'Sin fecha límite' }}
                                        </p>
                                    </div>

                                    <div class="flex flex-col gap-2 items-end">
                                        <a href="{{ route('admin.tareas.show', $tarea) }}" class="btn-accion btn-ver">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>

                                        <a href="{{ route('tareas.edit', $tarea) }}" class="btn-accion btn-editar">
                                            <i class="fas fa-pen-to-square"></i> Editar
                                        </a>

                                        <form action="{{ route('tareas.destroy', $tarea) }}" method="POST"
                                              onsubmit="return confirm('¿Eliminar esta tarea?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-accion btn-eliminar">
                                                <i class="fas fa-trash-can"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <p class="text-[#C7B8E0] text-sm italic bg-[#2B0052] p-3 rounded-lg border border-[#6A0DAD] mt-4">
                    <i class="fas fa-info-circle mr-1"></i> Esta rama no tiene tareas aún.
                </p>
            @endif
        </div>
    @empty
        <div class="bg-[#1A0033] border border-[#6A0DAD] rounded-xl p-6 text-center">
            <p class="text-[#C7B8E0]">
                <i class="fas fa-info-circle mr-1"></i> Este proyecto no tiene ramas aún.
            </p>
        </div>
    @endforelse

    <!-- Botón para volver -->
    <div class="mt-10 text-center">
        <a href="{{ route('proyectos.show', $proyecto) }}" class="btn-accion btn-ver px-6 py-3 text-base">
            <i class="fas fa-arrow-left"></i> Volver al Proyecto
        </a>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Estilos personalizados de botones -->
<style>
    .btn-accion {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
        border-radius: 8px;
        padding: 8px 16px;
        transition: all 0.2s ease-in-out;
        font-size: 14px;
        border: 1.5px solid;
        background-color: #1A0033;
        text-decoration: none;
    }

    .btn-editar {
        color: #4FC3F7;
        border-color: #4FC3F7;
    }

    .btn-editar:hover {
        background-color: #4FC3F7;
        color: #1A0033;
    }

    .btn-eliminar {
        color: #FF6B6B;
        border-color: #FF6B6B;
    }

    .btn-eliminar:hover {
        background-color: #FF6B6B;
        color: #1A0033;
    }

    .btn-ver {
        color: #50FA7B;
        border-color: #50FA7B;
    }

    .btn-ver:hover {
        background-color: #50FA7B;
        color: #1A0033;
    }

    .btn-crear {
        color: #FFD60A;
        border-color: #FFD60A;
    }

    .btn-crear:hover {
        background-color: #FFD60A;
        color: #1A0033;
    }

    .btn-accion i {
        font-size: 15px;
    }
</style>
@endsection