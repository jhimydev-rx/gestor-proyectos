@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 text-white">
    <h1 class="text-3xl font-bold text-[#E0AAFF] mb-6 flex items-center gap-2">
        <i class="fas fa-tasks"></i> {{ $tarea->titulo }}
    </h1>

    <div class="bg-[#1A0033] border border-[#6A0DAD] rounded-xl p-6 space-y-6 shadow-lg">

        {{-- Información de la tarea --}}
        <div class="space-y-2 text-[#EEDCFF]">
            <p><strong>📄 Descripción:</strong> {{ $tarea->descripcion }}</p>
            <p><strong>✅ Estado:</strong>
                <span class="
                    @if($tarea->estado == 'pendiente') text-yellow-400
                    @elseif($tarea->estado == 'en_proceso') text-blue-400
                    @else text-green-400
                    @endif font-semibold">
                    {{ ucfirst(str_replace('_', ' ', $tarea->estado)) }}
                </span>
            </p>

            @if ($tarea->estado !== 'completada')
                <form action="{{ route('tareas.cambiarEstado', $tarea->id) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="bg-gradient-to-r from-[#7B2CBF] to-[#9D4EDD] hover:from-[#5A189A] hover:to-[#7B2CBF] text-white px-4 py-2 rounded-lg shadow font-semibold transition-all">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Marcar como 
                        @if ($tarea->estado === 'pendiente')
                            En proceso
                        @elseif ($tarea->estado === 'en_proceso')
                            Completada
                        @endif
                    </button>
                </form>
            @endif

            <p><strong>📅 Fecha límite:</strong> 
                {{ \Carbon\Carbon::parse($tarea->fecha_limite)->format('d/m/Y') }}
            </p>
        </div>

        {{-- Clasificación de archivos --}}
        @php
            $perfilActivo = session('perfil_activo');
            $perfilCreadorId = $tarea->proyecto->creador->id ?? null;

            $archivosPlantilla = $tarea->archivos->where('tipo', 'plantilla');
            $archivosRevision = $tarea->archivos->where('tipo', 'revision');
        @endphp

        {{-- Sección de Archivos Plantilla (solo si es creador o si hay archivos) --}}
        @if($perfilActivo == $perfilCreadorId || $archivosPlantilla->isNotEmpty())
        <div class="mt-6 bg-[#2B0052] border border-[#FFB703] rounded-lg p-6 shadow">
            <h2 class="text-xl font-semibold text-amber-400 mb-3 flex items-center gap-2">
                <i class="fas fa-file-contract"></i> Archivos Plantilla
                @if($perfilActivo == $perfilCreadorId)
                    <span class="text-sm bg-amber-500 text-black px-2 py-1 rounded-full ml-2">Tú eres el creador</span>
                @endif
            </h2>

            @if($archivosPlantilla->isEmpty())
                <p class="text-[#C7B8E0] italic">No hay archivos plantilla subidos aún.</p>
            @else
                <ul class="space-y-2">
                    @foreach ($archivosPlantilla as $archivo)
                        <li class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 bg-[#3A006D] border border-amber-500 rounded p-4 shadow">
                            <div class="w-full sm:w-2/3">
                                <span class="block text-white font-semibold truncate">
                                    <i class="fas fa-file-word mr-2"></i>{{ $archivo->archivo }}
                                </span>
                                @if ($archivo->comentario)
                                    <p class="text-sm italic text-amber-300 mt-1">📝 {{ $archivo->comentario }}</p>
                                @endif
                                <p class="text-xs text-amber-200 mt-1">
                                    Subido el: {{ $archivo->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ asset('storage/tareas/' . $tarea->id . '/' . $archivo->archivo) }}" 
                                   target="_blank"
                                   class="bg-amber-500 hover:bg-amber-600 text-black px-4 py-2 rounded text-sm transition-all">
                                    <i class="fas fa-download mr-2"></i> Descargar
                                </a>
                                @if($perfilActivo == $perfilCreadorId)
                                    <form action="{{ route('tareas.archivos.destroy', [$tarea, $archivo]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm transition-all">
                                            <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        @endif

        {{-- Sección de Archivos para Revisión --}}
        <div class="mt-6 bg-[#1A0033] border border-[#6A0DAD] rounded-lg p-6 shadow">
            <h2 class="text-xl font-semibold text-[#E0AAFF] mb-3 flex items-center gap-2">
                <i class="fas fa-file-upload"></i> Archivos para Revisión
                @if($perfilActivo != $perfilCreadorId)
                    <span class="text-sm bg-purple-500 text-white px-2 py-1 rounded-full ml-2">Tus entregas</span>
                @endif
            </h2>

            @if($archivosRevision->isEmpty())
                <p class="text-[#C7B8E0] italic">No hay archivos para revisión subidos aún.</p>
            @else
                <ul class="space-y-3">
                    @foreach ($archivosRevision as $archivo)
                        <li class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 bg-[#3A006D] border border-[#9D4EDD] rounded p-4 shadow">
                            <div class="w-full sm:w-2/3">
                                <span class="block text-[#A5FFD6] font-semibold truncate">
                                    <i class="fas fa-file-pdf mr-2"></i>{{ $archivo->archivo }}
                                </span>
                                @if ($archivo->comentario)
                                    <p class="text-sm italic text-[#C7B8E0] mt-1">💬 {{ $archivo->comentario }}</p>
                                @endif
                                <p class="text-xs text-purple-300 mt-1">
                                    Subido por: {{ $archivo->perfil->user->name }} el {{ $archivo->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ asset('storage/tareas/' . $tarea->id . '/' . $archivo->archivo) }}"
                                   target="_blank"
                                   class="bg-[#6A0DAD] hover:bg-[#9D4EDD] text-white px-4 py-2 rounded text-sm transition-all">
                                    <i class="fas fa-download mr-1"></i> Descargar
                                </a>
                                @if($perfilActivo == $archivo->perfil_id)
                                    <form action="{{ route('tareas.archivos.destroy', [$tarea, $archivo]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm transition-all">
                                            <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Subida de archivos --}}
        <div class="mt-8 bg-[#2B0052] p-6 rounded-lg border border-[#6A0DAD]">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <i class="fas fa-upload"></i> Subir archivo 
                @if ($perfilActivo == $perfilCreadorId)
                    de plantilla
                @else
                    para revisión
                @endif
            </h3>

            @if (session('success'))
                <div class="bg-green-700 text-white p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('tareas.archivos.store', $tarea) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <input type="file" name="archivo" required
                       class="w-full border border-[#9D4EDD] bg-[#1A0033] text-white rounded p-2">

                <textarea name="comentario" rows="2" placeholder="Comentario (opcional)"
                          class="w-full border border-[#9D4EDD] bg-[#1A0033] text-white rounded p-2"></textarea>

                <input type="hidden" name="tipo" value="{{ $perfilActivo == $perfilCreadorId ? 'plantilla' : 'revision' }}">

                <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded text-white font-semibold transition-all w-full sm:w-auto">
                    <i class="fas fa-paper-plane mr-2"></i> Subir archivo
                </button>
            </form>
        </div>

        {{-- Chat Placeholder --}}
        <!-- Sección de Chat -->
<div class="bg-[#1A0033] rounded-xl border border-[#6A0DAD] shadow p-6 mt-8">
    <h2 class="text-2xl font-bold text-[#E0AAFF] mb-4"><i class="fas fa-comments mr-2"></i>Chat de la tarea</h2>

    <div class="space-y-4 max-h-96 overflow-y-auto mb-6 p-2 border border-[#6A0DAD] rounded-lg bg-[#2B004A]">
        @forelse ($tarea->mensajes as $mensaje)
            @php
                $esCreador = $mensaje->perfil->tipo === 'creador';
            @endphp
            <div class="flex {{ $esCreador ? 'justify-start' : 'justify-end' }}">
                <div class="max-w-xs px-4 py-2 rounded-lg text-white text-sm {{ $esCreador ? 'bg-indigo-700' : 'bg-purple-600' }}">
                    <strong>{{ $mensaje->perfil->nombre_perfil }}:</strong> {{ $mensaje->contenido }}
                    <div class="text-xs text-gray-300 mt-1">{{ $mensaje->created_at->format('H:i') }}</div>
                </div>
            </div>
        @empty
            <p class="text-[#C7B8E0] text-sm">No hay mensajes todavía.</p>
        @endforelse
    </div>

        <form action="{{ route('tareas.mensajes.store', $tarea) }}" method="POST" class="flex items-center gap-4">
                @csrf
                <input type="text" name="contenido" required
                    class="flex-grow px-4 py-2 rounded-lg bg-[#2B004A] text-white border border-[#6A0DAD] focus:outline-none focus:ring-2 focus:ring-[#9D4EDD]"
                    placeholder="Escribe un mensaje...">
                <button type="submit"
                        class="bg-gradient-to-r from-[#6A0DAD] to-[#9D4EDD] hover:from-[#7B2CBF] hover:to-[#B56EFF] text-white px-4 py-2 rounded-lg font-semibold shadow">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>


    </div>
</div>
@endsection