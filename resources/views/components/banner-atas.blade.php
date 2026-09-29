@php
    $waktuKL = now()->timezone('Asia/Kuala_Lumpur');
    $jam = $waktuKL->format('H');
    if ($jam >= 5 && $jam < 12) {
        $ucapan = 'Selamat Pagi';
    } elseif ($jam >= 12 && $jam < 15) {
        $ucapan = 'Selamat Tengah Hari';
    } elseif ($jam >= 15 && $jam < 19) {
        $ucapan = 'Selamat Petang';
    } else {
        $ucapan = 'Selamat Malam';
    }
@endphp


<div class="relative overflow-hidden h-[200px] rounded-2xl shadow-sm border border-purple-100">
    <img src="{{ asset('asset/banneratas-01.jpg') }}"
         class="absolute inset-0 w-full h-full object-cover object-center"
         alt="Banner Background">

    <div class="absolute inset-0 bg-black/10"></div>

    <div class="relative z-10 h-full px-8 md:px-12 py-7 flex flex-col justify-between mt-5">


        <div>

              <h1 class="text-4xl md:text-5xl font-bold font-['Poppins'] text-purple-900 tracking-wide">{{ $ucapan }}! 👋</h1>
            {{-- Waktu --}}
            <div class="inline-flex items-center mt-3 px-4 py-2 rounded-xl
                        bg-white/20 backdrop-blur-md border border-white/30
                        text-white shadow-lg">
                <span class="font-semibold text-base md:text-lg">
                    <x-timezone />
                </span>
            </div>
        </div>


        {{-- <div class="flex items-end justify-between gap-4">


            <div class="flex items-center gap-3 bg-white rounded-lg">
                <a href="#" class=" items-center gap-2 px-4 py-2.5 ">
                    <div class=" items-center justify-center">
                        <x-heroicon-o-calendar-days class="w-10 h-10 text-blue-600"/>
                    </div>
                    <span class="text-sm font-bold text-gray-800">Jadual</span>
                </a>

                <a href="#" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/90 shadow-md hover:bg-white transition-all">
                    <div class="w-9 h-9 rounded-lg bg-blue-600 flex items-center justify-center">
                        <x-heroicon-o-document-text class="w-5 h-5 text-white"/>
                    </div>
                    <span class="text-sm font-bold text-gray-800">Laporan</span>
                </a>

                <a href="#" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/90 shadow-md hover:bg-white transition-all">
                    <div class="w-9 h-9 rounded-lg bg-violet-600 flex items-center justify-center">
                        <x-heroicon-o-chart-bar class="w-5 h-5 text-white"/>
                    </div>
                    <span class="text-sm font-bold text-gray-800">Statistik</span>
                </a>
            </div>


            @if(Auth::user()->role === 'pegawai_bertugas')
                <a href="{{ route('user.jadual.index') }}"
                   :active="request()->routeIs('user.jadual.*')"
                   class="shrink-0 flex items-center gap-2 bg-yellow-400 hover:bg-yellow-300
                          rounded-xl px-6 py-3 text-purple-900 font-bold text-sm shadow-lg transition-all">
                    Lihat Senarai Jadual
                    <x-heroicon-o-arrow-right class="w-5 h-5"/>
                </a>
            @endif
        </div> --}}


        <img src="{{ asset('asset/kpnlogo.png') }}"
             class="absolute right-6 w-24 h-24 md:w-28 md:h-28 object-contain bg-white/50 rounded-full p-2 shadow-md"
             alt="Kementerian Perpaduan Negara">

    </div>
</div>
