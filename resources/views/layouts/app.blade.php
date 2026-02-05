<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Academic Artworks') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-900 text-gray-100 selection:bg-purple-500 selection:text-white">
        <div class="min-h-screen flex flex-col">
            <!-- Navigation -->
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-gray-800/50 backdrop-blur-md border-b border-gray-700 shadow-lg relative z-20">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-grow">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-gray-950 border-t border-gray-800 py-12 mt-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div class="col-span-1 md:col-span-2">
                            <h3 class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-purple-500 mb-4">
                                Academic Artworks Archive
                            </h3>
                            <p class="text-gray-400 text-sm max-w-sm">
                                Platform pelestarian dan penelitian digital untuk karya seni akademik. Menghubungkan mahasiswa, peneliti, dan institusi melalui budaya visual.
                            </p>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-4">Jelajahi</h4>
                            <ul class="space-y-2 text-sm text-gray-400">
                                <li><a href="{{ route('artworks.index') }}" class="hover:text-cyan-400 transition">Arsip</a></li>
                                <li><a href="#" class="hover:text-cyan-400 transition">Penelitian</a></li>
                                <li><a href="#" class="hover:text-cyan-400 transition">Institusi</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-4">Terhubung</h4>
                            <ul class="space-y-2 text-sm text-gray-400">
                                <li><a href="#" class="hover:text-purple-400 transition">Tentang Kami</a></li>
                                <li><a href="#" class="hover:text-purple-400 transition">Kontak</a></li>
                                <li><a href="#" class="hover:text-purple-400 transition">Kirim Karya</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="border-t border-gray-800 mt-12 pt-8 text-center text-xs text-gray-500">
                        &copy; {{ date('Y') }} {{ config('app.name') }}. Hak cipta dilindungi.
                    </div>
                </div>
            </footer>
        </div>
        
        @include('partials.chatbot-widget')
    </body>
</html>
