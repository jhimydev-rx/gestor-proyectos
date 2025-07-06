@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 space-y-6 text-white">
    {{-- Información del proyecto --}}
    <div class="bg-[#1A0033] border border-[#6A0DAD] shadow-lg rounded-xl p-6">
        <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#9D4EDD] to-[#C77DFF]">
            <i class="fas fa-folder-open mr-2"></i>{{ $proyecto->titulo }}
        </h1>
        <p class="text-[#C7B8E0] mt-2">
            <i class="fas fa-align-left mr-2"></i>{{ $proyecto->descripcion }}
        </p>
    </div>

    <a href="{{ url('/colaborador/proyectos') }}" class="btn-accion btn-ver mt-6 inline-flex">
        <i class="fas fa-arrow-left"></i> Volver a Mis Proyectos Asignados
    </a>

    {{-- Filtros --}}
    <div class="bg-[#1A0033] border border-[#6A0DAD] shadow-lg rounded-xl p-6">
        <h2 class="text-xl font-bold text-[#E0AAFF] mb-4">
            <i class="fas fa-filter mr-2"></i>Filtrar Tareas
        </h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('colaborador.proyectos.show', $proyecto) }}" 
               class="btn-accion {{ !request('estado') ? 'btn-ver' : '' }}">
               <i class="fas fa-list-ul"></i> Todas
            </a>
            <a href="{{ route('colaborador.proyectos.show', $proyecto) }}?estado=pendiente" 
               class="btn-accion {{ request('estado') == 'pendiente' ? 'btn-crear' : '' }}">
               <i class="fas fa-hourglass-start"></i> Pendientes
            </a>
            <a href="{{ route('colaborador.proyectos.show', $proyecto) }}?estado=en_proceso" 
               class="btn-accion {{ request('estado') == 'en_proceso' ? 'btn-editar' : '' }}">
               <i class="fas fa-spinner"></i> En proceso
            </a>
            <a href="{{ route('colaborador.proyectos.show', $proyecto) }}?estado=completada" 
               class="btn-accion {{ request('estado') == 'completada' ? 'btn-ver' : '' }}">
               <i class="fas fa-check-circle"></i> Completadas
            </a>
        </div>
    </div>

    {{-- Ramas con tareas asignadas --}}
    <div class="bg-[#1A0033] border border-[#6A0DAD] shadow-lg rounded-xl p-6">
        <h2 class="text-2xl font-bold text-[#E0AAFF] mb-4">
            <i class="fas fa-tasks mr-2"></i>Tus asignaciones en este proyecto
        </h2>

        @if ($ramas->isEmpty())
            <p class="text-[#C7B8E0]">
                <i class="fas fa-info-circle mr-2"></i>No tienes tareas asignadas en este proyecto.
            </p>
        @else
            <ul class="space-y-6">
                @foreach ($ramas as $rama)
                    @php
                        $tareas = $tareasPorRama[$rama->id] ?? collect();
                        if(request('estado')) {
                            $tareas = $tareas->where('estado', request('estado'));
                        }
                    @endphp

                    @if($tareas->isNotEmpty())
                    <li class="bg-[#1A0033] border border-[#9D4EDD] rounded-xl p-5 hover:bg-[#2B0052] transition-all duration-300">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-[#C77DFF]">
                                    <i class="fas fa-code-branch mr-2"></i>{{ $rama->nombre }}
                                </h3>
                                <p class="text-sm text-[#E0AAFF] mb-3">
                                    <i class="fas fa-quote-left mr-1 text-xs"></i>{{ $rama->descripcion }}
                                </p>
                            </div>
                            <span class="text-xs bg-[#6A0DAD] text-[#E0AAFF] px-2 py-1 rounded-full">
                                {{ $tareas->count() }} tarea(s)
                            </span>
                        </div>

                        <div class="space-y-3 mt-3">
                            @foreach ($tareas as $tarea)
                                <div class="border-l-4 rounded-r-lg p-4 flex justify-between items-center
                                    @if($tarea->estado == 'completada') 
                                        bg-green-900/30 border-green-500
                                    @elseif($tarea->estado == 'en_proceso') 
                                        bg-blue-900/30 border-blue-500
                                    @else 
                                        bg-yellow-900/30 border-yellow-500
                                    @endif
                                    hover:shadow-lg transition-all duration-200">
                                    
                                    <div>
                                        <h4 class="font-medium text-[#E0AAFF]">{{ $tarea->titulo }}</h4>
                                        <div class="flex items-center mt-1 space-x-3 text-xs text-[#C7B8E0]">
                                            <span>
                                                <i class="far fa-calendar-alt mr-1"></i>
                                                {{ $tarea->fecha_limite ? $tarea->fecha_limite->format('d M Y') : 'Sin fecha límite' }}
                                            </span>
                                            <span class="opacity-50">|</span>
                                            <span>
                                                <i class="far fa-clock mr-1"></i>
                                                {{ $tarea->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs px-3 py-1 rounded-full font-medium
                                            @if($tarea->estado == 'completada') 
                                                bg-green-700 text-green-100
                                            @elseif($tarea->estado == 'en_proceso') 
                                                bg-blue-700 text-blue-100
                                            @else 
                                                bg-yellow-700 text-yellow-100
                                            @endif">
                                            {{ ucfirst($tarea->estado) }}
                                        </span>
                                        <a href="{{ route('tareas.show', $tarea) }}" class="btn-accion btn-ver text-sm">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </li>
                    @endif
                @endforeach
            </ul>
        @endif
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

{{-- Botones personalizados --}}
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