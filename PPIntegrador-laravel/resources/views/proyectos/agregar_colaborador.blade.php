@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 space-y-6">
    <div class="bg-white shadow p-6 rounded">
        <h2 class="text-xl font-bold mb-4">Agregar colaborador a: {{ $proyecto->titulo }}</h2>

        <input type="text" id="busqueda" placeholder="Buscar colaborador..." class="w-full mb-4 p-2 border rounded">

        <ul id="listaColaboradores" class="space-y-2">
            @foreach ($colaboradores as $colaborador)
                @php
                    $yaAgregado = $proyecto->colaboradores->contains($colaborador->id);
                @endphp
                <li class="p-2 border rounded flex justify-between items-center colaborador-item">
                    <span>{{ $colaborador->nombre_perfil }} <span class="text-gray-500 text-sm">({{ $colaborador->tipo }})</span></span>
                    @if (!$yaAgregado)
                        <form method="POST" action="{{ route('proyectos.colaboradores.agregar', $proyecto) }}">
                            @csrf
                            <input type="hidden" name="perfil_id" value="{{ $colaborador->id }}">
                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Agregar</button>
                        </form>
                    @else
                        <span class="text-gray-400 text-sm italic">Ya agregado</span>
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
@endsection
