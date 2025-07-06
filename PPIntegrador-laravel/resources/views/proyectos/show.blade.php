@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-white">

    <!-- Detalles del proyecto -->
    <div class="bg-[#1A0033] rounded-xl border-2 border-[#6A0DAD] shadow-lg p-6 mb-8">
        <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#9D4EDD] to-[#C77DFF] mb-2">
            <i class="fas fa-folder-open mr-2"></i> {{ $proyecto->titulo }}
        </h1>
        <p class="text-[#C7B8E0]"><i class="fas fa-align-left mr-2"></i>{{ $proyecto->descripcion }}</p>

        <!-- Acciones del proyecto -->
        <div class="mt-4 flex gap-3 flex-wrap">
            <a href="{{ route('proyectos.edit', $proyecto) }}" class="btn-accion btn-editar">
                <i class="fas fa-edit mr-1"></i> Editar
            </a>
            <form action="{{ route('proyectos.destroy', $proyecto) }}" method="POST"
                  onsubmit="return confirm('¿Estás seguro de eliminar este proyecto?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-accion btn-eliminar">
                    <i class="fas fa-trash-alt mr-1"></i> Eliminar
                </button>
            </form>
        </div>
    </div>

    <!-- Sección de ramas -->
    <div class="bg-[#1A0033] rounded-xl border border-[#6A0DAD] shadow p-6 mb-8">
        <div class="flex justify-between items-center mb-4 flex-wrap gap-2">
            <h2 class="text-2xl font-bold text-[#E0AAFF]"><i class="fas fa-code-branch mr-2"></i>Ramas del proyecto</h2>
            <div class="flex gap-3 flex-wrap">
                <a href="{{ route('proyectos.ramas.admin', $proyecto) }}" class="btn-accion btn-ver">
                    <i class="fas fa-tools mr-1"></i> Administrar ramas
                </a>

                <a href="{{ route('ramas.create', $proyecto) }}" class="btn-accion btn-crear">
                    <i class="fas fa-plus-circle mr-1"></i> Crear nueva rama
                </a>
            </div>
        </div>

        @if ($proyecto->ramas->isNotEmpty())
            <ul class="space-y-6">
                @foreach ($proyecto->ramas as $rama)
                    @php
                        $totalTareas = $rama->tareas->count();
                        $tareasCompletadas = $rama->tareas->where('estado', 'completada')->count();
                        $porcentaje = $totalTareas > 0 ? round(($tareasCompletadas / $totalTareas) * 100) : 0;
                        $colorClase = match(true) {
                            $porcentaje >= 80 => 'bg-green-600',
                            $porcentaje >= 50 => 'bg-blue-600',
                            default => 'bg-yellow-500'
                        };
                        $textoProgreso = "$tareasCompletadas completadas de $totalTareas tareas";
                    @endphp

                    <li class="bg-[#3A006D] border border-[#9D4EDD] rounded-lg p-5 space-y-3 hover:bg-[#4A007D] transition-all duration-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-lg font-semibold text-[#C77DFF]">
                                    <i class="fas fa-code mr-2"></i>{{ $rama->nombre }}
                                </p>
                                <p class="text-sm text-[#E0AAFF] mt-1">
                                    <i class="fas fa-quote-left mr-1 text-xs"></i>{{ $rama->descripcion }}
                                </p>
                            </div>
                            <span class="text-sm bg-[#6A0DAD] text-white px-3 py-1 rounded-full shadow">
                                {{ $totalTareas }} tarea(s)
                            </span>
                        </div>

                        <!-- Barra de progreso -->
                        <div class="w-full bg-[#2c004d] border border-[#6A0DAD] rounded-full h-5 overflow-hidden shadow-inner relative">
                            <div class="h-full text-xs font-bold text-white flex items-center justify-center rounded-full {{ $colorClase }} transition-all duration-700 ease-in-out whitespace-nowrap"
                                style="width: {{ $porcentaje }}%; min-width: 0%; max-width: 100%">
                                {{ $porcentaje }}%
                            </div>
                        </div>

                        <p class="text-sm text-[#C7B8E0] mt-1 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-[#9D4EDD]"></i> {{ $textoProgreso }}
                        </p>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-[#C7B8E0]"><i class="fas fa-info-circle mr-2"></i>Este proyecto aún no tiene ramas.</p>
        @endif
    </div>

    <!-- Sección de colaboradores -->
    <div class="bg-[#1A0033] rounded-xl border border-[#6A0DAD] shadow p-6">
        <div class="flex justify-between items-center mb-4 flex-wrap gap-2">
            <h2 class="text-2xl font-bold text-[#E0AAFF]"><i class="fas fa-users mr-2"></i>Colaboradores</h2>
            <a href="{{ route('proyectos.colaboradores.form', $proyecto) }}" class="btn-accion btn-crear">
                <i class="fas fa-user-plus mr-1"></i> Agregar colaborador
            </a>
        </div>

        <ul class="list-disc list-inside text-[#A5FFD6] space-y-1">
            @forelse ($colaboradores as $colaborador)
                <li>
                    <i class="fas fa-user mr-1"></i> {{ $colaborador->nombre_perfil }}
                    <span class="text-sm text-[#C7B8E0]">(<i class="fas fa-tag mr-1"></i>{{ $colaborador->tipo }})</span>
                </li>
            @empty
                <li class="text-[#C7B8E0]"><i class="fas fa-user-slash mr-1"></i>No hay colaboradores aún.</li>
            @endforelse
        </ul>
    </div>

    <!-- Botón para regresar -->
    <div class="mt-10 text-center">
        <a href="{{ route('proyectos.index') }}" class="btn-accion btn-ver px-6 py-3 text-base">
            <i class="fas fa-arrow-left mr-2"></i> Regresar a proyectos
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

    .btn-ver {
        color: #6AB7FF;
        border-color: #6AB7FF;
    }

    .btn-ver:hover {
        background-color: #6AB7FF;
        color: #1A0033;
    }

    .btn-editar {
        color: #FFD60A;
        border-color: #FFD60A;
    }

    .btn-editar:hover {
        background-color: #FFD60A;
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

    .btn-crear {
        color: #5EEAD4;
        border-color: #5EEAD4;
    }

    .btn-crear:hover {
        background-color: #5EEAD4;
        color: #1A0033;
    }

    .btn-accion i {
        font-size: 15px;
    }
</style>

<!-- Animación para las barras de progreso -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const progressBars = document.querySelectorAll('.transition-all');
        progressBars.forEach(bar => {
            void bar.offsetWidth;
            bar.style.minWidth = bar.style.width;
        });
    });
</script>
@endsection