@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 space-y-6 text-white">
    {{-- Información del proyecto --}}
    <div class="bg-[#1A0033] border border-[#6A0DAD] shadow-lg rounded-xl p-6">
        <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#9D4EDD] to-[#C77DFF]">
            <i class="fas fa-folder-open mr-2"></i>{{ $proyecto->titulo }}
        </h1>
        <p class="text-[#C7B8E0] mt-2">
            <i class="fas fa-align-left mr-2"></i>{{ $proyecto->descripcion }}
        </p>
    </div>

    {{-- Ramas con tareas asignadas --}}
    <div class="bg-[#1A0033] border border-[#6A0DAD] shadow-lg rounded-xl p-6">
        <h2 class="text-2xl font-bold text-[#E0AAFF] mb-4">
            <i class="fas fa-tasks mr-2"></i>Tus asignaciones en este proyecto
        </h2>

        @if ($ramas->isEmpty())
            <p class="text-[#C7B8E0]">
                <i class="fas fa-info-circle mr-2"></i>No tienes tareas asignadas en este proyecto.
            </p>
        @else
            <ul class="space-y-4">
                @foreach ($ramas as $rama)
                    <li class="bg-[#1A0033] border border-[#9D4EDD] rounded-xl p-5 hover:bg-[#2B0052] transition-all duration-300">
                        <h3 class="text-lg font-semibold text-[#C77DFF]">
                            <i class="fas fa-code-branch mr-2"></i>{{ $rama->nombre }}
                        </h3>
                        <p class="text-sm text-[#E0AAFF] mb-2">
                            <i class="fas fa-quote-left mr-1 text-xs"></i>{{ $rama->descripcion }}
                        </p>

                        <ul class="list-disc list-inside text-sm text-[#A5FFD6]">
                            @foreach ($rama->tareas->where('perfil_id', session('perfil_activo')) as $tarea)
                                <li>
                                    {{ $tarea->titulo }} -
                                    <span class="italic text-[#C7B8E0]">{{ $tarea->estado }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
