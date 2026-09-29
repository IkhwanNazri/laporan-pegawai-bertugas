<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('asset/logo.PNG') }}">

        <title>Laporan Pegawai Bertugas</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">

        <div class="relative min-h-screen flex flex-col sm:justify-center items-center bg-gray-100">


            <img src="{{ asset('asset/background.jpg') }}" alt="Background" class="absolute inset-0 w-full h-full object-cover z-0">


            <div class="relative z-10"> <!-- Tambah z-10 supaya duduk atas bg -->
                <a href="/">
                    {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
                </a>
            </div>


            <div class="relative z-10 w-full sm:max-w-xl mt-6  bg-white/30 backdrop-filter backdrop-blur-sm border border-white/50 shadow-xl overflow-hidden sm:rounded-2xl ">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
