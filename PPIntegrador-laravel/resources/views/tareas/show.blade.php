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
            <p><strong>✅ Estado:</strong> {{ $tarea->estado }}</p>
            <p><strong>📅 Fecha límite:</strong> {{ $tarea->fecha_limite }}</p>
        </div>

        {{-- 📌 Archivo plantilla --}}
        @php
            $archivoPlantilla = $tarea->archivos->first();
        @endphp

        @if ($archivoPlantilla)
            <div class="mt-6 bg-[#2B0052] border border-[#FFB703] rounded-lg p-6 shadow">
                <h2 class="text-xl font-semibold text-amber-400 mb-3 flex items-center gap-2">
                    <i class="fas fa-file-upload"></i> Archivo Plantilla
                </h2>

                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                    <div class="w-full sm:w-2/3">
                        <span class="block text-white font-semibold truncate">
                            <i class="fas fa-file-alt mr-2"></i>{{ basename($archivoPlantilla->archivo) }}
                        </span>
                        @if ($archivoPlantilla->comentario)
                            <p class="text-sm italic text-[#fcd34d] mt-1">💬 {{ $archivoPlantilla->comentario }}</p>
                        @endif
                    </div>

                    <a href="{{ asset('storage/' . $archivoPlantilla->archivo) }}" target="_blank"
                       class="bg-amber-500 hover:bg-amber-600 text-black px-4 py-2 rounded text-sm transition-all flex items-center justify-center w-fit">
                        <i class="fas fa-download mr-2"></i> Descargar
                    </a>
                </div>
            </div>
        @endif

        {{-- Archivos adicionales --}}
        @if ($tarea->archivos->count() > 1)
            <div class="mt-6">
                <h2 class="text-xl font-semibold text-[#E0AAFF] mb-3 flex items-center gap-2">
                    <i class="fas fa-paperclip"></i> Archivos adicionales de la tarea
                </h2>

                <ul class="space-y-2">
                    @foreach ($tarea->archivos->skip(1) as $archivo)
                        <li class="bg-[#3A006D] border border-[#9D4EDD] rounded p-4 shadow flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                            <div class="w-full sm:w-2/3">
                                <span class="block text-[#A5FFD6] font-semibold truncate">
                                    <i class="fas fa-file-alt mr-2"></i>{{ basename($archivo->archivo) }}
                                </span>
                                @if ($archivo->comentario)
                                    <p class="text-sm italic text-[#C7B8E0] mt-1">💬 {{ $archivo->comentario }}</p>
                                @endif
                            </div>

                            <a href="{{ asset('storage/' . $archivo->archivo) }}"
                               target="_blank"
                               class="bg-[#6A0DAD] hover:bg-[#9D4EDD] text-white px-4 py-2 rounded text-sm transition-all flex items-center justify-center w-fit">
                                <i class="fas fa-download mr-1"></i> Descargar
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario de subida de archivo --}}
        <div class="mt-8 bg-[#2B0052] p-6 rounded-lg border border-[#6A0DAD]">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <i class="fas fa-upload"></i> Subir archivo para revisión
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

                <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded text-white font-semibold transition-all w-full sm:w-auto">
                    <i class="fas fa-paper-plane mr-2"></i> Subir archivo
                </button>
            </form>
        </div>

        {{-- Chat (placeholder) --}}
        <div class="mt-10 bg-[#2B0052] rounded p-4 border border-[#6A0DAD]">
            <h3 class="text-lg font-semibold mb-2 text-[#E0AAFF] flex items-center gap-2">
                <i class="fas fa-comments"></i> Chat / Consultas
            </h3>
            <p class="text-sm text-[#C7B8E0]">Aquí se integrará el chat en tiempo real con Node.js u otra tecnología.</p>
        </div>

    </div>
</div>
@endsection
