<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="bg-[#1A0033] border border-[#6A0DAD] p-6 rounded-xl shadow-2xl text-white w-full max-w-md">
        @csrf

        <h2 class="text-center text-xl font-semibold text-white mb-4">Registrarse</h2>

        <!-- Nombre -->
        <div>
            <x-input-label for="name" :value="__('Nombre')" class="text-white" />
            <x-text-input id="name" class="block mt-1 w-full bg-[#2B0039] border-[#845EF7] text-white" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
        </div>

        <!-- Correo -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo electrónico')" class="text-white" />
            <x-text-input id="email" class="block mt-1 w-full bg-[#2B0039] border-[#845EF7] text-white" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" class="text-white" />
            <x-text-input id="password" class="block mt-1 w-full bg-[#2B0039] border-[#845EF7] text-white"
                          type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>

        <!-- Confirmación -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" class="text-white" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-[#2B0039] border-[#845EF7] text-white"
                          type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-[#A5FFD6] hover:underline" href="{{ route('login') }}">
                ¿Ya tienes una cuenta?
            </a>

            <x-primary-button class="bg-[#9D4EDD] hover:bg-[#7B2CBF] text-white px-6 py-2 rounded-lg transition">
                Registrarse
            </x-primary-button>
        </div>

        <!-- Autenticación con redes -->
        <div class="mt-6 border-t border-[#6A0DAD] pt-4">
            <p class="text-center text-sm text-white mb-3">O regístrate con</p>
            <div class="flex flex-col gap-3">
                <a href="{{ route('auth.github') }}" class="flex items-center justify-center gap-3 bg-[#24292E] text-white hover:bg-black px-4 py-2 rounded-lg font-semibold transition">
                    <i class="fab fa-github text-xl"></i> GitHub
                </a>
                <a href="{{ route('auth.google') }}" class="flex items-center justify-center gap-3 bg-[#DB4437] text-white hover:bg-red-600 px-4 py-2 rounded-lg font-semibold transition">
                    <i class="fab fa-google text-xl"></i> Google
                </a>
            </div>
        </div>
    </form>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</x-guest-layout>
