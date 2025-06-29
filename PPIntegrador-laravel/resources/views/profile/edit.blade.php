@extends('layouts.app')

@section('title', 'Perfil de Usuario')

@section('content')
<div class="max-w-6xl mx-auto py-8 text-white">
    <!-- Encabezado -->
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-white">
            <i class="fas fa-user-cog mr-2"></i> {{ __('Perfil de Usuario') }}
        </h1>
        <p class="text-gray-300 mt-2">Gestiona tu información personal, contraseña y configuración de cuenta.</p>
    </div>

    <!-- Contenedor principal -->
    <div class="space-y-8">

        <!-- Actualizar información del perfil -->
        <div class="bg-[#1A0033] border border-[#9D4EDD] rounded-xl p-6 shadow-lg">
            <div class="max-w-2xl mx-auto">
                <div class="flex items-center mb-4">
                    <i class="fas fa-user-edit text-white mr-2"></i>
                    <h2 class="text-xl font-semibold text-white">Información Personal</h2>
                </div>
                @include('profile.partials.update-profile-information-form')
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
                    <div class="flex items-center justify-between p-4 rounded-lg border {{ $perfil->activo ? 'border-[#6A0DAD] bg-[#2B0052]' : 'border-gray-700 bg-[#1A0033]' }}">
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
                                <button class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded-lg shadow flex items-center transition-colors" type="submit">
                                    <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                </button>
                            </form>
                        @else
                            <span class="text-sm text-gray-300 italic">Perfil eliminado</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
        <!-- Eliminar cuenta -->
        <div class="bg-[#1A0033] border border-red-500 rounded-xl p-6 shadow-lg">
            <div class="max-w-2xl mx-auto">
                <div class="flex items-center mb-4">
                    <i class="fas fa-exclamation-triangle text-red-300 mr-2"></i>
                    <h2 class="text-xl font-semibold text-white">Eliminar Cuenta</h2>
                </div>
                @include('profile.partials.delete-user-form')
            </div>
        </div>

        
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection