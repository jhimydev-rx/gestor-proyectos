@php
    $perfilId = session('perfil_activo');
    $perfilesUsuario = auth()->user()->perfiles;
    $perfilActivo = $perfilesUsuario->firstWhere('id', $perfilId);
    $perfilesActivos = $perfilesUsuario->where('activo', true); // Solo activos
@endphp

<!-- Navigation Menu -->
<nav x-data="{ open: false, profileOpen: false }" class="bg-black border-b border-purple-500 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo + Links (izquierda) -->
            <div class="flex items-center space-x-8">
                <!-- Logo GOXU - Versión elegante mejorada -->
                <a href="{{ route('inicio') }}" class="flex items-center group transition-all duration-300 hover:scale-105">
                    <!-- Símbolo geométrico mejorado -->
                    <div class="relative h-10 w-10 mr-3 group-hover:rotate-12 transition-transform duration-500">
                        <div class="absolute inset-0 rounded-full border-2 border-purple-400 animate-pulse"></div>
                        <div class="absolute inset-2 rounded-full border border-purple-300/50"></div>
                        <div class="absolute inset-3 rounded-sm bg-gradient-to-br from-purple-500 to-purple-700 shadow-inner shadow-purple-900/50"></div>
                    </div>

                    <!-- Tipografía mejorada -->
                    <span class="text-3xl font-bold tracking-tighter">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-300 to-purple-100 group-hover:from-purple-200 group-hover:to-white transition-all duration-300">
                            GOXU
                        </span>
                    </span>
                </a>

                <!-- Links según tipo de perfil (Desktop) -->
                @if ($perfilActivo)
                    <div class="hidden sm:flex space-x-1">
                        <x-nav-link :href="route('inicio')" :active="request()->routeIs('inicio')" 
                                   class="relative text-gray-200 hover:text-white px-3 py-1.5 font-medium transition-all duration-200 group">
                            <span class="relative z-10 flex items-center">
                                <svg class="w-5 h-5 mr-1.5 text-purple-300 group-hover:text-purple-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                {{ __('Inicio') }}
                            </span>
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-purple-400 to-purple-300 opacity-0 group-hover:opacity-100 transition-all duration-300"></span>
                        </x-nav-link>
                        
                        @if ($perfilActivo->tipo === 'creador')
                            <x-nav-link :href="route('proyectos.index')" :active="request()->routeIs('proyectos.*')" 
                                       class="relative text-gray-200 hover:text-white px-3 py-1.5 font-medium transition-all duration-200 group">
                                <span class="relative z-10 flex items-center">
                                    <svg class="w-5 h-5 mr-1.5 text-purple-300 group-hover:text-purple-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    {{ __('Mis Proyectos') }}
                                </span>
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-purple-400 to-purple-300 opacity-0 group-hover:opacity-100 transition-all duration-300"></span>
                            </x-nav-link>
                        @elseif ($perfilActivo->tipo === 'colaborador')
                            <x-nav-link :href="route('colaborador.proyectos')" :active="request()->routeIs('colaborador.proyectos')" 
                                       class="relative text-gray-200 hover:text-white px-3 py-1.5 font-medium transition-all duration-200 group">
                                <span class="relative z-10 flex items-center">
                                    <svg class="w-5 h-5 mr-1.5 text-purple-300 group-hover:text-purple-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    {{ __('Proyectos Asignados') }}
                                </span>
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-purple-400 to-purple-300 opacity-0 group-hover:opacity-100 transition-all duration-300"></span>
                            </x-nav-link>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Selector de Perfil + Dropdown (derecha) -->
            <div class="flex items-center space-x-4">
                <!-- Crear otro perfil si solo tiene uno -->
                @if ($perfilesActivos->count() < 2)
                    <a href="{{ route('perfil.crear.otro') }}"
                       class="hidden sm:inline-flex items-center bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-500 hover:to-purple-600 text-white px-4 py-1.5 rounded-md text-sm font-medium transition-all duration-200 hover:shadow-lg hover:shadow-purple-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-purple-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Nuevo Perfil
                    </a>
                @endif

                <!-- Selector de Perfil mejorado -->
                <div class="hidden sm:block relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center space-x-2 bg-purple-900/80 hover:bg-purple-800 border border-purple-600 rounded-md px-3 py-1.5 text-sm text-white font-medium transition-all duration-200 shadow-md hover:shadow-purple-500/30">
                        <span class="flex items-center">
                            <span class="h-2 w-2 rounded-full bg-purple-300 mr-2 shadow-sm shadow-purple-300/50"></span>
                            <span class="text-purple-200 font-semibold">{{ ucfirst($perfilActivo->tipo) }}</span>
                        </span>
                        <span class="text-gray-100 truncate max-w-xs font-normal">{{ $perfilActivo->nombre_perfil }}</span>
                        <svg class="h-4 w-4 text-purple-300 transition-transform duration-200" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" 
                         x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" 
                         x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" 
                         x-transition:leave-end="opacity-0 scale-95" 
                         class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-xl bg-gray-900 border border-purple-500/50 z-50 overflow-hidden backdrop-blur-sm">
                        <form method="POST" action="{{ route('perfil.cambiar') }}">
                            @csrf
                            <div class="py-1">
                                @foreach(Auth::user()->perfiles->where('activo', true) as $perfil)
                                    <button type="submit" name="perfil_id" value="{{ $perfil->id }}" 
                                            class="w-full text-left px-4 py-2.5 text-sm flex items-center justify-between text-gray-200 hover:bg-purple-800/60 transition-all duration-200 {{ session('perfil_activo') == $perfil->id ? 'text-white bg-purple-800/50 font-semibold' : '' }}">
                                        <span class="flex items-center">
                                            @if(session('perfil_activo') == $perfil->id)
                                                <svg class="w-4 h-4 mr-2 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @else
                                                <span class="w-4 h-4 mr-2 rounded-full border border-purple-400"></span>
                                            @endif
                                            <span class="flex-1 truncate">
                                                <span class="font-medium text-purple-200">{{ ucfirst($perfil->tipo) }}</span> - {{ $perfil->nombre_perfil }}
                                            </span>
                                        </span>
                                    </button>
                                @endforeach
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Dropdown de usuario mejorado -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center space-x-2 group">
                        <div class="h-9 w-9 rounded-full bg-gradient-to-br from-purple-700 to-purple-800 border border-purple-500 flex items-center justify-center text-white font-medium hover:from-purple-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:scale-105 hover:shadow-purple-500/30">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </button>
                    
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" 
                         x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" 
                         x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" 
                         x-transition:leave-end="opacity-0 scale-95" 
                         class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-xl bg-gray-900 border border-purple-500/50 z-50 overflow-hidden backdrop-blur-sm">
                        <div class="py-1 divide-y divide-purple-500/30">
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center space-x-2 text-gray-200 hover:bg-purple-800/60 px-4 py-2.5 font-medium hover:text-white transition-all duration-200">
                                <svg class="h-5 w-5 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ __('Ajustes') }}</span>
                            </x-dropdown-link>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center space-x-2 text-gray-200 hover:bg-purple-800/60 px-4 py-2.5 font-medium hover:text-white transition-all duration-200">
                                    <svg class="h-5 w-5 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span>{{ __('Cerrar sesión') }}</span>
                                </x-dropdown-link>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="sm:hidden">
                <button @click="open = !open" class="text-gray-200 hover:text-white focus:outline-none transition-colors duration-200">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menú Mobile mejorado -->
    <div x-show="open" x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="sm:hidden bg-gray-900 border-t border-purple-500/50">
        <div class="px-4 py-3 space-y-3">
            <!-- Crear otro perfil (Mobile) -->
            @if ($perfilesActivos->count() < 2)
                <x-responsive-nav-link :href="route('perfil.crear.otro')" class="flex items-center space-x-2 text-gray-200 hover:bg-purple-800/60 px-3 py-2.5 rounded-md font-medium hover:text-white transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span>{{ __('Crear otro perfil') }}</span>
                </x-responsive-nav-link>
            @endif

            <!-- Selector de Perfil (Mobile) -->
            <div class="mb-2">
                <label class="block text-xs text-purple-200 uppercase mb-1 font-bold tracking-wider">PERFIL ACTIVO</label>
                <form method="POST" action="{{ route('perfil.cambiar') }}">
                    @csrf
                    <select name="perfil_id" onchange="this.form.submit()"
                        class="w-full bg-purple-900/80 text-white border border-purple-500 rounded-md px-3 py-2 text-sm font-medium focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-200">
                        @foreach(Auth::user()->perfiles as $perfil)
                            <option value="{{ $perfil->id }}" {{ session('perfil_activo') == $perfil->id ? 'selected' : '' }}>
                                {{ ucfirst($perfil->tipo) }} - {{ $perfil->nombre_perfil }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Links Mobile mejorados -->
            <div class="space-y-1">
                <x-responsive-nav-link :href="route('inicio')" :active="request()->routeIs('inicio')" class="flex items-center space-x-2 text-gray-200 hover:bg-purple-800/60 px-3 py-2.5 rounded-md font-medium hover:text-white transition-all duration-200">
                    <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>{{ __('Inicio') }}</span>
                </x-responsive-nav-link>
                
                @if ($perfilActivo)
                    @if ($perfilActivo->tipo === 'creador')
                        <x-responsive-nav-link :href="route('proyectos.index')" :active="request()->routeIs('proyectos.*')" class="flex items-center space-x-2 text-gray-200 hover:bg-purple-800/60 px-3 py-2.5 rounded-md font-medium hover:text-white transition-all duration-200">
                            <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span>{{ __('Mis Proyectos') }}</span>
                        </x-responsive-nav-link>
                    @elseif ($perfilActivo->tipo === 'colaborador')
                        <x-responsive-nav-link :href="route('colaborador.proyectos')" :active="request()->routeIs('colaborador.proyectos')" class="flex items-center space-x-2 text-gray-200 hover:bg-purple-800/60 px-3 py-2.5 rounded-md font-medium hover:text-white transition-all duration-200">
                            <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span>{{ __('Proyectos Asignados') }}</span>
                        </x-responsive-nav-link>
                    @endif
                @endif
                
                <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center space-x-2 text-gray-200 hover:bg-purple-800/60 px-3 py-2.5 rounded-md font-medium hover:text-white transition-all duration-200">
                    <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>{{ __('Ajustes') }}</span>
                </x-responsive-nav-link>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center space-x-2 text-gray-200 hover:bg-purple-800/60 px-3 py-2.5 rounded-md font-medium hover:text-white transition-all duration-200">
                        <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>{{ __('Cerrar sesión') }}</span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>