<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('asset/logo.PNG') }}">

    <title inertia>Laporan Pegawai Bertugas</title>


    {{-- Fonts --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet"
    >

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet"
    >


    {{-- SweetAlert --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    {{-- Vite --}}

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @inertiaHead

</head>


<body class="font-['Montserrat'] antialiased text-gray-900 bg-gray-100">

    @inertia

</body>

</html>
