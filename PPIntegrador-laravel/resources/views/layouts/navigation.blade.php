<nav x-data="{ open: false, profileOpen: false }" class="bg-black border-b border-purple-500 shadow-lg">
    @php
        $perfilId = session('perfil_activo');
        $perfilesUsuario = auth()->user()->perfiles;
        $perfilActivo = $perfilesUsuario->firstWhere('id', $perfilId);
        $perfilesActivos = $perfilesUsuario->where('activo', true);
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex items-center space-x-8">
                <a href="{{ route('inicio') }}" class="flex items-center group transition-all duration-300 hover:scale-105">
                    <div class="relative h-10 w-10 mr-3 group-hover:rotate-12 transition-transform duration-500">
                        <div class="absolute inset-0 rounded-full border-2 border-purple-400 animate-pulse"></div>
                        <div class="absolute inset-2 rounded-full border border-purple-300/50"></div>
                        <div class="absolute inset-3 rounded-sm bg-gradient-to-br from-purple-500 to-purple-700 shadow-inner shadow-purple-900/50"></div>
                    </div>
                    <span class="text-3xl font-bold tracking-tighter">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-300 to-purple-100 group-hover:from-purple-200 group-hover:to-white transition-all duration-300">
                            GOXU
                        </span>
                    </span>
                </a>

                @if ($perfilActivo)
                    <div class="hidden sm:flex space-x-1">
                        <x-nav-link :href="route('inicio')" :active="request()->routeIs('inicio')">
                            <span class="relative z-10 flex items-center">
                                Inicio
                            </span>
                        </x-nav-link>

                        @if ($perfilActivo->tipo === 'creador')
                            <x-nav-link :href="route('proyectos.index')" :active="request()->routeIs('proyectos.*')">
                                <span class="relative z-10 flex items-center">
                                    Mis Proyectos
                                </span>
                            </x-nav-link>
                        @elseif ($perfilActivo->tipo === 'colaborador')
                            <x-nav-link :href="route('colaborador.proyectos')" :active="request()->routeIs('colaborador.proyectos')">
                                <span class="relative z-10 flex items-center">
                                    Proyectos Asignados
                                </span>
                            </x-nav-link>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Selector de perfil -->
            <div class="flex items-center space-x-4">
                @if ($perfilesActivos->count() < 2)
                    <a href="{{ route('perfil.crear.otro') }}" class="hidden sm:inline-flex items-center bg-purple-600 hover:bg-purple-500 text-white px-4 py-1.5 rounded-md text-sm font-medium">
                        Nuevo Perfil
                    </a>
                @endif

                <div class="hidden sm:block relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center space-x-2 bg-purple-900/80 hover:bg-purple-800 border border-purple-600 rounded-md px-3 py-1.5 text-sm text-white font-medium">
                        <span class="flex items-center">
                            <span class="h-2 w-2 rounded-full bg-purple-300 mr-2"></span>
                            <span class="text-purple-200 font-semibold">
                                {{ $perfilActivo?->tipo ?? 'Perfil no definido' }}
                            </span>
                        </span>
                        <span class="text-gray-100 truncate max-w-xs font-normal">
                            {{ $perfilActivo?->nombre_perfil ?? 'Sin nombre de perfil' }}
                        </span>
                    </button>

                    <div x-show="open" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-xl bg-gray-900 border border-purple-500/50 z-50">
                        <form method="POST" action="{{ route('perfil.cambiar') }}">
                            @csrf
                            <div class="py-1">
                                @foreach($perfilesActivos as $perfil)
                                    <button type="submit" name="perfil_id" value="{{ $perfil->id }}"
                                            class="w-full text-left px-4 py-2.5 text-sm flex items-center justify-between text-gray-200 hover:bg-purple-800/60 {{ session('perfil_activo') == $perfil->id ? 'text-white bg-purple-800/50 font-semibold' : '' }}">
                                        <span class="flex items-center">
                                            @if(session('perfil_activo') == $perfil->id)
                                                <svg class="w-4 h-4 mr-2 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @else
                                                <span class="w-4 h-4 mr-2 rounded-full border border-purple-400"></span>
                                            @endif
                                            <span class="flex-1 truncate">
                                                <span class="font-medium text-purple-200">{{ ucfirst($perfil->tipo) }}</span> - {{ $perfil->nombre_perfil ?? 'Sin nombre' }}
                                            </span>
                                        </span>
                                    </button>
                                @endforeach
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Avatar -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center space-x-2 group">
                        <div class="h-9 w-9 rounded-full bg-gradient-to-br from-purple-700 to-purple-800 border border-purple-500 flex items-center justify-center text-white font-medium">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </button>

                    <div x-show="open" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-xl bg-gray-900 border border-purple-500/50 z-50">
                        <div class="py-1 divide-y divide-purple-500/30">
                            <x-dropdown-link :href="route('profile.edit')">
                                Ajustes
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Cerrar sesión
                                </x-dropdown-link>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boton Mobile -->
            <div class="sm:hidden">
                <button @click="open = !open" class="text-gray-200 hover:text-white focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
