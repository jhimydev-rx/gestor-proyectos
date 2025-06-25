@php
    $perfilId = session('perfil_activo');
    $perfilActivo = auth()->user()?->perfiles->firstWhere('id', $perfilId);
    $perfilesUsuario = auth()->user()->perfiles;
    $tiposPerfil = $perfilesUsuario->pluck('tipo')->toArray();
@endphp

<!-- Navigation Menu -->
<nav x-data="{ open: false }" class="bg-black bg-opacity-90 border-b border-violet-600 shadow-lg shadow-violet-900/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo + Links (izquierda) -->
            <div class="flex items-center space-x-8">
                <!-- Logo GOXU -->
                <a href="{{ route('inicio') }}" class="flex items-center group relative">
                    <!-- Símbolo: Flor de la vida minimalista -->
                    <svg class="h-12 w-12 mr-2 transition-all duration-500 group-hover:rotate-180" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="50" r="30" stroke="#5B21B6" stroke-width="1.5" stroke-dasharray="2 2"/>
                        <circle cx="35" cy="50" r="15" stroke="#7C3AED" stroke-width="1.2"/>
                        <circle cx="65" cy="50" r="15" stroke="#7C3AED" stroke-width="1.2"/>
                        <circle cx="50" cy="50" r="3" fill="#5B21B6"/>
                    </svg>

                    <!-- Tipografía custom -->
                    <div class="relative">
                        <span class="text-4xl font-bold text-violet-900 tracking-tighter block font-['Arial'] italic">GOXU</span>
                        <span class="text-4xl font-bold text-violet-700 tracking-tighter absolute top-0 left-0.5 font-['Arial'] italic" style="clip-path: inset(0 0 60% 0);">GOXU</span>
                        <span class="text-4xl font-bold text-violet-500 tracking-tighter absolute top-0 left-1 font-['Arial'] italic" style="clip-path: inset(0 0 80% 0);">GOXU</span>
                        <div class="h-0.5 w-0 bg-violet-400 group-hover:w-full transition-all duration-700 origin-left"></div>
                    </div>
                </a>

                <!-- Links según tipo de perfil (Desktop) -->
                @if ($perfilActivo)
                    <div class="hidden sm:flex space-x-8">
                        <x-nav-link :href="route('inicio')" :active="request()->routeIs('inicio')" class="text-white hover:text-violet-300">
                            {{ __('Inicio') }}
                        </x-nav-link>
                        @if ($perfilActivo->tipo === 'creador')
                            <x-nav-link :href="route('proyectos.index')" :active="request()->routeIs('proyectos.*')" class="text-white hover:text-violet-300">
                                {{ __('Mis Proyectos') }}
                            </x-nav-link>
                        @elseif ($perfilActivo->tipo === 'colaborador')
                            <x-nav-link :href="route('colaborador.proyectos')" :active="request()->routeIs('colaborador.proyectos')" class="text-white hover:text-violet-300">
                                {{ __('Proyectos Asignados') }}
                            </x-nav-link>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Selector de Perfil + Dropdown (derecha) -->
            <div class="flex items-center space-x-4">
                <!-- Crear otro perfil si solo tiene uno -->
                @if (count($tiposPerfil) === 1)
                    <a href="{{ route('perfil.crear.otro') }}"
                       class="hidden sm:inline-block bg-violet-600 hover:bg-violet-700 text-white px-3 py-1 rounded-md text-sm transition-all">
                        Crear otro perfil
                    </a>
                @endif

                <!-- Selector de Perfil (SIEMPRE visible) -->
                <form method="POST" action="{{ route('perfil.cambiar') }}" class="hidden sm:block">
                    @csrf
                    <select name="perfil_id" onchange="this.form.submit()"
                        class="bg-gray-900 text-white border border-violet-500 rounded-md px-3 py-1 text-sm focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all cursor-pointer">
                        @foreach(Auth::user()->perfiles as $perfil)
                            <option value="{{ $perfil->id }}" {{ session('perfil_activo') == $perfil->id ? 'selected' : '' }}>
                                {{ ucfirst($perfil->tipo) }} - {{ $perfil->nombre_perfil }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <!-- Dropdown (Ajustes + Logout) -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center space-x-1 text-white hover:text-violet-300 transition-colors">
                            <span class="font-medium">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 text-violet-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="bg-gray-900 border border-violet-500/30 rounded-md py-1 shadow-xl">
                            <x-dropdown-link :href="route('profile.edit')" class="text-white hover:bg-violet-900/50">
                                {{ __('Ajustes') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-white hover:bg-violet-900/50">
                                    {{ __('Cerrar sesión') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="sm:hidden">
                <button @click="open = !open" class="text-violet-300 hover:text-white">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path :class="{ 'hidden': open, 'block': !open }" class="block" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'block': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menú Mobile -->
    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden bg-gray-900/95 border-t border-violet-600/50">
        <div class="px-4 py-3 space-y-3">
            <!-- Crear otro perfil (Mobile) -->
            @if (count($tiposPerfil) === 1)
                <x-responsive-nav-link :href="route('perfil.crear.otro')" class="text-white hover:bg-violet-900/50">
                    {{ __('Crear otro perfil') }}
                </x-responsive-nav-link>
            @endif

            <!-- Selector de Perfil (Mobile) -->
            <form method="POST" action="{{ route('perfil.cambiar') }}">
                @csrf
                <select name="perfil_id" onchange="this.form.submit()"
                    class="w-full bg-gray-800 text-white border border-violet-500 rounded-md px-3 py-2 text-sm">
                    @foreach(Auth::user()->perfiles as $perfil)
                        <option value="{{ $perfil->id }}" {{ session('perfil_activo') == $perfil->id ? 'selected' : '' }}>
                            {{ ucfirst($perfil->tipo) }} - {{ $perfil->nombre_perfil }}
                        </option>
                    @endforeach
                </select>
            </form>

            <!-- Links Mobile -->
            <x-responsive-nav-link :href="route('inicio')" :active="request()->routeIs('inicio')" class="text-white hover:bg-violet-900/50">
                {{ __('Inicio') }}
            </x-responsive-nav-link>
            @if ($perfilActivo)
                @if ($perfilActivo->tipo === 'creador')
                    <x-responsive-nav-link :href="route('proyectos.index')" :active="request()->routeIs('proyectos.*')" class="text-white hover:bg-violet-900/50">
                        {{ __('Mis Proyectos') }}
                    </x-responsive-nav-link>
                @elseif ($perfilActivo->tipo === 'colaborador')
                    <x-responsive-nav-link :href="route('colaborador.proyectos')" :active="request()->routeIs('colaborador.proyectos')" class="text-white hover:bg-violet-900/50">
                        {{ __('Proyectos Asignados') }}
                    </x-responsive-nav-link>
                @endif
            @endif
            <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:bg-violet-900/50">
                {{ __('Ajustes') }}
            </x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-white hover:bg-violet-900/50">
                    {{ __('Cerrar sesión') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>
