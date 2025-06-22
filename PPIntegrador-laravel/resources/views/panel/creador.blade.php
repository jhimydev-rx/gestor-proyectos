@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-3xl font-bold mb-4">Panel de Creador</h1>

    <p>Bienvenido, {{ auth()->user()->name }}.</p>

    @php
        $perfilId = session('perfil_activo');
        $perfilActivo = auth()->user()->perfiles->firstWhere('id', $perfilId);
    @endphp

    @if ($perfilActivo)
        <p>Tu perfil activo es: <strong>{{ $perfilActivo->nombre_perfil}} </strong></p>
    @else
        <p class="text-red-600">No se encontró un perfil activo válido.</p>
    @endif

    <div class="mt-6">
        <p>Aquí podrás ver y administrar tus proyectos, ramas y tareas.</p>
    </div>
</div>
@endsection
