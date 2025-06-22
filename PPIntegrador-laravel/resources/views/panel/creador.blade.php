@extends('layouts.app') {{-- Extiende la plantilla principal de la aplicación --}}

@section('content') {{-- Inicia la sección de contenido --}}
<div class="max-w-4xl mx-auto mt-12 bg-[#1A0033] text-white p-8 rounded-2xl shadow-2xl border-2 border-[#6A0DAD]">
    {{-- Contenedor principal del panel: centrado, margen superior, fondo oscuro, texto blanco, padding, bordes redondeados, sombra y borde basados en colores de show.blade.php --}}

    <h1 class="text-4xl font-extrabold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-[#9D4EDD] to-[#C77DFF] flex items-center gap-3">
        <i class="fas fa-user-cog text-[#9D4EDD]"></i> Panel de Creador
    </h1>
    {{-- Título del panel: grande, negrita, margen inferior, gradiente de color púrpura y azul de show.blade.php, con un ícono de Font Awesome --}}

    <p class="text-lg mb-6">
        Hola, <span class="font-semibold text-[#E0AAFF]">{{ auth()->user()->name }}</span> 👋 Bienvenido/a de nuevo.
    </p>
    {{-- Mensaje de bienvenida al usuario autenticado, con el nombre resaltado --}}

    @php
        $perfilId = session('perfil_activo');
        $perfilActivo = auth()->user()->perfiles->firstWhere('id', $perfilId);
    @endphp
    {{-- Bloque PHP para obtener el ID del perfil activo de la sesión y cargar el perfil correspondiente --}}

    @if ($perfilActivo)
        <div class="bg-[#3A006D] border border-[#9D4EDD] p-5 rounded-xl shadow-inner mb-6">
            <p class="text-lg flex items-center gap-2">
                <i class="fas fa-user-tag text-[#C77DFF]"></i>
                Perfil activo:
                <span class="font-bold text-[#E0AAFF]">{{ $perfilActivo->nombre_perfil }}</span>
            </p>
        </div>
    @else
        <div class="bg-red-900 border border-red-700 p-4 rounded-xl shadow-md mb-6">
            <p class="text-red-300 font-semibold flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i> No se encontró un perfil activo válido.
            </p>
        </div>
    @endif
    {{-- Muestra el perfil activo si existe, con su nombre resaltado y un ícono. Si no hay perfil activo, muestra un mensaje de error. Colores de fondo y borde adaptados. --}}

    <div class="mt-6 space-y-4">
        <p class="text-base font-medium text-[#E0AAFF]">
            Desde aquí puedes realizar las siguientes acciones:
        </p>
        {{-- Encabezado para la lista de acciones disponibles --}}
        <ul class="list-inside list-disc text-[#C7B8E0] ml-4 space-y-1">
            <li><i class="fas fa-lightbulb text-[#C77DFF] mr-2"></i> Gestionar tus proyectos creativos</li>
            <li><i class="fas fa-layer-group text-[#C77DFF] mr-2"></i> Organizar tareas y secciones</li>
            <li><i class="fas fa-users text-[#C77DFF] mr-2"></i> Colaborar con otros perfiles</li>
        </ul>
        {{-- Lista de funcionalidades con íconos de Font Awesome y colores de show.blade.php --}}
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
{{-- Enlace a la CDN de Font Awesome para los íconos --}}
@endsection {{-- Finaliza la sección de contenido --}}