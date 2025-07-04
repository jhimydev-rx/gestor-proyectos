@extends('layouts.app') {{-- Extiende la plantilla principal de la aplicación --}}

@section('content') {{-- Inicia la sección de contenido --}}
<div class="max-w-4xl mx-auto mt-10 space-y-6 text-white">

    {{-- 🔙 Botón de regresar --}}
    <div class="flex justify-start">
        <a href="{{ route('proyectos.show', $proyecto) }}"
           class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300 flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Regresar
        </a>
    </div>

    <div class="bg-[#1A0033] border-2 border-[#6A0DAD] shadow-2xl p-6 rounded-2xl">
        {{-- Contenedor del formulario --}}

        <h2 class="text-2xl font-extrabold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-[#9D4EDD] to-[#C77DFF] flex items-center gap-3">
            <i class="fas fa-user-plus text-[#9D4EDD]"></i> Agregar Colaborador a: <span class="ml-2">{{ $proyecto->titulo }}</span>
        </h2>

        <div class="mb-6">
            <input type="text" id="busqueda" placeholder="Buscar colaborador..."
                   class="w-full bg-[#3A006D] text-white border border-[#9D4EDD] placeholder-[#C7B8E0] p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C77DFF] transition" />
        </div>

        <ul id="listaColaboradores" class="space-y-4">
            @foreach ($colaboradores as $colaborador)
                @php
                    $yaAgregado = $proyecto->colaboradores->contains($colaborador->id);
                @endphp
                <li class="flex justify-between items-center bg-[#3A006D] border border-[#6A0DAD] rounded-xl p-4 shadow hover:shadow-lg transition colaborador-item">
                    <div class="flex flex-col">
                        <span class="font-semibold text-[#E0AAFF]">{{ $colaborador->nombre_perfil }}</span>
                        <span class="text-sm text-[#C7B8E0] italic">({{ ucfirst($colaborador->tipo) }})</span>
                    </div>

                    @if (!$yaAgregado)
                        <form method="POST" action="{{ route('proyectos.colaboradores.agregar', $proyecto) }}">
                            @csrf
                            <input type="hidden" name="perfil_id" value="{{ $colaborador->id }}">
                            <button type="submit"
                                    class="bg-gradient-to-r from-emerald-600 to-emerald-400 hover:from-emerald-700 hover:to-emerald-500 text-white font-semibold px-4 py-2 rounded-lg transition-all shadow">
                                <i class="fas fa-plus mr-1"></i> Agregar
                            </button>
                        </form>
                    @else
                        <span class="text-sm text-[#C7B8E0] italic">Ya agregado</span>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>

<script>
    document.getElementById('busqueda').addEventListener('input', function () {
        const filtro = this.value.toLowerCase();
        document.querySelectorAll('.colaborador-item').forEach(item => {
            const texto = item.textContent.toLowerCase();
            item.style.display = texto.includes(filtro) ? 'flex' : 'none';
        });
    });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection {{-- Finaliza la sección de contenido --}}
