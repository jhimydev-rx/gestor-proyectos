@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 text-white">
    <!-- Header con breadcrumbs y acciones -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('proyectos.index') }}" class="inline-flex items-center text-sm font-medium text-[#C7B8E0] hover:text-[#E0AAFF]">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            Proyectos
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-[#9D4EDD]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <a href="{{ route('proyectos.show', $tarea->rama->proyecto) }}" class="ml-1 text-sm font-medium text-[#C7B8E0] hover:text-[#E0AAFF] md:ml-2">{{ Str::limit($tarea->rama->proyecto->titulo, 20) }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-[#E0AAFF]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-[#E0AAFF] md:ml-2">Tarea: {{ Str::limit($tarea->titulo, 25) }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="mt-2 text-3xl font-bold text-[#E0AAFF]">
                <i class="fas fa-tasks mr-2 text-[#C77DFF]"></i> {{ $tarea->titulo }}
            </h1>
        </div>
        
        <div class="flex gap-2">
            <a href="{{ route('tareas.edit', $tarea) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm shadow transition-all duration-150 flex items-center">
                <i class="fas fa-edit mr-1"></i> Editar
            </a>
            <form action="{{ route('tareas.destroy', $tarea) }}" method="POST" onsubmit="return confirm('¿Eliminar esta tarea permanentemente?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm shadow transition-all duration-150 flex items-center">
                    <i class="fas fa-trash-alt mr-1"></i> Eliminar
                </button>
            </form>
        </div>
    </div>

    <!-- Mensajes de estado -->
    @if (session('estado_success'))
        <div class="bg-green-600/30 border border-green-500/50 text-green-100 px-4 py-3 rounded-lg mb-6">
            <i class="fas fa-check-circle mr-2"></i> {{ session('estado_success') }}
        </div>
    @endif

    @if (session('estado_error'))
        <div class="bg-red-600/30 border border-red-500/50 text-red-100 px-4 py-3 rounded-lg mb-6">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('estado_error') }}
        </div>
    @endif

    <!-- Tarjeta principal -->
    <div class="bg-[#1A0033] border border-[#9D4EDD] rounded-xl p-6 mb-6 shadow-lg">
        <!-- Información básica -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h2 class="text-xl font-bold text-[#C77DFF] mb-4 flex items-center gap-2">
                    <i class="fas fa-info-circle text-[#9D4EDD]"></i> Información de la Tarea
                </h2>
                <div class="space-y-4">
                    <div class="flex justify-between border-b border-[#6A0DAD] pb-2">
                        <span class="text-[#C7B8E0]">Proyecto:</span>
                        <span class="text-[#E0AAFF] font-medium">{{ $tarea->rama->proyecto->titulo }}</span>
                    </div>
                    <div class="flex justify-between border-b border-[#6A0DAD] pb-2">
                        <span class="text-[#C7B8E0]">Rama:</span>
                        <span class="text-[#E0AAFF] font-medium">{{ $tarea->rama->nombre }}</span>
                    </div>
                    <div class="flex justify-between border-b border-[#6A0DAD] pb-2">
                        <span class="text-[#C7B8E0]">Estado:</span>
               
                            <span class="font-semibold 
                                  @if($tarea->estado == 'pendiente') text-yellow-300
                                  @elseif($tarea->estado == 'en_proceso') text-blue-300
                                  @else text-green-300
                                  @endif">
                                {{ ucfirst(str_replace('_', ' ', $tarea->estado)) }}
                            </span>
                      
                    </div>
                    <div class="flex justify-between border-b border-[#6A0DAD] pb-2">
                        <span class="text-[#C7B8E0]">Creada el:</span>
                        <span class="text-[#E0AAFF]">{{ $tarea->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between border-b border-[#6A0DAD] pb-2">
                        <span class="text-[#C7B8E0]">Fecha límite:</span>
                        <span class="@if($tarea->fecha_limite && $tarea->fecha_limite->isPast()) text-red-300 @else text-[#E0AAFF] @endif font-medium">
                            {{ optional($tarea->fecha_limite)->format('d/m/Y') ?? 'Sin fecha límite' }}
                        </span>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-xl font-bold text-[#C77DFF] mb-4 flex items-center gap-2">
                    <i class="fas fa-align-left text-[#9D4EDD]"></i> Descripción
                </h2>
                <div class="bg-[#2B0052] border border-[#6A0DAD] rounded-lg p-4 h-full">
                    <div class="prose prose-invert max-w-none text-[#C7B8E0]">
                        {!! Str::markdown($tarea->descripcion) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Cambiar estado -->
        <div class="mt-8 pt-6 border-t border-[#6A0DAD]">
            <h2 class="text-xl font-bold text-[#C77DFF] mb-4 flex items-center gap-2">
                <i class="fas fa-exchange-alt text-[#9D4EDD]"></i> Cambiar Estado de la Tarea
            </h2>
            
            <div class="bg-[#2B0052] border border-[#9D4EDD] rounded-xl p-6 shadow-lg">
               
                    <form action="{{ route('admin.tareas.cambiarEstado', $tarea) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Opción Pendiente -->
                            <label class="flex items-center space-x-3 p-4 border rounded-lg cursor-pointer 
                                    @if($tarea->estado == 'pendiente') border-yellow-400 bg-yellow-500/10
                                    @else border-[#6A0DAD] hover:border-[#9D4EDD] hover:bg-[#3A006D] @endif">
                                <input type="radio" name="estado" value="pendiente" 
                                    class="h-5 w-5 text-yellow-500 focus:ring-yellow-500" 
                                    @checked($tarea->estado == 'pendiente')>
                                <div class="flex flex-col">
                                    <span class="block text-sm font-medium text-[#E0AAFF]">Pendiente</span>
                                    <span class="block text-xs text-[#C7B8E0]">Tarea por iniciar</span>
                                </div>
                                <i class="fas fa-clock ml-auto text-yellow-400"></i>
                            </label>
                            
                            <!-- Opción En Proceso -->
                            <label class="flex items-center space-x-3 p-4 border rounded-lg cursor-pointer 
                                    @if($tarea->estado == 'en_proceso') border-blue-400 bg-blue-500/10
                                    @else border-[#6A0DAD] hover:border-[#9D4EDD] hover:bg-[#3A006D] @endif">
                                <input type="radio" name="estado" value="en_proceso" 
                                    class="h-5 w-5 text-blue-500 focus:ring-blue-500" 
                                    @checked($tarea->estado == 'en_proceso')>
                                <div class="flex flex-col">
                                    <span class="block text-sm font-medium text-[#E0AAFF]">En Proceso</span>
                                    <span class="block text-xs text-[#C7B8E0]">Tarea en desarrollo</span>
                                </div>
                                <i class="fas fa-spinner ml-auto text-blue-400"></i>
                            </label>
                            
                            <!-- Opción Completada -->
                            <label class="flex items-center space-x-3 p-4 border rounded-lg cursor-pointer 
                                    @if($tarea->estado == 'completada') border-green-400 bg-green-500/10
                                    @else border-[#6A0DAD] hover:border-[#9D4EDD] hover:bg-[#3A006D] @endif">
                                <input type="radio" name="estado" value="completada" 
                                    class="h-5 w-5 text-green-500 focus:ring-green-500" 
                                    @checked($tarea->estado == 'completada')>
                                <div class="flex flex-col">
                                    <span class="block text-sm font-medium text-[#E0AAFF]">Completada</span>
                                    <span class="block text-xs text-[#C7B8E0]">Tarea finalizada</span>
                                </div>
                                <i class="fas fa-check-circle ml-auto text-green-400"></i>
                            </label>
                        </div>
                        
                        <div class="flex justify-end pt-4">
                            <button type="submit" 
                                    class="bg-gradient-to-r from-[#6A0DAD] to-[#9D4EDD] hover:from-[#7B2CBF] hover:to-[#B56EFF] text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-300 flex items-center">
                                <i class="fas fa-save mr-2"></i> Actualizar Estado
                            </button>
                        </div>
                    </form>
                
            </div>
        </div>

        <!-- Chat de la Tarea -->
        <div class="mt-8 pt-6 border-t border-[#6A0DAD]">
            <h3 class="text-lg font-bold text-[#C77DFF] mb-4 flex items-center gap-2">
                <i class="fas fa-comments text-[#9D4EDD]"></i> Chat de la tarea
            </h3>

            <div class="bg-[#2B0052] border border-[#9D4EDD] rounded-xl p-4 max-h-96 overflow-y-auto space-y-4">
                @foreach ($tarea->mensajes as $mensaje)
                    @php
                        $esCreador = $mensaje->perfil->id === $tarea->rama->proyecto->perfil_id;
                        $claseContenedor = $esCreador ? 'justify-start' : 'justify-end';
                        $claseBurbuja = $esCreador ? 'bg-blue-500 text-white' : 'bg-green-500 text-white';
                    @endphp
                    <div class="flex {{ $claseContenedor }}">
                        <div class="max-w-xs p-3 rounded-lg shadow {{ $claseBurbuja }}">
                            <p class="text-sm">{{ $mensaje->contenido }}</p>
                            <div class="text-xs text-white/70 mt-1 text-right">
                                {{ $mensaje->perfil->user->name }} • {{ $mensaje->created_at->format('H:i') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Formulario de nuevo mensaje -->
            <form action="{{ route('tareas.mensajes.store', $tarea) }}" method="POST" class="mt-4 flex gap-2">
                @csrf
                <input type="text" name="contenido" placeholder="Escribe tu mensaje..." required
                    class="w-full bg-[#3A006D] border border-[#6A0DAD] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#9D4EDD]">
                <button type="submit"
                        class="bg-[#9D4EDD] hover:bg-[#B56EFF] text-white px-4 py-2 rounded-lg shadow">
                    Enviar
                </button>
            </form>
        </div>

        <!-- Sección de archivos -->
        <div class="mt-8 pt-6 border-t border-[#6A0DAD]">
            @php
                $perfilActivo = session('perfil_activo');
                $perfilCreadorId = $tarea->proyecto->creador->id ?? null;
                $archivosPlantilla = $tarea->archivos->where('tipo', 'plantilla');
                $archivosRevision = $tarea->archivos->where('tipo', 'revision');
            @endphp

            <!-- Archivos plantilla -->
            <div class="mb-10">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-[#C77DFF] flex items-center gap-2">
                        <i class="fas fa-file-contract text-amber-300"></i> Archivos Plantilla
                        <span class="bg-[#6A0DAD] text-[#E0AAFF] text-xs font-semibold px-2.5 py-0.5 rounded-full ml-2">{{ $archivosPlantilla->count() }}</span>
                    </h3>
                </div>

                @if($archivosPlantilla->isEmpty())
                    <div class="bg-[#2B0052] border border-amber-500/30 rounded-lg p-4 text-center">
                        <p class="text-[#C7B8E0] italic">
                            <i class="fas fa-info-circle mr-2"></i> No hay archivos plantilla subidos aún
                        </p>
                    </div>
                @else
                    <div class="grid gap-4">
                        @foreach ($archivosPlantilla as $archivo)
                            <div class="bg-[#2B0052] border border-amber-500/30 rounded-lg p-4 shadow-lg">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    <div class="flex items-start gap-3">
                                        <div class="bg-amber-500/10 p-2 rounded-lg">
                                            <i class="fas fa-file-word text-amber-300 text-xl"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-[#E0AAFF] truncate">{{ $archivo->archivo }}</h4>
                                            @if ($archivo->comentario)
                                                <p class="text-sm text-amber-200 mt-1">
                                                    <i class="fas fa-comment-dots mr-1"></i> {{ $archivo->comentario }}
                                                </p>
                                            @endif
                                            <p class="text-xs text-[#C7B8E0] mt-2">
                                                <i class="fas fa-user mr-1"></i> {{ $archivo->perfil->user->name }}
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-clock mr-1"></i> {{ $archivo->created_at->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ asset('storage/' . $archivo->archivo) }}"
                                        target="_blank"
                                        class="bg-amber-500/20 hover:bg-amber-500/30 border border-amber-500/50 text-amber-100 px-3 py-1 rounded-lg text-sm shadow transition-all duration-150 flex items-center">
                                            <i class="fas fa-download mr-1"></i> Descargar
                                        </a>
                                        @if($perfilActivo == $archivo->perfil_id)
                                            <form action="{{ route('tareas.archivos.destroy', [$tarea, $archivo]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="bg-red-600/20 hover:bg-red-600/30 border border-red-600/50 text-red-100 px-3 py-1 rounded-lg text-sm shadow transition-all duration-150 flex items-center"
                                                        onclick="return confirm('¿Eliminar este archivo?')">
                                                    <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>


            <!-- Archivos revisión -->
            <div class="mb-10">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-[#C77DFF] flex items-center gap-2">
                        <i class="fas fa-file-upload text-[#9D4EDD]"></i> Archivos para Revisión
                        <span class="bg-[#6A0DAD] text-[#E0AAFF] text-xs font-semibold px-2.5 py-0.5 rounded-full ml-2">{{ $archivosRevision->count() }}</span>
                    </h3>
                </div>

                @if($archivosRevision->isEmpty())
                    <div class="bg-[#2B0052] border border-[#9D4EDD] rounded-lg p-4 text-center">
                        <p class="text-[#C7B8E0] italic">
                            <i class="fas fa-info-circle mr-2"></i> No hay archivos para revisión subidos aún
                        </p>
                    </div>
                @else
                    <div class="grid gap-4">
                        @foreach ($archivosRevision as $archivo)
                            <div class="bg-[#2B0052] border border-[#9D4EDD] rounded-lg p-4 shadow-lg">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    <div class="flex items-start gap-3">
                                        <div class="bg-[#6A0DAD] p-2 rounded-lg">
                                            <i class="fas fa-file-pdf text-[#E0AAFF] text-xl"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-[#E0AAFF] truncate">{{ $archivo->archivo }}</h4>
                                            @if ($archivo->comentario)
                                                <p class="text-sm text-[#C77DFF] mt-1">
                                                    <i class="fas fa-comment-dots mr-1"></i> {{ $archivo->comentario }}
                                                </p>
                                            @endif
                                            <p class="text-xs text-[#C7B8E0] mt-2">
                                                <i class="fas fa-user mr-1"></i> {{ $archivo->perfil->user->name }}
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-clock mr-1"></i> {{ $archivo->created_at->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ asset('storage/tareas/' . $tarea->id . '/' . $archivo->archivo) }}" 
                                           target="_blank"
                                           class="bg-[#6A0DAD] hover:bg-[#7B2CBF] text-[#E0AAFF] px-3 py-1 rounded-lg text-sm shadow transition-all duration-150 flex items-center">
                                            <i class="fas fa-download mr-1"></i> Descargar
                                        </a>
                                        @if($perfilActivo == $archivo->perfil_id)
                                            <form action="{{ route('tareas.archivos.destroy', [$tarea, $archivo]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="bg-red-600/20 hover:bg-red-600/30 border border-red-600/50 text-red-100 px-3 py-1 rounded-lg text-sm shadow transition-all duration-150 flex items-center"
                                                        onclick="return confirm('¿Eliminar este archivo?')">
                                                    <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Formulario para subir archivos -->
            <div class="bg-[#2B0052] border border-[#9D4EDD] rounded-xl p-6 shadow-lg">
                <h3 class="text-lg font-bold text-[#E0AAFF] mb-4 flex items-center gap-2">
                    <i class="fas fa-cloud-upload-alt text-[#9D4EDD]"></i> 
                    Subir nuevo archivo 
                    <span class="text-sm font-normal bg-[#6A0DAD] text-[#E0AAFF] px-2 py-0.5 rounded-full ml-auto">
                        {{ $perfilActivo == $perfilCreadorId ? 'Plantilla' : 'Revisión' }}
                    </span>
                </h3>

                @if (session('success'))
                    <div class="bg-green-600/30 border border-green-500/50 text-green-100 px-4 py-3 rounded-lg mb-4">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('tareas.archivos.store', $tarea) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-[#C7B8E0] mb-1">Seleccionar archivo</label>
                        <div class="flex items-center justify-center w-full">
                            <label class="flex flex-col w-full border-2 border-dashed border-[#6A0DAD] hover:border-[#9D4EDD] hover:bg-[#3A006D] rounded-lg cursor-pointer transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 px-4">
                                    <i class="fas fa-file-upload text-3xl text-[#9D4EDD] mb-2"></i>
                                    <p class="text-sm text-[#C7B8E0]">Haz clic para seleccionar un archivo</p>
                                    <p class="text-xs text-[#C7B8E0]/80 mt-1">Formatos soportados: PDF, DOCX, XLSX, etc.</p>
                                </div>
                                <input type="file" name="archivo" class="hidden" required>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="comentario" class="block text-sm font-medium text-[#C7B8E0] mb-1">Comentario (opcional)</label>
                        <textarea name="comentario" rows="3" class="w-full bg-[#3A006D] border border-[#6A0DAD] text-[#E0AAFF] rounded-lg focus:ring-2 focus:ring-[#9D4EDD] focus:border-[#9D4EDD] p-2.5 placeholder-[#C7B8E0]/50"></textarea>
                    </div>

                    <input type="hidden" name="tipo" value="{{ $perfilActivo == $perfilCreadorId ? 'plantilla' : 'revision' }}">

                    <div class="flex justify-end">
                        <button type="submit" class="bg-gradient-to-r from-[#6A0DAD] to-[#9D4EDD] hover:from-[#7B2CBF] hover:to-[#B56EFF] text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-300 flex items-center">
                            <i class="fas fa-paper-plane mr-2"></i> Subir archivo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script para mostrar el nombre del archivo seleccionado -->
<script>
    document.querySelector('input[type="file"]').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Ningún archivo seleccionado';
        const uploadArea = this.closest('label');
        const infoText = uploadArea.querySelector('p:first-of-type');
        infoText.textContent = fileName;
        infoText.classList.add('font-semibold', 'text-[#E0AAFF]');
    });
</script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection