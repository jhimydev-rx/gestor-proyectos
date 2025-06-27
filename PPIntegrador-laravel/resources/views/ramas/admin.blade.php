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
        <div class="bg-[#1A0033] border border-[#9D4EDD] rounded-xl p-6 mb-6 shadow-lg">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-semibold text-[#C77DFF] mb-2">
                        <i class="fas fa-code-branch mr-2"></i>{{ $rama->nombre }}
                    </h2>
                    <p class="text-[#C7B8E0] mb-4">{{ $rama->descripcion }}</p>
                </div>
                <span class="bg-[#6A0DAD] text-[#E0AAFF] px-3 py-1 rounded-full text-sm">
                    {{ $rama->tareas->count() }} tarea(s)
                </span>
            </div>

            <!-- Botones de acción de rama -->
            <div class="flex flex-wrap gap-3 mb-6">
                <a href="{{ route('ramas.edit', $rama) }}"
                class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm shadow transition-all duration-300">
                    <i class="fas fa-edit mr-1"></i> Editar rama
                </a>

                <form action="{{ route('ramas.destroy', $rama) }}" method="POST"
                    onsubmit="return confirm('¿Estás seguro de eliminar esta rama? Se eliminarán todas sus tareas.')">
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

            <!-- Lista de tareas con acciones completas -->
            @if ($rama->tareas->isNotEmpty())
                <div class="bg-[#2B0052] rounded-lg p-4 border border-[#6A0DAD]">
                    <h3 class="text-lg font-bold text-[#E0AAFF] mb-3 flex items-center">
                        <i class="fas fa-tasks mr-2"></i>Tareas de esta rama
                        <span class="text-sm bg-[#9D4EDD] text-white px-2 py-1 rounded-full ml-2">
                            {{ $rama->tareas->count() }}
                        </span>
                    </h3>
                    
                    <ul class="space-y-3">
                         @foreach ($rama->tareas as $tarea)
                            <li class="bg-[#3A006D] px-4 py-3 rounded-md border border-[#6A0DAD] hover:bg-[#4A007D] transition-all">
                                <div class="flex justify-between items-start">
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
                                        <p class="text-[#C7B8E0] text-xs mb-1">{{ $tarea->descripcion }}</p>
                                        @if($tarea->fecha_limite)
                                            <p class="text-[#9D4EDD] text-xs">
                                                <i class="far fa-calendar-alt mr-1"></i>
                                                @if(is_string($tarea->fecha_limite))
                                                    {{ \Carbon\Carbon::parse($tarea->fecha_limite)->format('d/m/Y') }}
                                                @else
                                                    {{ $tarea->fecha_limite->format('d/m/Y') }}
                                                @endif
                                            </p>
                                        @else
                                            <p class="text-[#9D4EDD] text-xs">
                                                <i class="far fa-calendar-alt mr-1"></i>
                                                Sin fecha límite
                                            </p>
                                        @endif
                                    </div>
                                                        
                                    <div class="flex flex-wrap gap-2 ml-4">
                                        <!-- Botón Ver -->
                                        <a href="{{ route('admin.tareas.show', $tarea) }}"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-xs shadow flex items-center">
                                            <i class="fas fa-eye mr-1"></i> Ver
                                        </a>
                                        
                                        <!-- Botón Editar -->
                                        <a href="{{ route('tareas.edit', $tarea) }}"
                                        class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-xs shadow flex items-center">
                                            <i class="fas fa-edit mr-1"></i> Editar
                                        </a>
                                        
                                        <!-- Botón Eliminar -->
                                        <form action="{{ route('tareas.destroy', $tarea) }}" method="POST"
                                            onsubmit="return confirm('¿Eliminar esta tarea?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs shadow flex items-center">
                                                <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <p class="text-[#C7B8E0] text-sm italic bg-[#2B0052] p-3 rounded-lg border border-[#6A0DAD]">
                    <i class="fas fa-info-circle mr-1"></i>No hay tareas en esta rama.
                </p>
            @endif
        </div>
    @empty
        <div class="bg-[#1A0033] border border-[#6A0DAD] rounded-xl p-6 text-center">
            <p class="text-[#C7B8E0]">
                <i class="fas fa-info-circle mr-1"></i>Este proyecto no tiene ramas aún.
            </p>
        </div>
    @endforelse

    <!-- Botón para regresar al proyecto -->
    <div class="mt-10 text-center">
        <a href="{{ route('proyectos.show', $proyecto) }}"
           class="inline-block bg-gradient-to-r from-[#6A0DAD] to-[#9D4EDD] hover:from-[#7B2CBF] hover:to-[#B56EFF] text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Volver al proyecto
        </a>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection