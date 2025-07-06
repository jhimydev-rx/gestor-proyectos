<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GOXU') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind + Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .gradient-text {
            background: linear-gradient(to right, #9D4EDD, #6A0DAD, #845EF7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-[#0F051D] via-[#1A0033] to-[#210045] text-white">
    <div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-0">
        <!-- Título GOXU estilizado -->
        <div class="mb-6">
            <h1 class="text-5xl font-bold gradient-text font-[Orbitron] tracking-widest drop-shadow-lg">
                GOXU
            </h1>
        </div>

        <!-- Contenedor del contenido -->
        <div class="w-full sm:max-w-md bg-[#1A0033] border border-[#6A0DAD] p-8 rounded-xl shadow-2xl">
            {{ $slot }}
        </div>
    </div>
</body>
</html>