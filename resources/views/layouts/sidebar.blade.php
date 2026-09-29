<!-- resources/views/layouts/sidebar.blade.php -->
<div x-data="{ open: true }"
     :class="open ? 'w-128 rounded-none' : 'w-30 rounded-[2.5rem] mx-2 my-2 items-center '"
     class="hidden md:flex flex-col h-full py-8 bg-white/80 shadow-lg backdrop-filter backdrop-blur-md border border-white/50 transition-all duration-300 ease-in-out">

    <div :class="open ? 'flex flex-row items-center justify-between w-full' : 'flex flex-col items-center w-full'">
        <div class="relative flex w-full" :class="open ? 'justify-center' : 'flex-col items-center'">
            <div class="flex flex-col items-center justify-center px-2">
                <a href="/">
                    <img src="{{ asset('asset/logo.PNG') }}" alt="Logo Sistem" :class="open ? 'h-16 mb-2' : 'h-12 mb-4'" class="object-contain mx-auto transition-all duration-300">
                    <p x-show="open" x-transition.opacity.duration.300ms class="text-purple-900 font-semibold whitespace-nowrap text-center text-md" style="font-family: 'Poppins', sans-serif;">
                        Kementerian Perpaduan Negara
                    </p>
                </a>
            </div>

            <button @click="open = !open" :class="open ? 'absolute bottom-20 right-0' : ''" class="p-2 group hover:opacity-75 transition-opacity" title="Toggle Sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-purple-800 transition-all duration-300" :class="open ? 'w-6 h-6' : 'w-10 h-10'">
                    <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>


    <div class="flex flex-col justify-between flex-1 mt-6 overflow-y-auto overflow-x-hidden w-full px-2" :class="open ? 'px-4' : 'px-2'">
        <nav class="space-y-3 flex flex-col" :class="!open && 'items-center'">

            <!-- Menu Home (Untuk Semua) -->
            <x-role-sidebar href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" label="Home" shortLabel="Home">
               <x-heroicon-s-home class="w-6 h-6" />
            </x-role-sidebar>

            <hr class="border-t-2 border-gray-300">

            <!-- Menu Superadmin -->
            @if(Auth::user()->role === 'superadmin')
                <p x-show="open" class="px-2 pt-4 text-xs font-semibold text-gray-400 uppercase">Pentadbiran</p>


                <x-role-sidebar href="{{ route('admin.pengguna.index') }}" :active="request()->routeIs('pengguna.*')" label=" Pengguna" shortLabel="Pengguna">
                   <x-heroicon-s-user-group class="w-6 h-6" />

                </x-role-sidebar>


                <x-role-sidebar href="{{ route('admin.bahagian.index') }}" :active="request()->routeIs('bahagian.*')" label=" Bahagian" shortLabel="Bahagian">
                    <x-heroicon-s-building-office-2 class="w-6 h-6" />

                </x-role-sidebar>

                <x-role-sidebar href="{{ route('ppkj.pengesahan.index') }}" :active="request()->routeIs('ppkj.pengesahan.*')" label="Semakan PPKJ" shortLabel="PPKJ">
                    <x-heroicon-s-check-circle class="w-6 h-6" />
                </x-role-sidebar>

            @endif

            <!-- Menu pka -->
           @if(Auth::user()->role === 'pegawai_keselamatan_aras')
                <!-- Menu Urus Jadual (Kekal) -->
                <x-role-sidebar-dropdown :active="request()->routeIs('jadual.*')" label="Jadual" shortLabel="Jadual">
                    <x-slot name="icon">
                        <x-heroicon-s-calendar-days class="w-6 h-6" />


                    </x-slot>


                    <a href="{{ route('pka.jadual.index') }}"
                    class="block py-2 text-sm rounded-full transition-all duration-300 {{ request()->routeIs('pka.jadual.*') ? 'bg-purple-100 text-purple-900 font-semibold pl-4 shadow-lg' : 'text-purple-900 hover:bg-purple-200 hover:pl-5 hover:text-purple-900' }}"
                    :class="open ? 'px-4' : 'text-center text-xs px-2'">
                    <span x-show="open">Jadual</span>
                    <span x-show="!open" title="Harian">Jadual</span>
                    </a>
                    <a href="{{ route('pka.jadual.harian') }}"
                    class="block py-2 text-sm rounded-full transition-all duration-300 {{ request()->routeIs('jadual.harian') ? 'bg-purple-100 text-purple-900 font-semibold pl-4 shadow-lg' : 'text-purple-900 hover:bg-purple-200 hover:pl-5 hover:text-purple-900' }}"
                    :class="open ? 'px-4' : 'text-center text-xs px-2'">
                    <span x-show="open">- Harian</span>
                    <span x-show="!open" title="Harian">Hari</span>
                    </a>


                    <a href="{{ route('pka.jadual.mingguan') }}"
                    class="block py-2 text-sm rounded-full transition-all duration-300 {{ request()->routeIs('jadual.mingguan') ? 'bg-purple-100 text-purple-900 font-semibold pl-4 shadow-lg' : 'text-purple-900 hover:bg-purple-200 hover:pl-5 hover:text-purple-900' }}"
                    :class="open ? 'px-4' : 'text-center text-xs px-2'">
                    <span x-show="open">- Mingguan</span>
                    <span x-show="!open" title="Mingguan">Minggu</span>
                    </a>
                </x-role-sidebar-dropdown>
                  {{-- Laporan --}}
                <x-role-sidebar href="{{ route('pka.laporan.index') }}" :active="request()->routeIs('laporan.*')" label="Laporan" shortLabel="Laporan">
                <x-heroicon-s-clipboard-document-check class="w-6 h-6" />
                </x-role-sidebar>
                <x-role-sidebar href="{{ route('emails.preview') }}" :active="request()->routeIs('emails.preview')" label="Email" shortLabel="Email">
                <x-heroicon-s-envelope class="w-6 h-6" />
                </x-role-sidebar>



                {{-- <!-- Menu Pengesahan (Kekal) -->
                <x-role-sidebar href="{{ route('pengesahan.index') }}" :active="request()->routeIs('pengesahan.*')" label="Pengesahan" shortLabel="Sah">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" class="w-full h-full">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </x-role-sidebar> --}}


            @endif

            <!-- Menu Pegawai Bertugas -->
            @if(Auth::user()->role === 'pegawai_bertugas')
                <x-role-sidebar href="{{ route('user.jadual.index') }}" :active="request()->routeIs('jadual.user')" label="Jadual" shortLabel="Jadual">
                <x-heroicon-s-calendar-days class="w-6 h-6" />

                </x-role-sidebar>
                <x-role-sidebar href="{{ route('user.laporan.index') }}" :active="request()->routeIs('laporan.*')" label=" Laporan" shortLabel="Laporan">
                   <x-heroicon-s-clipboard-document-check class="w-6 h-6" />

                </x-role-sidebar>

            @endif
                {{-- menu ppkj --}}
            @if(Auth::user()->role === 'penolong_pegawai_keselamatan_jabatan')
                <x-role-sidebar href="{{ route('ppkj.pengesahan.index') }}" :active="request()->routeIs('ppkj.pengesahan.*')" label="Semakan PPKJ" shortLabel="PPKJ">
                   <x-heroicon-s-check-circle class="w-6 h-6" />
                </x-role-sidebar>
            @endif
        </nav>
    </div>
</div>
