<section class="space-y-6 text-white">
    <header>
        <h2 class="text-lg font-medium text-white">
            {{ __('Eliminar Cuenta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-300">
            {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente. Antes de eliminar tu cuenta, por favor descarga cualquier información que desees conservar.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow transition-colors"
    >
        {{ __('Eliminar Cuenta') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-[#1A0033] border border-[#9D4EDD] rounded-lg">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-white">
                {{ __('¿Estás seguro que deseas eliminar tu cuenta?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-300">
                {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente. Por favor ingresa tu contraseña para confirmar que deseas eliminar tu cuenta permanentemente.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Contraseña') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 bg-[#2B0052] border-[#6A0DAD] text-white focus:border-[#9D4EDD] focus:ring-[#9D4EDD]"
                    placeholder="{{ __('Contraseña') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-300" />
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button 
                    x-on:click="$dispatch('close')"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow transition-colors"
                >
                    {{ __('Cancelar') }}
                </button>

                <button 
                    type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow transition-colors"
                >
                    {{ __('Eliminar Cuenta') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>