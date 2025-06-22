@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-12 bg-[#1A0033] text-white p-8 rounded-2xl shadow-2xl border-2 border-[#6A0DAD]">

    <h1 class="text-4xl font-extrabold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-[#9D4EDD] to-[#C77DFF] flex items-center gap-3">
        <i class="fas fa-user-cog text-[#9D4EDD]"></i> Panel de Colaborador
    </h1>

    <p class="text-lg mb-6">
        Bienvenido, <span class="font-semibold text-[#E0AAFF]">{{ auth()->user()->name }}</span> 👋
    </p>

    @php
        $perfilId = session('perfil_activo');
        $perfilActivo = auth()->user()->perfiles->firstWhere('id', $perfilId);
    @endphp

    @if ($perfilActivo)
        <div class="bg-[#3A006D] border border-[#9D4EDD] p-5 rounded-xl shadow-inner mb-6">
            <p class="text-lg flex items-center gap-2">
                <i class="fas fa-id-badge text-[#C77DFF]"></i>
                Tu perfil activo es: 
                <span class="font-bold text-[#A5FFD6]">{{ $perfilActivo->nombre_perfil }}</span>
            </p>
        </div>
    @else
        <div class="bg-[#3A002F] border border-[#FF6B6B] px-4 py-3 rounded-lg shadow-md mb-6">
            <p class="text-[#FFA5A5] font-semibold flex items-center gap-2">
                <i class="fas fa-exclamation-triangle"></i>
                No se encontró un perfil activo válido.
            </p>
        </div>
    @endif

    <div class="mt-6 text-[#C7B8E0]">
        <p class="flex items-center gap-2">
            <i class="fas fa-info-circle"></i>
            Aquí podrás ver las tareas que te han sido asignadas y subir archivos.
        </p>
    </div>
</div>

{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
