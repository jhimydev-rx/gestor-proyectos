<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GOXU') }}</title> <!-- Cambiado a GOXU -->

        <!-- Fonts (recomendación: fuente moderna para GOXU) -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=orbitron:400,500,600|rajdhani:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Estilos inline para prueba rápida (puedes moverlos a app.css) -->
        <style>
            :root {
                --goxu-gold: #FFD700;
                --goxu-dark: #0A0A0A;
            }
            body {
                background-color: var(--goxu-dark);
                color: white;
                font-family: 'Rajdhani', sans-serif;
            }
            .bg-goxu-gradient {
                background: linear-gradient(135deg, var(--goxu-dark) 0%, #1A1A1A 100%);
            }
            .border-goxu {
                border: 1px solid var(--goxu-gold);
                box-shadow: 0 0 10px rgba(255, 215, 0, 0.3);
            }
            .text-goxu {
                color: var(--goxu-gold);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-goxu-gradient">
        <div class="min-h-screen">
            <!-- Navigation (personalizada para GOXU) -->
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-black bg-opacity-70 shadow-lg border-b border-goxu">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h1 class="text-2xl font-bold text-goxu">{{ $header }}</h1>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                @yield('content')
            </main>
        </div>
    </body>
</html>