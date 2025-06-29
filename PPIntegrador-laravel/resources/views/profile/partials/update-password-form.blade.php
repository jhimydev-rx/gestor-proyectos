<section class="text-white">
    <header>
        <h2 class="text-lg font-medium text-white">
            {{ __('Actualizar Contraseña') }}
        </h2>

        <p class="mt-1 text-sm text-gray-300">
            {{ __('Asegúrate de usar una contraseña larga y aleatoria para mantener tu cuenta segura.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Contraseña Actual')" class="text-white" />
            <x-text-input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="mt-1 block w-full bg-[#2B0052] border-[#6A0DAD] text-white focus:border-[#9D4EDD] focus:ring-[#9D4EDD]" 
                autocomplete="current-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-300" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Nueva Contraseña')" class="text-white" />
            <x-text-input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="mt-1 block w-full bg-[#2B0052] border-[#6A0DAD] text-white focus:border-[#9D4EDD] focus:ring-[#9D4EDD]" 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-300" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmar Contraseña')" class="text-white" />
            <x-text-input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="mt-1 block w-full bg-[#2B0052] border-[#6A0DAD] text-white focus:border-[#9D4EDD] focus:ring-[#9D4EDD]" 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-300" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-[#9D4EDD] hover:bg-[#7B2CBF] text-white px-4 py-2 rounded-lg shadow transition-colors">
                {{ __('Guardar') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-300"
                >{{ __('Contraseña actualizada.') }}</p>
            @endif
        </div>
    </form>
</section>