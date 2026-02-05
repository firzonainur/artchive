<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-100 antialiased bg-gray-950 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-gray-900 via-gray-950 to-black min-h-screen relative selection:bg-purple-500 selection:text-white">
        <!-- Background Decoration -->
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute top-[-10%] right-[-5%] w-96 h-96 bg-purple-600/20 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-[-10%] left-[-5%] w-96 h-96 bg-cyan-600/10 rounded-full blur-[100px]"></div>
        </div>

        <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 p-6">
            <div class="mb-8 text-center">
                <a href="/" class="group">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-20 h-20 mx-auto rounded-2xl shadow-2xl shadow-purple-500/20 group-hover:scale-105 transition-transform duration-300 object-contain">
                    <h1 class="mt-4 text-2xl font-bold text-white tracking-tight">Academic<span class="text-purple-400">Archive</span></h1>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-gray-900/60 backdrop-blur-xl border border-white/10 shadow-2xl rounded-2xl ring-1 ring-white/5 relative overflow-hidden">
                <!-- Subtle top highlight -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-purple-500/50 to-transparent"></div>
                
                {{ $slot }}
            </div>
            
            <p class="mt-8 text-gray-500 text-sm">
                &copy; {{ date('Y') }} {{ config('app.name') }}. Hak cipta dilindungi.
            </p>
        </div>
    </body>
</html>
