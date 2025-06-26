@extends('layouts.app') {{-- Extiende la plantilla principal de la aplicación --}}

@section('content') {{-- Inicia la sección de contenido --}}
<div class="max-w-2xl mx-auto mt-10 bg-[#1A0033] text-white p-8 rounded-2xl shadow-2xl border-2 border-[#6A0DAD]">
    {{-- Contenedor principal del formulario: centrado, margen superior, fondo oscuro, texto blanco, padding, bordes redondeados, sombra y borde basado en colores de show.blade.php --}}

    <h2 class="text-4xl font-extrabold mb-8 text-center text-transparent bg-clip-text bg-gradient-to-r from-[#9D4EDD] to-[#C77DFF] animate-pulse">
        Crear perfil
    </h2>
    {{-- Título del formulario: grande, negrita, margen inferior, centrado, gradiente de color púrpura y azul de show.blade.php, efecto de pulso --}}

    @if (session('error'))
        <div class="bg-red-900 border border-red-700 text-red-300 p-4 mb-4 rounded-lg shadow-md">
            {{ session('error') }}
        </div>
    @endif
    {{-- Muestra un mensaje de error si existe en la sesión, con estilos de alerta en rojo --}}

    <form method="POST" action="{{ route('perfil.store') }}" enctype="multipart/form-data">
        @csrf {{-- Token CSRF para protección contra ataques Cross-Site Request Forgery --}}

        {{-- Tipo de perfil --}}
        <div class="mb-5">
            <label class="block mb-2 font-semibold text-[#E0AAFF]">Tipo de perfil</label>
            {{-- Etiqueta del campo "Tipo de perfil" --}}
            <select name="tipo" required
                    class="w-full bg-[#2B0039] border border-[#9D4EDD] text-white p-3 rounded-xl focus:ring-2 focus:ring-[#C77DFF] transition-all duration-300"
                    @if(isset($tipoPredefinido)) disabled @endif>
                {{-- Campo de selección para el tipo de perfil: fondo oscuro, borde púrpura, texto blanco, transición suave --}}
                <option value="">Selecciona un tipo</option>
                <option value="creador" {{ old('tipo', $tipoPredefinido ?? '') === 'creador' ? 'selected' : '' }}>Creador</option>
                <option value="colaborador" {{ old('tipo', $tipoPredefinido ?? '') === 'colaborador' ? 'selected' : '' }}>Colaborador</option>
            </select>
            @if(isset($tipoPredefinido))
                <input type="hidden" name="tipo" value="{{ $tipoPredefinido }}">
            @endif
            {{-- Campo oculto para enviar el tipo si está predefinido --}}
            @error('tipo')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
            {{-- Muestra errores de validación para el campo 'tipo' --}}
        </div>

        {{-- Nombre del perfil --}}
        <div class="mb-5">
            <label class="block mb-2 font-semibold text-[#E0AAFF]">Nombre del perfil</label>
            {{-- Etiqueta del campo "Nombre del perfil" --}}
            <input type="text" name="nombre_perfil" required
                   class="w-full bg-[#2B0039] border border-[#9D4EDD] text-white p-3 rounded-xl focus:ring-2 focus:ring-[#C77DFF] transition-all duration-300"
                   value="{{ old('nombre_perfil') }}">
            {{-- Campo de texto con fondo oscuro y estilo adaptado --}}
            @error('nombre_perfil')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Bio --}}
        <div class="mb-5">
            <label class="block mb-2 font-semibold text-[#E0AAFF]">Biografía (opcional)</label>
            {{-- Etiqueta del campo "Biografía" --}}
            <textarea name="bio" rows="4"
                      class="w-full bg-[#2B0039] border border-[#9D4EDD] text-white p-3 rounded-xl focus:ring-2 focus:ring-[#C77DFF] transition-all duration-300">{{ old('bio') }}</textarea>
            {{-- Campo de texto grande para biografía, con fondo y bordes coherentes --}}
            @error('bio')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Foto --}}
        <div class="mb-6">
            <label class="block mb-2 font-semibold text-[#E0AAFF]">Foto de perfil (opcional)</label>
            {{-- Etiqueta del campo "Foto de perfil" --}}
            <input type="file" name="foto" accept="image/*"
                   class="w-full bg-[#2B0039] border border-[#9D4EDD] text-white p-3 rounded-xl file:cursor-pointer file:text-sm file:bg-[#6A0DAD] file:text-white file:rounded-md transition-all duration-300">
            {{-- Campo de subida con estilos personalizados para el botón de archivo --}}
            @error('foto')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Botón --}}
        <div class="text-center">
            <button type="submit"
                    class="bg-gradient-to-r from-[#9D4EDD] to-[#6A0DAD] hover:from-[#7B2CBF] hover:to-[#5F3DC4] text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:shadow-2xl transition duration-300">
                Crear Perfil
            </button>
            {{-- Botón de envío del formulario con gradiente y transiciones suaves --}}
        </div>
    </form>
</div>
@endsection {{-- Finaliza la sección de contenido --}}