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

    {{-- Filtros --}}
    <div class="bg-[#1A0033] border border-[#6A0DAD] shadow-lg rounded-xl p-6">
        <h2 class="text-xl font-bold text-[#E0AAFF] mb-4">
            <i class="fas fa-filter mr-2"></i>Filtrar Tareas
        </h2>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('colaborador.proyectos.show', $proyecto) }}" 
               class="px-4 py-2 rounded-full text-sm font-medium {{ !request('estado') ? 'bg-[#9D4EDD] text-white' : 'bg-[#2B0052] text-[#C7B8E0] hover:bg-[#3C0063]' }}">
               Todas las tareas
            </a>
            <a href="{{ route('colaborador.proyectos.show', $proyecto) }}?estado=pendiente" 
               class="px-4 py-2 rounded-full text-sm font-medium {{ request('estado') == 'pendiente' ? 'bg-yellow-600 text-white' : 'bg-[#2B0052] text-yellow-300 hover:bg-[#3C0063]' }}">
               Pendientes
            </a>
            <a href="{{ route('colaborador.proyectos.show', $proyecto) }}?estado=en_proceso" 
               class="px-4 py-2 rounded-full text-sm font-medium {{ request('estado') == 'en_proceso' ? 'bg-blue-600 text-white' : 'bg-[#2B0052] text-blue-300 hover:bg-[#3C0063]' }}">
               En proceso
            </a>
            <a href="{{ route('colaborador.proyectos.show', $proyecto) }}?estado=completada" 
               class="px-4 py-2 rounded-full text-sm font-medium {{ request('estado') == 'completada' ? 'bg-green-600 text-white' : 'bg-[#2B0052] text-green-300 hover:bg-[#3C0063]' }}">
               Completadas
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
                        // Filtrar tareas si hay un filtro aplicado
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
                                    
                                    <div class="flex items-center space-x-3">
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
                                        <a href="{{ route('tareas.show', $tarea) }}"
                                            class="text-sm bg-[#6A0DAD] hover:bg-[#7B1EAD] text-white px-3 py-1 rounded-lg transition-colors flex items-center">
                                            <i class="fas fa-eye mr-1 text-xs"></i>Ver
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
@endsection