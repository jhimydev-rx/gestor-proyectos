@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-[#1A0033] p-6 rounded-xl border border-[#6A0DAD] shadow-lg text-white">
    <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#9D4EDD] to-[#C77DFF] mb-6">
        <i class="fas fa-tasks mr-2"></i> Proyectos Asignados
    </h1>

    @if ($proyectos->isEmpty())
        <p class="text-[#C7B8E0]">
            <i class="fas fa-info-circle mr-2"></i>No tienes proyectos asignados por el momento.
        </p>
    @else
        <ul class="space-y-4">
            @foreach ($proyectos as $proyecto)
                <li class="bg-[#1A0033] border border-[#6A0DAD] p-5 rounded-xl hover:bg-[#2B0052] transition-all duration-300">
                    <h2 class="text-xl font-semibold text-[#E0AAFF]">
                        <i class="fas fa-folder mr-2"></i>{{ $proyecto->titulo }}
                    </h2>
                    <p class="text-[#C7B8E0] mt-1">
                        <i class="fas fa-align-left mr-1"></i>{{ $proyecto->descripcion }}
                    </p>
                    <a href="{{ route('colaborador.proyectos.show', $proyecto) }}"
                       class="inline-block mt-3 bg-[#6A0DAD]/10 border border-[#6A0DAD] hover:bg-[#6A0DAD]/20 text-[#C77DFF] hover:text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-300">
                        <i class="fas fa-eye mr-1"></i> Ver proyecto
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
