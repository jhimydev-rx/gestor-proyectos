@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 text-white">

{{-- Botón para regresar --}}
<a href="{{ $urlRetorno }}" 
   class="btn-accion btn-ver mb-4 hover:scale-105 transition-transform duration-200 inline-flex items-center gap-2">
    <i class="fas fa-arrow-left"></i>
    <span>Volver a Proyecto</span>
</a>

    <h1 class="text-3xl font-bold text-[#E0AAFF] mb-6 flex items-center gap-2">
        ✅📋 {{ $tarea->titulo }}
    </h1>

    <div class="bg-[#1A0033] border border-[#6A0DAD] rounded-xl p-6 space-y-6 shadow-lg">

        {{-- Información de la tarea --}}
        <div class="space-y-2 text-[#EEDCFF]">
            <p><strong>📝 Descripción:</strong> {{ $tarea->descripcion }}</p>
            <p><strong>🔄 Estado:</strong>
                <span class="@if($tarea->estado == 'pendiente') text-yellow-400 @elseif($tarea->estado == 'en_proceso') text-blue-400 @else text-green-400 @endif font-semibold">
                    {{ ucfirst(str_replace('_', ' ', $tarea->estado)) }}
                </span>
            </p>

            @if ($tarea->estado !== 'completada')
                <form action="{{ route('tareas.cambiarEstado', $tarea->id) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-accion btn-editar">
                        🔁 Marcar como 
                        @if ($tarea->estado === 'pendiente') En proceso
                        @elseif ($tarea->estado === 'en_proceso') Completada
                        @endif
                    </button>
                </form>
            @endif

            <p><strong>📅 Fecha límite:</strong> {{ \Carbon\Carbon::parse($tarea->fecha_limite)->format('d/m/Y') }}</p>
        </div>

        @php
            $perfilActivo = session('perfil_activo');
            $perfilCreadorId = $tarea->proyecto->creador->id ?? null;

            $archivosPlantilla = $tarea->archivos->where('tipo', 'plantilla');
            $archivosRevision = $tarea->archivos->where('tipo', 'revision');
        @endphp

        {{-- Archivos Plantilla --}}
        @if($perfilActivo == $perfilCreadorId || $archivosPlantilla->isNotEmpty())
        <div class="mt-6 bg-[#2B0052] border border-[#FFB703] rounded-lg p-6 shadow">
            <h2 class="text-xl font-semibold text-amber-400 mb-3 flex items-center gap-2">
                📄 Archivos Plantilla
                @if($perfilActivo == $perfilCreadorId)
                    <span class="text-sm bg-amber-500 text-black px-2 py-1 rounded-full ml-2 transform hover:scale-105 transition-transform">
                        👤 Tú eres el creador
                    </span>
                @endif
            </h2>

            @if($archivosPlantilla->isEmpty())
                <p class="text-[#C7B8E0] italic">📂 No hay archivos plantilla subidos aún.</p>
            @else
                <ul class="space-y-2">
                    @foreach ($archivosPlantilla as $archivo)
                        <li class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 bg-[#3A006D] border border-amber-500 rounded p-4 shadow-md">
                            <div class="w-full sm:w-2/3">
                                <span class="block text-white font-semibold truncate">📎 {{ $archivo->archivo }}</span>
                                @if ($archivo->comentario)
                                    <p class="text-sm italic text-amber-300 mt-1">💬 {{ $archivo->comentario }}</p>
                                @endif
                                <p class="text-xs text-amber-200 mt-1">🕒 Subido el: {{ $archivo->created_at->format('d/m/Y H:i') }}</p>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ asset('storage/tareas/' . $tarea->id . '/' . $archivo->archivo) }}" target="_blank" class="btn-accion btn-ver">
                                    ⬇️ Descargar
                                </a>
                                @if($perfilActivo == $perfilCreadorId)
                                    <form action="{{ route('tareas.archivos.destroy', [$tarea, $archivo]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-accion btn-eliminar">
                                            🗑️ Eliminar
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

        {{-- Archivos Revisión --}}
        <div class="mt-6 bg-[#1A0033] border border-[#6A0DAD] rounded-lg p-6 shadow">
            <h2 class="text-xl font-semibold text-[#E0AAFF] mb-3 flex items-center gap-2">
                📤 Archivos para Revisión
                @if($perfilActivo != $perfilCreadorId)
                    <span class="text-sm bg-purple-500 text-white px-2 py-1 rounded-full ml-2 transform hover:scale-105 transition-transform">
                        👤 Tus entregas
                    </span>
                @endif
            </h2>

            @if($archivosRevision->isEmpty())
                <p class="text-[#C7B8E0] italic">📂 No hay archivos para revisión subidos aún.</p>
            @else
                <ul class="space-y-3">
                    @foreach ($archivosRevision as $archivo)
                        <li class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 bg-[#3A006D] border border-[#9D4EDD] rounded p-4 shadow-md">
                            <div class="w-full sm:w-2/3">
                                <span class="block text-[#A5FFD6] font-semibold truncate">📎 {{ $archivo->archivo }}</span>
                                @if ($archivo->comentario)
                                    <p class="text-sm italic text-[#C7B8E0] mt-1">💬 {{ $archivo->comentario }}</p>
                                @endif
                                <p class="text-xs text-purple-300 mt-1">👤 Subido por: {{ $archivo->perfil->user->name }} el {{ $archivo->created_at->format('d/m/Y H:i') }}</p>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ asset('storage/tareas/' . $tarea->id . '/' . $archivo->archivo) }}" target="_blank" class="btn-accion btn-ver">
                                    ⬇️ Descargar
                                </a>
                                @if($perfilActivo == $archivo->perfil_id)
                                    <form action="{{ route('tareas.archivos.destroy', [$tarea, $archivo]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-accion btn-eliminar">
                                            🗑️ Eliminar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Subida de Archivos --}}
        <div class="mt-8 bg-[#2B0052] p-6 rounded-lg border border-[#6A0DAD]">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                ⬆️ Subir archivo
                @if ($perfilActivo == $perfilCreadorId)
                    de plantilla
                @else
                    para revisión
                @endif
            </h3>

            @if (session('success'))
                <div class="bg-green-700 text-white p-3 rounded mb-4 animate-fadeIn">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('tareas.archivos.store', $tarea) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <input type="file" name="archivo" required class="w-full border border-[#9D4EDD] bg-[#1A0033] text-white rounded p-2 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 cursor-pointer">

                <textarea name="comentario" rows="2" placeholder="Comentario (opcional)" class="w-full border border-[#9D4EDD] bg-[#1A0033] text-white rounded p-2 focus:ring-2 focus:ring-[#9D4EDD] focus:border-transparent"></textarea>

                <input type="hidden" name="tipo" value="{{ $perfilActivo == $perfilCreadorId ? 'plantilla' : 'revision' }}">

                <button type="submit" class="btn-accion btn-crear w-full sm:w-auto">
                    📤 Subir archivo
                </button>
            </form>
        </div>

        {{-- Chat --}}
        <div class="bg-[#1A0033] rounded-xl border border-[#6A0DAD] shadow p-6 mt-8">
            <h2 class="text-2xl font-bold text-[#E0AAFF] mb-4">💬 Chat de la tarea</h2>

            <div class="space-y-4 max-h-96 overflow-y-auto mb-6 p-2 border border-[#6A0DAD] rounded-lg bg-[#2B004A]">
                @forelse ($tarea->mensajes as $mensaje)
                    @php $esCreador = $mensaje->perfil->tipo === 'creador'; @endphp
                    <div class="flex {{ $esCreador ? 'justify-start' : 'justify-end' }}">
                        <div class="max-w-xs px-4 py-2 rounded-lg text-white text-sm {{ $esCreador ? 'bg-indigo-700' : 'bg-purple-600' }} shadow-md">
                            <strong>👤 {{ $mensaje->perfil->nombre_perfil }}:</strong> {{ $mensaje->contenido }}
                            <div class="text-xs text-gray-300 mt-1">🕒 {{ $mensaje->created_at->format('H:i') }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-[#C7B8E0] text-sm">🕊️ No hay mensajes todavía.</p>
                @endforelse
            </div>

            <form action="{{ route('tareas.mensajes.store', $tarea) }}" method="POST" class="flex items-center gap-4">
                @csrf
                <input type="text" name="contenido" required class="flex-grow px-4 py-2 rounded-lg bg-[#2B004A] text-white border border-[#6A0DAD] focus:outline-none focus:ring-2 focus:ring-[#9D4EDD]" placeholder="Escribe un mensaje...">
                <button type="submit" class="btn-accion btn-crear">
                    📩
                </button>
            </form>
        </div>
    </div>
</div>

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
</style>
@endsection