<section class="text-white">
    <header>
        <h2 class="text-lg font-medium text-white">
            {{ __("Información del Perfil") }}
        </h2>

        <p class="mt-1 text-sm text-gray-300">
            {{ __("Actualiza la información de tu perfil y dirección de correo electrónico.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nombre')" class="text-white" />
            <x-text-input 
                id="name" 
                name="name" 
                type="text" 
                class="mt-1 block w-full bg-[#2B0052] border-[#6A0DAD] text-white focus:border-[#9D4EDD] focus:ring-[#9D4EDD]" 
                :value="old('name', $user->name)" 
                required 
                autofocus 
                autocomplete="name" 
            />
            <x-input-error class="mt-2 text-red-300" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Correo Electrónico')" class="text-white" />
            <x-text-input 
                id="email" 
                name="email" 
                type="email" 
                class="mt-1 block w-full bg-[#2B0052] border-[#6A0DAD] text-white focus:border-[#9D4EDD] focus:ring-[#9D4EDD]" 
                :value="old('email', $user->email)" 
                required 
                autocomplete="username" 
            />
            <x-input-error class="mt-2 text-red-300" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-3 bg-[#2B0052] border border-[#6A0DAD] rounded-lg">
                    <p class="text-sm text-white">
                        {{ __('Tu dirección de correo no está verificada.') }}

                        <button form="send-verification" class="underline text-sm text-[#E0AAFF] hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-[#9D4EDD]">
                            {{ __('Haz clic aquí para reenviar el correo de verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-300">
                            {{ __('Se ha enviado un nuevo enlace de verificación a tu correo electrónico.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-[#9D4EDD] hover:bg-[#7B2CBF] text-white px-4 py-2 rounded-lg shadow transition-colors">
                {{ __('Guardar') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-300"
                >{{ __('Guardado.') }}</p>
            @endif
        </div>
    </form>
</section>