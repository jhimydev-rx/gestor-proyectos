@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8 text-white">
    {{-- Mensaje de éxito si existe --}}
    @if(session('success'))
        <div class="mb-6 bg-green-600 text-white text-sm font-semibold px-6 py-4 rounded-lg shadow">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Sección Editar Rama --}}
    <div class="bg-[#1A0033] border-2 border-[#6A0DAD] rounded-xl shadow-lg p-8 mb-10">
        <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#9D4EDD] to-[#C77DFF] mb-6 flex items-center">
            <i class="fas fa-code-branch mr-3"></i>Editar Rama
        </h1>

        <form method="POST" action="{{ route('ramas.update', $rama) }}">
            @csrf
            @method('PUT')

            <input type="hidden" name="previous_url" value="{{ old('previous_url', url()->previous()) }}">

            {{-- Nombre --}}
            <div class="mb-6">
                <label for="nombre" class="block text-sm font-semibold text-[#E0AAFF] mb-2">
                    <i class="fas fa-tag mr-1"></i>Nombre
                </label>
                <input id="nombre" type="text" name="nombre" value="{{ old('nombre', $rama->nombre) }}"
                       class="w-full bg-[#1A0033] text-white border border-[#9D4EDD] rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#9D4EDD] focus:outline-none">
            </div>

            {{-- Descripción --}}
            <div class="mb-6">
                <label for="descripcion" class="block text-sm font-semibold text-[#E0AAFF] mb-2">
                    <i class="fas fa-align-left mr-1"></i>Descripción
                </label>
                <textarea id="descripcion" name="descripcion" rows="4"
                          class="w-full bg-[#1A0033] text-white border border-[#9D4EDD] rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#9D4EDD] focus:outline-none">{{ old('descripcion', $rama->descripcion) }}</textarea>
            </div>

            {{-- Botones --}}
            <div class="flex justify-between items-center mt-8">
                <a href="{{ old('previous_url', url()->previous()) }}" class="btn-accion btn-ver">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>

                <button type="submit" class="btn-accion btn-editar">
                    <i class="fas fa-save"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>

    @php
        $perfilActivoId = session('perfil_activo');
        $esCreador = $perfilActivoId === $proyecto->perfil_id;
        $esColaborador = $proyecto->colaboradores->contains('id', $perfilActivoId);
    @endphp

    {{-- Archivos de la Rama --}}
    @if ($esCreador || $esColaborador)
    <div class="bg-[#1A0033] border-2 border-[#6A0DAD] rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-[#E0AAFF] mb-6 flex items-center">
            <i class="fas fa-paperclip mr-3"></i>Archivos de esta Rama
        </h2>

        {{-- Subida de archivo --}}
        <form action="{{ route('ramas.archivos.subir', ['proyecto' => $proyecto->id, 'rama' => $rama->id]) }}"
              method="POST" enctype="multipart/form-data"
              class="bg-[#3A006D]/10 border-2 border-dashed border-[#6A0DAD] rounded-lg shadow-inner p-6 mb-8 text-center">
            @csrf
            <div class="mb-4">
                <i class="fas fa-cloud-upload-alt text-5xl text-[#E0AAFF]/60"></i>
            </div>
            <input type="file" name="archivo" class="block mx-auto mb-4 text-sm text-[#E0AAFF]" required>
            <button type="submit" class="btn-accion btn-crear">
                <i class="fas fa-upload"></i> Subir Archivo
            </button>

            @error('archivo')
                <p class="text-red-500 mt-2 text-sm">{{ $message }}</p>
            @enderror
        </form>

        {{-- Listado de archivos --}}
        @php
            $archivos = Storage::disk('public')->files('ramas/' . $rama->id);
        @endphp

        @if (count($archivos) > 0)
            <h3 class="text-lg font-semibold text-[#E0AAFF] mb-4"><i class="fas fa-folder-open mr-2"></i>Archivos existentes:</h3>
            <ul class="space-y-4">
                @foreach ($archivos as $archivo)
                    @php $nombre = basename($archivo); @endphp
                    <li class="bg-[#3A006D] hover:bg-[#4A007D] border border-[#9D4EDD] rounded-lg p-4 flex justify-between items-center transition-all duration-300">
                        <span class="text-[#E0AAFF] truncate flex-1">
                            <i class="fas fa-file-alt mr-2"></i>{{ $nombre }}
                        </span>

                        <div class="flex gap-3 ml-4">
                            {{-- Descargar --}}
                            <a href="{{ route('ramas.archivos.descargar', ['rama' => $rama->id, 'archivo' => $nombre]) }}"
                               class="btn-accion btn-ver text-sm">
                                <i class="fas fa-download"></i> Descargar
                            </a>

                            {{-- Eliminar --}}
                            <form action="{{ route('ramas.archivos.eliminar', ['rama' => $rama->id, 'archivo' => $nombre]) }}"
                                  method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este archivo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-accion btn-eliminar text-sm">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-[#C7B8E0] text-center py-4">
                <i class="fas fa-info-circle mr-2"></i>No se han subido archivos a esta rama aún.
            </p>
        @endif
    </div>
    @endif
</div>

{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

{{-- Estilos para botones --}}
<style>
    .btn-accion {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
        border-radius: 8px;
        padding: 10px 18px;
        font-size: 14px;
        transition: all 0.2s ease-in-out;
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