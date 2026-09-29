 {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">


                    <div class="relative p-6 rounded-3xl overflow-hidden shadow-md flex flex-col justify-between h-52 border border-purple-200">
                        <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?q=80&w=800&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover object-right opacity-50" alt="bg">
                        <div class="absolute inset-0 bg-gradient-to-r from-gray-50 via-purple-50 to-white/20"></div>

                        <div class="flex items-center justify-between relative z-10">
                            <div class="w-16 h-16 bg-purple-800 rounded-full flex items-center justify-center shadow-sm">

                                <img src="{{ asset('asset/document.png') }}" alt="" class="p-3 ">
                            </div>


                            <h2 class="text-xl font-extrabold tracking-wider text-white px-4 py-1.5 drop-shadow-sm bg-purple-900 animate-slide-right  ">
                                LAPORAN
                            </h2>
                        </div>

                        <div class="relative z-10">
                            <p class="text-lg font-bold text-purple-600 mb-1">Keseluruhan</p>


                            <div class="flex items-center w-full">

                                <span class="text-5xl font-black text-purple-900 tracking-tighter">
                                    {{ \App\Models\LaporanBertugas::count() }}
                                </span>


                                <div class="flex-1 ml-3 bg-purple-900 -mr-6 py-2 pl-4 rounded-l-lg animate-slide-right">
                                    <span class="text-xl font-extrabold tracking-wider text-white drop-shadow-sm">
                                        Laporan
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="relative p-6 rounded-3xl overflow-hidden shadow-md flex flex-col justify-between h-52 border border-purple-200">
                        <img src="https://images.unsplash.com/photo-1506784983877-45594efa4cbe?q=80&w=800&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover object-right" alt="bg">
                        <div class="absolute inset-0 bg-gradient-to-r from-white via-white/90 to-white/20"></div>

                        <div class="flex items-center justify-between relative z-10">
                            <div class="w-16 h-16 bg-purple-800 rounded-full flex items-center justify-center shadow-sm">
                                <!-- Icon Task / Check -->
                                     <img src="{{ asset('asset/schedule.png') }}" alt="" class="p-3 ">
                            </div>
                            <h2 class="text-xl font-extrabold justify-end tracking-wider text-white  px-4 drop-shadow-sm bg-purple-900 animate-slide-right">JADUAL</h2>
                        </div>

                        <div class="relative z-10">
                            <p class="text-lg font-bold text-purple-600 mb-1">Keseluruhan</p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-5xl font-black text-purple-900 tracking-tighter">{{ \App\Models\Jadual::count() }}</span>
                                <span class="text-xl font-bold text-purple-800">Dalam Tugas</span>
                            </div>
                        </div>
                    </div>


                    <div class="relative p-6 rounded-3xl overflow-hidden shadow-md flex flex-col justify-between h-52 border border-purple-200">
                        <img src="https://images.unsplash.com/photo-1506784365847-bbad939e9335?q=80&w=800&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover object-right" alt="bg">
                        <div class="absolute inset-0 bg-gradient-to-r from-white via-white/90 to-white/20"></div>

                        <div class="flex items-center justify-between relative z-10">
                            <div class="w-16 h-16 bg-purple-800 rounded-full flex items-center justify-center shadow-sm">

                                 <img src="{{ asset('asset/clock.png') }}" alt="" class="p-3 ">
                            </div>
                            <h2 class="text-xl font-extrabold justify-end tracking-wider text-white  px-4 drop-shadow-sm bg-purple-900 animate-slide-right">HARI INI</h2>
                        </div>

                        <div class="relative z-10">
                            <p class="text-lg font-bold text-purple-600 mb-1">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-5xl font-black text-purple-900 tracking-tighter">{{ \App\Models\Jadual::whereDate('tarikh', \Carbon\Carbon::today())->count() }}</span>
                                <span class="text-xl font-bold text-purple-800">Bertugas</span>
                            </div>
                        </div>
                    </div>

                </div> --}}




                @php
    use App\Models\Jadual;
    use App\Models\LaporanBertugas;

    // Jadual yang masih belum selesai
    $jadualDalamProses = Jadual::with(['pegawai'])
        ->whereDoesntHave('laporan', function ($query) {
            $query->where('status_pengesahan', 'selesai');
        })
        ->latest('tarikh')
        ->take(2)
        ->get();

    // Laporan yang masih dalam proses
    $laporanDalamProses = LaporanBertugas::with(['jadual.pegawai'])
        ->where('status_pengesahan', 'dalam_proses')
        ->latest()
        ->take(2)
        ->get();
@endphp


<div class="grid grid-cols-1 md:grid-cols-2 gap-5 font-['Poppins']">

    {{-- DALAM PROSES --}}
    <div class="bg-white rounded-2xl shadow-xl p-4 hover:shadow-md transition">

        <div class="flex items-center gap-2 mb-4">
            <h2 class="font-semibold text-lg text-gray-800 font-['Poppins']">
                Dalam Proses
            </h2>
            <span class="text-purple-600"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                </svg>
                </span>
        </div>


        <div class="space-y-4">

            @forelse($jadualDalamProses as $jadual)

                <div class="bg-purple-50 p-3 border-r-4 border-purple-800">

                    <div class="flex items-center gap-3">

                        <div class="w-7 h-7 rounded-full bg-purple-800 flex items-center justify-center">
                            <x-heroicon-o-clock class="w-4 h-4 text-white" />
                        </div>

                        <div>

                            <p class="text-xs font-bold text-purple-900">
                                Dalam Proses -
                                {{ $jadual->pegawai->name ?? 'Tiada Pegawai' }}
                            </p>

                            <p class="text-xs text-purple-800 mt-1">
                                Jadual {{ ucfirst($jadual->jenis) }}
                                -
                                {{ \Carbon\Carbon::parse($jadual->tarikh)->format('d/m/Y') }}
                            </p>

                        </div>

                    </div>

                </div>

            @empty

                <div class="bg-purple-50 p-4 text-center rounded-lg">

                    <x-heroicon-o-check-circle
                        class="w-6 h-6 mx-auto text-green-600 mb-1"
                    />

                    <p class="text-xs font-semibold text-gray-500">
                        Tiada jadual dalam proses
                    </p>

                </div>

            @endforelse

        </div>


        <a href="{{ route('pka.jadual.index') }}"
           class="inline-block mt-3 px-7 py-1 rounded-full bg-purple-700 text-white text-xs">
            View All
        </a>

    </div>


    {{-- LAPORAN --}}
    <div class="bg-white rounded-2xl shadow-xl p-4 hover:shadow-md transition" >

        <div class="flex items-center gap-2 mb-4">
            <h2 class="font-semibold text-lg text-gray-800 font-['Poppins'] ">
                Laporan
            </h2>
            <span class="text-purple-800"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
</svg>
</span>
        </div>


        <div class="space-y-4">

            @forelse($laporanDalamProses as $laporan)

                <div class="bg-purple-50 p-3 border-r-4 border-purple-800">

                    <div class="flex items-center gap-3">

                        <div class="w-7 h-7 rounded-full bg-purple-800 flex items-center justify-center">
                            <x-heroicon-o-clock class="w-4 h-4 text-white" />
                        </div>

                        <div>

                            <p class="text-xs font-bold text-purple-900">

                                Dalam Proses -

                                {{ $laporan->jadual->pegawai->name ?? 'Tiada Pegawai' }}

                            </p>

                            <p class="text-xs text-purple-800 mt-1">

                                Menunggu pengesahan PKA

                            </p>

                        </div>

                    </div>

                </div>

            @empty

                <div class="bg-purple-50 p-4 text-center rounded-lg">

                    <x-heroicon-o-check-circle
                        class="w-6 h-6 mx-auto text-green-600 mb-1"
                    />

                    <p class="text-xs font-semibold text-gray-500">
                        Tiada laporan dalam proses
                    </p>

                </div>

            @endforelse

        </div>


        <a href="{{ route('pka.laporan.index') }}"
           class="inline-block mt-5 px-7 py-1 rounded-full bg-purple-700 text-white text-xs">
            View All
        </a>

    </div>

</div>
