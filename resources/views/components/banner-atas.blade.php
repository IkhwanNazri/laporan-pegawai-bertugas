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





        <img src="{{ asset('asset/kpnlogo.png') }}"
             class="absolute right-6 w-24 h-24 md:w-28 md:h-28 object-contain bg-white/50 rounded-full p-2 shadow-md"
             alt="Kementerian Perpaduan Negara">

    </div>
</div>
