@extends('layouts.app') {{-- Extiende la plantilla principal de la aplicación --}}

@section('content') {{-- Inicia la sección de contenido --}}
<div class="max-w-3xl mx-auto mt-12 text-white px-4">
    {{-- Contenedor principal: ancho máximo, centrado, margen superior, texto blanco, padding horizontal --}}

    <h1 class="text-3xl font-bold mb-8 flex items-center gap-3 text-transparent bg-clip-text bg-gradient-to-r from-[#9D4EDD] to-[#C77DFF]">
        <i class="fas fa-pen-to-square"></i> Editar Proyecto
    </h1>
    {{-- Título de la página "Editar Proyecto": grande, negrita, margen inferior, flexbox con espacio, gradiente de color púrpura y azul de show.blade.php, con ícono de Font Awesome. --}}

    <form action="{{ route('proyectos.update', $proyecto) }}" method="POST"
          class="bg-[#1A0033] border-2 border-[#6A0DAD] rounded-2xl p-8 shadow-2xl space-y-6">
        @csrf {{-- Token CSRF para protección contra ataques Cross-Site Request Forgery --}}
        @method('PUT') {{-- Directiva para simular un método HTTP PUT para la actualización --}}

        <div>
            <label class="block mb-2 font-semibold text-[#E0AAFF]">
                <i class="fas fa-heading mr-1"></i> Título del proyecto
            </label>
            {{-- Etiqueta del campo "Título del proyecto" con ícono y color de show.blade.php --}}
            <input type="text" name="titulo"
                   value="{{ old('titulo', $proyecto->titulo) }}"
                   class="w-full bg-[#3A006D] border border-[#9D4EDD] text-white p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C77DFF] transition duration-300"
                   required>
            {{-- Campo de entrada para el título: ancho completo, fondo oscuro, borde púrpura de show.blade.php, texto blanco, padding, redondeado, efectos de foco, requerido. Mantiene el valor antiguo o el actual del proyecto. --}}
            @error('titulo')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
            {{-- Muestra errores de validación para el campo 'titulo' --}}
        </div>

        <div>
            <label class="block mb-2 font-semibold text-[#E0AAFF]">
                <i class="fas fa-align-left mr-1"></i> Descripción
            </label>
            {{-- Etiqueta del campo "Descripción" con ícono y color de show.blade.php --}}
            <textarea name="descripcion" rows="4"
                      class="w-full bg-[#3A006D] border border-[#9D4EDD] text-white p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C77DFF] transition duration-300">{{ old('descripcion', $proyecto->descripcion) }}</textarea>
            {{-- Campo de área de texto para la descripción: ancho completo, fondo oscuro, borde púrpura de show.blade.php, texto blanco, padding, redondeado, efectos de foco. Mantiene el valor antiguo o el actual del proyecto. --}}
            @error('descripcion')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
            {{-- Muestra errores de validación para el campo 'descripcion' --}}
        </div>

        <div class="flex items-center gap-4 pt-6">
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-[#7B2CBF] to-[#9D4EDD] hover:from-[#5A189A] hover:to-[#7B2CBF] text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition duration-300">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
            {{-- Botón para guardar los cambios: gradiente de púrpura de show.blade.php, texto blanco, padding, redondeado, sombra, negrita, transiciones, con ícono. --}}

            <a href="{{ route('proyectos.index') }}"
               class="inline-flex items-center gap-2 text-[#C7B8E0] hover:text-white hover:underline transition duration-200">
                <i class="fas fa-arrow-left"></i> Cancelar
            </a>
            {{-- Enlace para cancelar y volver al índice de proyectos: texto de show.blade.php, efectos hover, con ícono. --}}
        </div>
    </form>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
{{-- Enlace a la CDN de Font Awesome para los íconos --}}
@endsection {{-- Finaliza la sección de contenido --}}