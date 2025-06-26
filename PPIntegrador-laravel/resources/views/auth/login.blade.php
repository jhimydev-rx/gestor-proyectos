


<x-guest-layout>
    <!-- Estado de sesión -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="bg-[#1A0033] border border-[#6A0DAD] p-6 rounded-xl shadow-2xl text-white w-full max-w-md">
        @csrf

        <h2 class="text-center text-xl font-semibold text-white mb-4">Iniciar sesión</h2>

        <!-- Correo electrónico -->
        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" class="text-white" />
            <x-text-input id="email" class="block mt-1 w-full bg-[#2B0039] border-[#845EF7] text-white" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" class="text-white" />
            <x-text-input id="password" class="block mt-1 w-full bg-[#2B0039] border-[#845EF7] text-white"
                          type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>

        <!-- Recordarme -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center text-white">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#9D4EDD] shadow-sm focus:ring-[#9D4EDD]" name="remember">
                <span class="ml-2 text-sm">Recordarme</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-[#A5FFD6] hover:underline" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif

            <x-primary-button class="bg-[#9D4EDD] hover:bg-[#7B2CBF] text-white px-6 py-2 rounded-lg transition">
                Iniciar sesión
            </x-primary-button>
        </div>

        <!-- Autenticación con redes -->
        <div class="mt-6 border-t border-[#6A0DAD] pt-4">
            <p class="text-center text-sm text-white mb-3">O inicia sesión con</p>
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