@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10 text-white">
    <div class="mb-10 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#9D4EDD] to-[#C77DFF]">
                <i class="fas fa-folder-open mr-2"></i> Mis Proyectos
            </h1>
            <div class="w-20 h-1 mt-2 bg-gradient-to-r from-[#9D4EDD] to-[#6A0DAD]"></div>
        </div>

        <a href="{{ route('proyectos.create') }}"
           class="bg-gradient-to-r from-[#9D4EDD] to-[#6A0DAD] hover:from-[#7B2CBF] hover:to-[#5F3DC4] text-white px-5 py-2 rounded-xl shadow-lg font-semibold transition-all duration-300 flex items-center gap-2">
            <i class="fas fa-plus"></i> Nuevo Proyecto
        </a>
    </div>

    @if (session('success'))
        <div class="bg-[#004d40] text-[#A5FFD6] px-4 py-3 mb-6 rounded-lg border border-[#00bfa5] shadow-md flex items-center gap-2">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($proyectos as $proyecto)
            <div class="bg-gradient-to-b from-[#3A006D] to-[#1A0033] border border-[#6A0DAD] rounded-2xl p-5 shadow-xl hover:shadow-[#C77DFF]/30 transition">
                <div class="flex justify-center items-center h-40 bg-gradient-to-b from-[#2E134E] to-[#1A0033] rounded-lg mb-4">
                    <i class="fas fa-diagram-project text-6xl text-[#C7A9F8]"></i>
                </div>

                <h2 class="text-xl font-bold text-[#E0AAFF] mb-4">
                    <i class="fas fa-bookmark mr-1 text-[#C77DFF]"></i> {{ $proyecto->titulo }}
                </h2>

                <div class="mb-4">
                    <span class="inline-flex items-center gap-2 bg-[#9D4EDD] text-white text-xs px-3 py-1 rounded-full shadow-sm">
                        <i class="fas fa-circle-notch fa-spin"></i> Activo
                    </span>
                </div>

                <!-- Botones -->
                <div class="flex gap-2">
                    <!-- Ver -->
                    <a href="{{ route('proyectos.show', $proyecto) }}"
                       class="flex-1 flex items-center justify-center gap-2 border border-[#9D4EDD] text-[#E0AAFF] hover:bg-[#9D4EDD] hover:text-white px-3 py-2 rounded-lg text-sm transition">
                        <i class="fas fa-eye"></i> Ver
                    </a>

                    <!-- Editar -->
                    <a href="{{ route('proyectos.edit', $proyecto) }}"
                       class="flex-1 flex items-center justify-center gap-2 border border-[#FFD700] text-[#FFD700] hover:bg-[#FFD700]/10 px-3 py-2 rounded-lg text-sm transition">
                        <i class="fas fa-edit"></i> Editar
                    </a>

                    <!-- Eliminar -->
                    <form action="{{ route('proyectos.destroy', $proyecto) }}" method="POST"
                          onsubmit="return confirm('¿Estás seguro de eliminar este proyecto?')"
                          class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="flex w-full items-center justify-center gap-2 border border-[#FF6B6B] text-[#FF6B6B] hover:bg-[#FF6B6B]/10 px-3 py-2 rounded-lg text-sm transition">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </button>
                    </form>
                </div>

                <div class="mt-6 text-xs text-[#C7B8E0] flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-[#C77DFF]"></i>
                        {{ $proyecto->created_at->format('d/m/Y') }}
                    </div>
                    <div class="flex items-center gap-2" title="Creador">
                        <i class="fas fa-user text-[#C77DFF]"></i>
                        {{ optional($proyecto->creador)->nombre_perfil ?? 'Desconocido' }}
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-[#E0AAFF] bg-[#3A006D]/40 p-6 rounded-xl border border-[#6A0DAD]">
                <i class="fas fa-folder-open text-3xl mb-2"></i>
                <p class="text-lg">No tienes proyectos aún.</p>
            </div>
        @endforelse
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
