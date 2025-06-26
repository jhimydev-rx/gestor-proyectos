@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <!-- Editar Rama -->
    <div class="bg-[#1A0033] rounded-xl border border-[#6A0DAD] shadow-lg p-6 mb-8">
        <h1 class="text-2xl font-bold text-[#E0AAFF] mb-6 flex items-center">
            <i class="fas fa-edit mr-2"></i>Editar Rama
        </h1>

        <form method="POST" action="{{ route('ramas.update', $rama) }}">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2 text-[#E0AAFF]">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $rama->nombre) }}"
                    class="w-full bg-[#1A0033] text-white border border-[#9D4EDD] rounded-lg p-3 focus:ring-2 focus:ring-[#9D4EDD] focus:border-transparent">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2 text-[#E0AAFF]">Descripción</label>
                <textarea name="descripcion" rows="4"
                    class="w-full bg-[#1A0033] text-white border border-[#9D4EDD] rounded-lg p-3 focus:ring-2 focus:ring-[#9D4EDD] focus:border-transparent">{{ old('descripcion', $rama->descripcion) }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-[#6A0DAD] hover:bg-[#7B2CBF] text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 flex items-center">
                    <i class="fas fa-save mr-2"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>

    @php
        $perfilActivoId = session('perfil_activo');
        $esCreador = $perfilActivoId === $proyecto->perfil_id;
        $esColaborador = $proyecto->colaboradores->contains('id', $perfilActivoId);
    @endphp

    @if ($esCreador || $esColaborador)
    <!-- Archivos de la Rama -->
    <div class="bg-[#1A0033] rounded-xl border border-[#6A0DAD] shadow-lg p-6">
        <h2 class="text-2xl font-bold text-[#E0AAFF] mb-6 flex items-center">
            <i class="fas fa-paperclip mr-2"></i>Archivos de esta Rama
        </h2>

        <!-- Subida de archivo -->
        <div class="mb-8">
            <form action="{{ route('ramas.archivos.subir', ['proyecto' => $proyecto->id, 'rama' => $rama->id]) }}"
                method="POST" enctype="multipart/form-data"
                class="bg-[#3A006D]/10 border-2 border-dashed border-[#6A0DAD] rounded-lg p-6 text-center">
                @csrf
                <div class="mb-4">
                    <i class="fas fa-cloud-upload-alt text-4xl text-[#E0AAFF]/50"></i>
                </div>
                <input type="file" name="archivo" class="block mx-auto mb-4 text-white text-sm" required>
                <button type="submit"
                    class="bg-[#6A0DAD] hover:bg-[#9D4EDD] text-white px-6 py-2 rounded-lg transition-all flex items-center mx-auto">
                    <i class="fas fa-upload mr-2"></i> Subir Archivo
                </button>
            </form>

            @error('archivo')
                <p class="text-red-500 mt-2 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Listado de Archivos -->
        @php
            $archivos = Storage::disk('public')->files('ramas/' . $rama->id);
        @endphp

        @if (count($archivos) > 0)
            <h3 class="text-lg font-semibold text-[#E0AAFF] mb-4">Archivos existentes en esta rama:</h3>
            <ul class="space-y-3">
                @foreach ($archivos as $archivo)
                    @php
                        $nombre = basename($archivo);
                    @endphp
                    <li class="bg-[#3A006D] border border-[#9D4EDD] rounded-lg p-4 flex justify-between items-center">
                        <span class="text-[#E0AAFF] truncate flex-1">
                            <i class="fas fa-file-alt mr-2"></i>{{ $nombre }}
                        </span>

                        <div class="flex gap-3 ml-4">
                            <!-- Botón descargar -->
                            <a href="{{ route('ramas.archivos.descargar', ['rama' => $rama->id, 'archivo' => $nombre]) }}"
                               class="bg-[#6A0DAD] hover:bg-[#9D4EDD] text-white px-4 py-2 rounded-lg text-sm transition-all flex items-center">
                                <i class="fas fa-download mr-2"></i> Descargar
                            </a>

                            <!-- Botón eliminar -->
                            <form action="{{ route('ramas.archivos.eliminar', ['rama' => $rama->id, 'archivo' => $nombre]) }}"
                                  method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este archivo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition-all flex items-center">
                                    <i class="fas fa-trash-alt mr-2"></i> Eliminar
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
@endsection
