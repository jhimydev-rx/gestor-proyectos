@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 text-white">
    <h1 class="text-3xl font-bold text-[#E0AAFF] mb-4">
        <i class="fas fa-tasks mr-2"></i>{{ $tarea->titulo }}
    </h1>

    <div class="bg-[#1A0033] border border-[#6A0DAD] rounded-xl p-6 space-y-4">
        <p><strong>Descripción:</strong> {{ $tarea->descripcion }}</p>
        <p><strong>Estado:</strong> {{ $tarea->estado }}</p>
        <p><strong>Fecha límite:</strong> {{ $tarea->fecha_limite }}</p>

        @if ($tarea->archivos->isNotEmpty())
            <div>
                <strong>Archivo de referencia:</strong>
                <ul class="list-disc list-inside mt-2 text-[#A5FFD6]">
                    @foreach ($tarea->archivos as $archivo)
                        <li>
                            <a href="{{ asset('storage/' . $archivo->ruta) }}" class="underline text-violet-400" target="_blank">
                                {{ basename($archivo->ruta) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-6">
            <a href="#" class="bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded text-white">
                Subir archivo para revisión (por implementar)
            </a>
        </div>

        <div class="mt-10 bg-[#2B0052] rounded p-4">
            <h3 class="text-lg font-semibold mb-2">Chat / Consultas (próximamente)</h3>
            <p class="text-sm text-[#C7B8E0]">Aquí se integrará el chat con Node.js o similar.</p>
        </div>
    </div>
</div>
@endsection
