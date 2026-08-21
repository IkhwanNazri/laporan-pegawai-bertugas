<!-- Banner Atas -->
<div class="relative overflow-hidden p-8 rounded-xl shadow-sm border border-purple-100 flex flex-col md:flex-row items-center justify-between gap-4">
-->
    <img src="{{ asset('asset/banner-01.jpg') }}" class="absolute inset-0 w-full h-full object-cover object-center z-0" alt="Banner Background">


    <div class="absolute inset-0  z-0"></div>


    <div class="relative z-10 flex flex-col items-start gap-4 w-full">

        <div class="text-white">
            <x-timezone />
        </div>

         @if(Auth::user()->role === 'pegawai_bertugas')
        <a href="{{ route('user.jadual.index') }}"
        :active="request()->routeIs('user.jadual.*')"
        label="Lihat Jadual"
        shortLabel="Jadual"
        class="flex  text-center  items-center gap-2 bg-yellow-500 rounded-md px-10 text-purple-800  py-2 font-bold text-lg hover:bg-purple-50 transition-all shadow-lg shadow-black/30 animate-slide-right">
            Lihat Senarai Jadual
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 1 1-1.06-1.06l6.22-6.22H3a.75.75 0 0 1 0-1.5h16.19l-6.22-6.22a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
            </svg>
        </a>
        @endif
    </div>
</div>
