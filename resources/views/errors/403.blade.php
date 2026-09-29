
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>403 - Akses Ditolak | {{ config('app.name', 'Sistem Pegawai Bertugas KPN') }}</title>

        <!-- Fonts (sepadan dengan layouts/app.blade.php) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-['Montserrat'] antialiased text-gray-900">

        <div class="min-h-screen flex items-center justify-center p-6 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px]">

            <div class="w-full max-w-lg">

                <!-- Kad Utama -->
                <div class=" rounded-3xl shadow-xl  overflow-hidden">

                    <!-- Jalur Atas -->
                    <div class="h-2 bg-gradient-to-r from-purple-900 via-purple-600 to-purple-400"></div>

                    <div class="p-10 sm:p-12 text-center">

                        <!-- Logo -->
                        <div class="flex justify-center mb-6">
                            <img src="{{ asset('asset/logo.png') }}" alt="Logo Sistem"
                                 class="h-16 object-contain"
                                 onerror="this.style.display='none'">
                        </div>

                        <!-- Ikon Kunci -->
                        <div class="relative inline-flex mb-6">
                            <div class="absolute inset-0 rounded-full bg-red-100/70 animate-ping"></div>
                            <div class="relative p-5 rounded-full bg-gradient-to-br from-red-500 to-red-700 text-white shadow-lg">
                                <x-heroicon-s-lock-closed class="w-10 h-10" />
                            </div>
                        </div>

                        <!-- Kod Status -->
                        <p class="text-7xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-900 to-purple-500 leading-none tracking-tight">403</p>

                        <h1 class="mt-3 text-2xl font-bold text-gray-800 uppercase tracking-wide">Akses Ditolak</h1>
<!-- Mesej daripada abort(403, ...) dalam RoleMiddleware -->
                        <p class="mt-3 text-sm text-gray-500 leading-relaxed">
                            {{ $exception->getMessage() ?: 'Maaf, anda tidak mempunyai kebenaran untuk mengakses halaman ini.' }}
                        </p>

                        @auth
                            @php
                                $labelPeranan = [
                                    'pegawai_bertugas'                        => 'Pegawai Bertugas',
                                    'pegawai_keselamatan_aras'                => 'Pegawai Keselamatan Aras (PKA)',
                                    'penolong_pegawai_keselamatan_jabatan'   => 'Penolong Pegawai Keselamatan Jabatan (PPKJ)',
                                    'superadmin'                              => 'Superadmin',
                                ][Auth::user()->role] ?? Auth::user()->role;
                            @endphp
                            <div class="mt-5 inline-flex items-center gap-2 px-4 py-2 bg-gray-100 border border-gray-200 rounded-full text-xs text-gray-600 font-medium">
                                <x-heroicon-s-user class="w-4 h-4 text-purple-700" />
                                Anda log masuk sebagai: <span class="font-bold text-gray-800">{{ $labelPeranan }}</span>
                            </div>
                        @endauth

                        <!-- Butang Tindakan -->
                        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">

                            <a href="{{ route('dashboard') }}"
                               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-purple-900 text-white text-sm font-semibold rounded-full hover:bg-purple-800 transition-all shadow-md">
                                <x-heroicon-s-home class="w-4 h-4" />
                                Kembali ke Dashboard
                            </a>

                            @auth
                                <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto m-0">
                                    @csrf
                                    <button type="submit"
                                            class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-red-600 text-sm font-semibold border-2 border-red-200 rounded-full hover:bg-red-50 transition-all shadow-sm">
                                        <x-heroicon-s-arrow-left-end-on-rectangle class="w-4 h-4" />
                                        Log Keluar
                                    </button>
                                </form>
                            @endauth

                        </div>

                    </div>
                </div>

                <!-- Footer -->
                <p class="mt-6 text-center text-xs text-gray-400 font-medium">
                    Hak Cipta Terpelihara 2026 Kementerian Perpaduan Negara.
 Sistem Pegawai Bertugas.

                </p>
            </div>
        </div>

    </body>
</html>
