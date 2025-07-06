@extends('layouts.app')

@section('title', 'Perfil de Usuario')

@section('content')
<div class="max-w-6xl mx-auto py-8 text-white">

    <!-- Encabezado -->
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#9D4EDD] to-[#C77DFF]">
            <i class="fas fa-user-cog mr-2"></i> Perfil de Usuario
        </h1>
        <p class="text-[#C7B8E0] mt-2 text-sm">
            <i class="fas fa-sliders-h mr-1"></i> Gestiona tu información personal, contraseña y configuración de cuenta.
        </p>
    </div>

    <!-- Contenedor principal -->
    <div class="space-y-8">

        <!-- Actualizar información del perfil -->
        <div class="bg-[#1A0033] border border-[#9D4EDD] rounded-xl p-6 shadow-lg">
            <div class="max-w-2xl mx-auto">
                <div class="flex items-center mb-2">
                    <i class="fas fa-user-edit text-white mr-2"></i>
                    <h2 class="text-xl font-semibold text-white">Información Personal</h2>
                </div>
                <p class="text-sm text-[#C7B8E0] mb-4">
                    <i class="fas fa-info-circle mr-1"></i> Actualiza la información de tu perfil y dirección de correo electrónico.
                </p>
                
                <!-- FORMULARIO DE PERFIL -->
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm text-gray-300 mb-1">Nombre</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full rounded-lg bg-[#2B0052] text-white p-2 border border-[#6A0DAD]" required>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-300 mb-1">Correo Electrónico</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full rounded-lg bg-[#2B0052] text-white p-2 border border-[#6A0DAD]" required>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="btn-accion btn-guardar">
                            <i class="fas fa-save mr-1"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Actualizar contraseña -->
        <div class="bg-[#1A0033] border border-[#9D4EDD] rounded-xl p-6 shadow-lg">
            <div class="max-w-2xl mx-auto">
                <div class="flex items-center mb-4">
                    <i class="fas fa-key text-white mr-2"></i>
                    <h2 class="text-xl font-semibold text-white">Seguridad</h2>
                </div>
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Gestión de perfiles -->
        <div class="bg-[#1A0033] border border-[#9D4EDD] rounded-xl p-6 shadow-lg mt-10">
            <div class="max-w-2xl mx-auto space-y-4">
                <div class="flex items-center mb-4">
                    <i class="fas fa-users text-white mr-2"></i>
                    <h2 class="text-xl font-semibold text-white">Perfiles Asociados</h2>
                </div>

                @foreach ($user->perfiles as $perfil)
                    <div class="flex items-center justify-between p-4 rounded-lg border perfil-box {{ $perfil->activo ? 'border-[#6A0DAD] bg-[#2B0052]' : 'border-gray-700 bg-[#1A0033]' }}">
                        <div>
                            <p class="font-medium text-white">{{ $perfil->nombre_perfil }}</p>
                            <div class="flex items-center space-x-4 mt-1">
                                <span class="text-xs px-2 py-1 rounded-full bg-[#6A0DAD] text-white">
                                    Tipo: {{ ucfirst($perfil->tipo) }}
                                </span>
                                <span class="text-xs px-2 py-1 rounded-full {{ $perfil->activo ? 'bg-green-900 text-white' : 'bg-gray-700 text-gray-300' }}">
                                    {{ $perfil->activo ? 'Activo' : 'Eliminado' }}
                                </span>
                            </div>
                        </div>

                        @if($perfil->activo)
                            <form method="POST" action="{{ route('perfiles.eliminar', $perfil->id) }}">
                                @csrf
                                @method('PATCH')
                                <button class="btn-accion btn-eliminar" type="submit">
                                    <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                </button>
                            </form>
                        @else
                            <span class="text-sm text-gray-300 italic">
                                <i class="fas fa-ban mr-1"></i> Perfil eliminado
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Eliminar cuenta -->
<div class="bg-[#1A0033] border border-red-500 rounded-xl p-6 shadow-lg mt-10">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-4">
            <i class="fas fa-exclamation-triangle text-red-400 mr-2 text-xl"></i>
            <h2 class="text-2xl font-bold text-red-400">Eliminar Cuenta</h2>
        </div>

        <p class="text-sm text-[#FCA5A5] mb-6 leading-relaxed">
            <i class="fas fa-info-circle mr-1"></i>
            Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente. Antes de eliminar tu cuenta, por favor descarga cualquier información que desees conservar.
        </p>

        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-accion btn-peligro">
                <i class="fas fa-user-slash mr-1"></i> Eliminar Cuenta
            </button>
        </form>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Estilos personalizados -->
<style>
    .btn-accion {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
        border-radius: 8px;
        padding: 8px 16px;
        transition: all 0.2s ease-in-out;
        font-size: 14px;
        border: 1.5px solid;
        background-color: #1A0033;
        text-decoration: none;
    }

    .btn-ver {
        color: #6AB7FF;
        border-color: #6AB7FF;
    }

    .btn-ver:hover {
        background-color: #6AB7FF;
        color: #1A0033;
    }

    .btn-eliminar {
        color: #FF6B6B;
        border-color: #FF6B6B;
    }

    .btn-eliminar:hover {
        background-color: #FF6B6B;
        color: #1A0033;
    }

    .btn-guardar {
        color: #4ADE80;
        border-color: #4ADE80;
    }

    .btn-guardar:hover {
        background-color: #4ADE80;
        color: #1A0033;
    }

    .btn-peligro {
        color: #F87171;
        border-color: #F87171;
    }

    .btn-peligro:hover {
        background-color: #F87171;
        color: #1A0033;
    }

    .btn-accion i {
        font-size: 15px;
    }

    .perfil-box {
        transition: all 0.2s ease-in-out;
    }

    .perfil-box:hover {
        background-color: #3A006D;
        transform: scale(1.01);
        border-color: #C77DFF;
    }
</style>
@endsection
