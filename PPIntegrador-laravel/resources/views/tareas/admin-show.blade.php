@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-white">
    <div class="flex justify-between items-center flex-wrap gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-[#E0AAFF]">
                <i class="fas fa-tasks mr-2"></i> Detalle Administrativo de Tarea
            </h1>
            <div class="text-[#C7B8E0] mt-2">
                <span class="text-[#C77DFF]">
                    <i class="fas fa-folder-open mr-1"></i> {{ $tarea->rama->proyecto->titulo }}
                </span>
                <span class="mx-2">/</span>
                <span class="text-[#C77DFF]">
                    <i class="fas fa-code-branch mr-1"></i> {{ $tarea->rama->nombre }}
                </span>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('tareas.edit', $tarea) }}"
               class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-semibold shadow transition-all duration-300">
                <i class="fas fa-edit mr-1"></i> Editar Tarea
            </a>

            <a href="{{ route('proyectos.ramas.admin', ['proyecto' => $tarea->rama->proyecto, 'rama' => $tarea->rama]) }}"
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold shadow transition-all duration-300">
                <i class="fas fa-arrow-left mr-1"></i> Volver a Tareas
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Info principal -->
        <div class="lg:col-span-2">
            <div class="bg-[#1A0033] border border-[#9D4EDD] rounded-xl p-6 shadow-lg mb-6">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-2xl font-bold text-[#C77DFF]">{{ $tarea->titulo }}</h2>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($tarea->estado == 'completada') bg-green-900 text-green-300
                        @elseif($tarea->estado == 'en_proceso') bg-blue-900 text-blue-300
                        @else bg-yellow-900 text-yellow-300 @endif">
                        {{ ucfirst(str_replace('_', ' ', $tarea->estado)) }}
                    </span>
                </div>

                <div class="prose prose-invert max-w-none text-[#C7B8E0] mb-6">
                    {!! Str::markdown($tarea->descripcion) !!}
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-[#E0AAFF] font-medium">Fecha creación:</p>
                        <p class="text-[#C7B8E0]">{{ $tarea->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-[#E0AAFF] font-medium">Fecha límite:</p>
                        <p class="text-[#C7B8E0]">
                            @if($tarea->fecha_limite)
                                {{ $tarea->fecha_limite->format('d/m/Y') }}
                                @if($tarea->fecha_limite->isPast() && $tarea->estado != 'completada')
                                    <span class="text-red-400 ml-2"><i class="fas fa-exclamation-circle"></i> Vencida</span>
                                @endif
                            @else
                                Sin fecha límite
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-[#E0AAFF] font-medium">Prioridad:</p>
                        <p class="text-[#C7B8E0]">{{ ucfirst($tarea->prioridad) }}</p>
                    </div>
                    <div>
                        <p class="text-[#E0AAFF] font-medium">Dificultad:</p>
                        <p class="text-[#C7B8E0]">{{ ucfirst($tarea->dificultad) }}</p>
                    </div>
                </div>
            </div>

            <!-- Archivos adjuntos -->
            <div class="bg-[#1A0033] border border-[#9D4EDD] rounded-xl p-6 shadow-lg">
                <h2 class="text-xl font-bold text-[#E0AAFF] mb-4 flex items-center">
                    <i class="fas fa-paperclip mr-2"></i> Archivos Adjuntos
                    <span class="text-sm bg-[#6A0DAD] text-white px-2 py-1 rounded-full ml-2">
                        {{ $tarea->archivos ? $tarea->archivos->count() : 0 }}
                    </span>
                </h2>

                @if($tarea->archivos && $tarea->archivos->count() > 0)
                    <div class="space-y-3">
                        @foreach($tarea->archivos as $archivo)
                            <div class="bg-[#2B0052] border border-[#6A0DAD] rounded-lg p-4 flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="bg-[#6A0DAD] p-2 rounded-lg mr-3">
                                        <i class="fas fa-file text-lg text-[#E0AAFF]"></i>
                                    </div>
                                    <div>
                                        <p class="text-[#C77DFF] font-medium">{{ $archivo->nombre }}</p>
                                        <p class="text-xs text-[#C7B8E0]">
                                            Subido por: {{ optional($archivo->user)->nombre_perfil ?? 'Desconocido' }} • 
                                            {{ $archivo->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ Storage::url($archivo->ruta) }}" target="_blank"
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs shadow">
                                       <i class="fas fa-download mr-1"></i> Descargar
                                    </a>
                                    <form action="{{ route('tareas.archivos.destroy', ['tarea' => $tarea, 'archivo' => $archivo]) }}" 
                                          method="POST" onsubmit="return confirm('¿Eliminar este archivo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs shadow">
                                            <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-[#C7B8E0] text-center py-4">
                        <i class="fas fa-info-circle mr-2"></i> No hay archivos adjuntos
                    </p>
                @endif

                <!-- Formulario para subir archivos -->
                <form action="{{ route('tareas.archivos.store', $tarea) }}" method="POST" enctype="multipart/form-data" class="mt-6">
                    @csrf
                    <div class="flex gap-3">
                        <div class="flex-1">
                            <input type="file" name="archivo" id="archivo" 
                                   class="block w-full text-sm text-[#C7B8E0] file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#6A0DAD] file:text-white hover:file:bg-[#7B2CBF]">
                            @error('archivo')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" 
                                class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-semibold shadow transition-all duration-300">
                            <i class="fas fa-upload mr-1"></i> Subir
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lateral -->
        <div class="space-y-6">
            <!-- Asignado a -->
            <div class="bg-[#1A0033] border border-[#9D4EDD] rounded-xl p-6 shadow-lg">
                <h2 class="text-xl font-bold text-[#E0AAFF] mb-4">
                    <i class="fas fa-user-tag mr-2"></i> Asignación
                </h2>
                 @forelse ($tarea->colaboradores as $colaborador)
                    <div class="flex items-center mb-4">
                        <div class="bg-[#6A0DAD] p-2 rounded-full mr-3">
                            <i class="fas fa-user text-lg text-[#E0AAFF]"></i>
                        </div>
                        <div>
                            <p class="text-[#C77DFF] font-medium">{{ $colaborador->nombre_perfil }}</p>
                            <p class="text-xs text-[#C7B8E0]">{{ $colaborador->email }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-[#C7B8E0]">Sin colaboradores asignados</p>
                @endforelse

            </div>

            <!-- Acciones administrativas -->
            <div class="bg-[#1A0033] border border-[#9D4EDD] rounded-xl p-6 shadow-lg">
                <h2 class="text-xl font-bold text-[#E0AAFF] mb-4">
                    <i class="fas fa-shield-alt mr-2"></i> Acciones Administrativas
                </h2>

                <div class="space-y-3">
                    <form action="{{ route('admin.tareas.cambiarEstado', $tarea) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="estado" class="block text-sm font-medium text-[#E0AAFF] mb-1">Cambiar estado:</label>
                            <select name="estado" id="estado" 
                                    class="bg-[#2B0052] border border-[#6A0DAD] text-[#C7B8E0] text-sm rounded-lg focus:ring-[#9D4EDD] focus:border-[#9D4EDD] block w-full p-2.5">
                                <option value="pendiente" {{ $tarea->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="en_proceso" {{ $tarea->estado == 'en_proceso' ? 'selected' : '' }}>En proceso</option>
                                <option value="completada" {{ $tarea->estado == 'completada' ? 'selected' : '' }}>Completada</option>
                            </select>
                        </div>
                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow transition-all duration-300">
                            <i class="fas fa-sync-alt mr-1"></i> Actualizar Estado
                        </button>
                    </form>

                    <div class="pt-3 border-t border-[#6A0DAD]">
                        <form action="{{ route('tareas.destroy', $tarea) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar permanentemente esta tarea? Esta acción no se puede deshacer.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg shadow transition-all duration-300">
                                <i class="fas fa-trash-alt mr-1"></i> Eliminar Tarea
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
