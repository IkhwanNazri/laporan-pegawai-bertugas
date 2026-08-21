<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sistem Pegawai Bertugas KPN') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">



        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body x-data="{ sidebarOpen: true, loading: true }"
      x-init="setTimeout(() => loading = false, 150)"
      class="font-['Montserrat'] antialiased text-gray-900 bg-gray-100">


    <div x-show="loading"
         x-transition.opacity.duration.300ms
         class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-white backdrop-blur-sm">
        <div class="w-12 h-12 border-4 border-purple-200 border-t-purple-900 rounded-full animate-spin"></div>
        <p class="mt-4 text-sm font-semibold text-purple-900 animate-pulse">Memuatkan halaman...</p>
    </div>


    <div class="flex h-screen overflow-hidden bg-gray-100"
         x-show="!loading"
         x-transition.opacity.duration.300ms>


        @include('layouts.sidebar')

 <!-- Main Content Area -->
<div class="flex flex-col flex-1 overflow-hidden relative">

    <!-- ======================================================== -->
    <!-- NOTIFIKASI FLOATING TOP-CENTER (TIDAK MENGHALANG BUTTON) -->
    <!-- ======================================================== -->
    @if(Auth::user()->role === 'pegawai_keselamatan_aras' && Auth::user()->unreadNotifications->count() > 0)
        @php
            $latestNoti = Auth::user()->unreadNotifications->first();
            $kategori = $latestNoti->data['kategori'] ?? 'baharu';

            $tema = [
                'baharu'    => ['bar' => 'bg-blue-500',    'icon' => 'bg-blue-100 text-blue-600'],
                'kemaskini' => ['bar' => 'bg-amber-500',   'icon' => 'bg-amber-100 text-amber-600'],
                'selesai'   => ['bar' => 'bg-emerald-500', 'icon' => 'bg-emerald-100 text-emerald-600'],
                'peringatan'=> ['bar' => 'bg-red-500',     'icon' => 'bg-red-100 text-red-600'],
            ][$kategori] ?? ['bar' => 'bg-purple-600', 'icon' => 'bg-purple-100 text-purple-700'];
        @endphp

        <div x-data="{
                show: true,
                progress: 100,
                timer: null,
                startTimer() {
                    let duration = 6000; // 6 Saat
                    let interval = 50;
                    let step = (interval / duration) * 100;

                    this.timer = setInterval(() => {
                        this.progress -= step;
                        if (this.progress <= 0) {
                            clearInterval(this.timer);
                            this.show = false;
                        }
                    }, interval);
                }
             }"
             x-init="startTimer()"
             x-show="show"
             x-transition:enter="transform transition ease-out duration-300"
             x-transition:enter-start="-translate-y-12 opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transform transition ease-in duration-200"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="-translate-y-12 opacity-0"
             class="fixed top-4 left-1/2 -translate-x-1/2 z-50 w-full max-w-md px-4 pointer-events-none"
             style="display: none;">

            <div class="pointer-events-auto bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-gray-100 overflow-hidden ring-1 ring-black/5">
                <div class="p-3.5 flex items-center justify-between gap-3">

                    <!-- Ikon -->
                    <div class="p-2 {{ $tema['icon'] }} rounded-xl shrink-0">
                        <x-heroicon-o-bell class="w-5 h-5 animate-bounce" />
                    </div>

                    <!-- Mesej Ringkas & Kemas -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-gray-900 truncate">
                                {{ $latestNoti->data['tajuk'] ?? 'Notifikasi' }}
                            </span>
                            <span class="text-[10px] text-gray-400 whitespace-nowrap">
                                {{ $latestNoti->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-600 truncate mt-0.5">
                            {{ $latestNoti->data['mesej'] ?? '' }}
                        </p>
                    </div>

                    <!-- Butang Aksi -->
                    <div class="flex items-center gap-2 shrink-0">
                        @if(isset($latestNoti->data['url']))
                            <a href="{{ $latestNoti->data['url'] }}" class="text-xs font-bold text-purple-700 bg-purple-50 hover:bg-purple-100 px-3 py-1.5 rounded-lg transition">
                                Semak
                            </a>
                        @endif

                        <button @click="show = false; clearInterval(timer)" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Pembaris Masa (Loading Progress Bar) -->
                <div class="w-full bg-gray-100 h-1">
                    <div class="{{ $tema['bar'] }} h-1 transition-all linear duration-75" :style="`width: ${progress}%`"></div>
                </div>
            </div>
        </div>
    @endif

    <!-- ======================================================== -->
    <!-- BAR HEADER UTAMA (BERSIH & KEMAS DI ATAS KANAN)            -->
    <!-- ======================================================== -->
    <header class="hidden md:flex w-full pt-6 px-8 justify-end items-center gap-3 z-20">

        <!-- Profile Badge Nama User -->
        <div class="py-2 px-4 bg-white shadow-sm border border-gray-100 rounded-xl text-sm text-gray-700 flex items-center font-medium">
            <span class="text-gray-900 font-bold">{{ Auth::user()->name }}</span>
            <span class="mx-2.5 text-gray-300">|</span>
            <span class="capitalize text-xs font-semibold px-2 py-0.5 bg-purple-50 text-purple-700 rounded-md border border-purple-100">
                {{ str_replace('_', ' ', Auth::user()->role) }}
            </span>
        </div>

        <!-- Loceng Notifikasi (Dropdown) -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" title="Notifikasi" class="relative p-2.5 text-gray-600 bg-white shadow-sm border border-gray-100 transition-all rounded-xl hover:bg-purple-50 hover:text-purple-700 focus:outline-none">
                <x-heroicon-o-bell class="w-5 h-5" />

                @if(Auth::user()->role === 'pegawai_keselamatan_aras' && Auth::user()->unreadNotifications->count() > 0)
                    <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-extrabold text-white shadow-md ring-2 ring-white animate-pulse">
                        {{ Auth::user()->unreadNotifications->count() }}
                    </span>
                @endif
            </button>

            <!-- Menu Dropdown -->
            <div x-show="open"
                 @click.outside="open = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-[-10px]"
                 style="display: none;"
                 class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 overflow-hidden">

                <div class="p-4 bg-purple-900 text-white flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-bell class="w-4 h-4 text-purple-300" />
                        <h4 class="text-xs font-bold uppercase tracking-wider">Notifikasi Sistem</h4>
                    </div>
                    @if(Auth::user()->role === 'pegawai_keselamatan_aras' && Auth::user()->unreadNotifications->count() > 0)
                        <form action="{{ route('pka.notifications.read') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="text-[10px] bg-white/10 hover:bg-white/20 text-purple-100 px-2.5 py-1 rounded-full transition font-semibold">
                              <x-heroicon-o-envelope-open class="w-6 h-6"></x-heroicon-o-envelope-open>
                            </button>
                        </form>
                    @endif
                </div>

                <div class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                    @if(Auth::user()->role === 'pegawai_keselamatan_aras')
                        @forelse(Auth::user()->notifications->take(10) as $notification)
                            <a href="{{ $notification->data['url'] ?? '#' }}" class="block p-3.5 hover:bg-purple-50/50 transition-colors {{ $notification->unread() ? 'bg-purple-50/30 font-semibold' : 'opacity-70' }}">
                                <div class="flex items-start justify-between gap-2">
                                    <p class="text-xs text-gray-900">{{ $notification->data['tajuk'] ?? 'Pemberitahuan' }}</p>
                                    <span class="text-[9px] text-gray-400 font-medium whitespace-nowrap">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1 leading-snug">{{ $notification->data['mesej'] ?? '' }}</p>
                            </a>
                        @empty
                            <div class="text-center py-8">
                                <x-heroicon-o-bell-slash class="w-8 h-8 text-gray-300 mx-auto mb-2" />
                                <p class="text-xs text-gray-400 font-medium">Tiada notifikasi baharu.</p>
                            </div>
                        @endforelse
                    @else
                        <p class="text-center text-xs text-gray-400 py-6">Tiada notifikasi untuk anda.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Butang Profil -->
        <a href="{{ route('profile.edit') }}" title="Profil" class="p-2.5 text-gray-600 bg-white shadow-sm border border-gray-100 transition-all rounded-xl hover:bg-purple-50 hover:text-purple-700">
           <x-heroicon-o-user class="w-5 h-5" />
        </a>

        <!-- Butang Log Keluar -->
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" title="Log Keluar" class="p-2.5 text-red-500 bg-white shadow-sm border border-gray-100 transition-all rounded-xl hover:bg-red-50 hover:text-red-700">
                <x-heroicon-o-arrow-left-end-on-rectangle class="w-5 h-5" />
            </button>
        </form>
    </header>

    <main class="flex-1 overflow-x-hidden overflow-y-auto">
        {{ $slot }}
    </main>
</div>
</body>
</html>





