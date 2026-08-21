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

<div>

    <h2 class="text-2xl font-bold text-white">{{ $ucapan }}! 👋</h2>


    <p class="text-gray-300 mt-1 text-lg font-medium flex items-center" style="font-family: 'Montserrat', sans-serif;">

        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ $waktuKL->format('h:i A | d M Y') }}
    </p>
</div>
