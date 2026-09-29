@php
    use App\Models\Jadual;
    use App\Models\LaporanBertugas;

    $jadualRingkas = Jadual::with(['pegawai'])
        ->orderBy('tarikh', 'asc')
        ->take(2)
        ->get();

    $semuaJadual = Jadual::with(['pegawai'])
        ->orderBy('tarikh', 'asc')
        ->get();
@endphp

<div
    x-data="{ showModal: false }"
>

    {{-- CARD --}}
    <div
        @click="showModal = true"
        class="bg-white rounded-2xl shadow-lg p-4 cursor-pointer hover:shadow-md transition"
    >

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-4 font-['Poppins'] text-xl">

            <h2 class="font-bold text-xl">
                Pegawai Bertugas
            </h2>


            </span>

            <span class="text-xs">
                {{ now()->format('d/m/Y') }}
            </span>



        </div>


        {{-- 2 JADUAL TERKINI --}}
        <div class="space-y-3">

            @forelse($jadualRingkas as $jadual)

                @php
                    $adaLaporan = LaporanBertugas::where(
                        'jadual_id',
                        $jadual->id
                    )->exists();
                @endphp

                <div class="bg-blue-50 p-3">

                    <div class="flex items-center gap-3">

                        {{-- ICON --}}
                        <div class="w-7 h-7 rounded-full bg-blue-600 flex items-center justify-center">

                            @if($adaLaporan)

                                <x-heroicon-o-check class="w-4 h-4 text-white" />

                            @else

                                <x-heroicon-o-clock class="w-4 h-4 text-white" />

                            @endif

                        </div>


                        {{-- PEGAWAI --}}
                        <div class="flex-1">

                            <p class="text-xs font-bold text-blue-700">
                                {{ $jadual->pegawai->name ?? 'Tiada Pegawai' }}
                            </p>

                            <p class="text-[11px] text-blue-600">

                                @if($adaLaporan)
                                    Tugasan Selesai
                                @else
                                    Menunggu tugasan
                                @endif

                            </p>

                        </div>


                        {{-- JENIS --}}
                        <div class="flex gap-1">

                            <span class="px-3 py-1 rounded-full
                                bg-green-200 text-green-700 text-[9px]">

                                {{ ucfirst($jadual->jenis) }}

                            </span>

                            <span class="px-2 py-1 rounded-full
                                bg-blue-300 text-blue-700 text-[9px]">

                                6.00pm

                            </span>

                        </div>

                    </div>


                    {{-- TARIKH --}}
                    <p class="text-[9px] text-right text-gray-500 mt-3">

                        {{ \Carbon\Carbon::parse($jadual->tarikh)->format('d/m/Y') }}

                    </p>

                </div>

            @empty

                <div class="bg-blue-50 p-5 text-center">

                    <x-heroicon-o-calendar
                        class="w-6 h-6 mx-auto text-gray-400 mb-2"
                    />

                    <p class="text-xs text-gray-500">
                        Tiada pegawai bertugas
                    </p>

                </div>

            @endforelse

        </div>


        {{-- FOOTER --}}
        @if($semuaJadual->count() > 2)

            <p class="text-center text-[10px] text-blue-600 mt-3">
                Klik untuk lihat semua jadual
            </p>

        @endif

    </div>


    {{-- MODAL --}}
    <div
        x-show="showModal"
        x-transition
        class="fixed inset-0 z-[999] flex items-center justify-center bg-black/40 px-4"
        style="display: none;"
        @click.self="showModal = false"
    >

        <div
            class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden"
            @click.stop
        >

            {{-- MODAL HEADER --}}
            <div class="flex items-center justify-between px-5 py-4 border-b">

                <div>
                    <h2 class="font-bold text-lg text-purple-800">
                        Senarai Pegawai Bertugas
                    </h2>

                    <p class="text-xs text-gray-500">
                        Keseluruhan jadual bertugas
                    </p>
                </div>

                <button
                    @click="showModal = false"
                    class="text-gray-500 hover:text-red-500 text-xl"
                >
                    ✕
                </button>

            </div>


            {{-- SENARAI --}}
            <div class="p-5 max-h-[60vh] overflow-y-auto">

                @forelse($semuaJadual as $jadual)

                    @php
                        $adaLaporan = LaporanBertugas::where(
                            'jadual_id',
                            $jadual->id
                        )->exists();
                    @endphp

                    <div class="bg-blue-50 p-4 mb-3 rounded-xl">

                        <div class="flex items-center gap-3">

                            <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center">

                                @if($adaLaporan)

                                    <x-heroicon-o-check class="w-5 h-5 text-white" />

                                @else

                                    <x-heroicon-o-clock class="w-5 h-5 text-white" />

                                @endif

                            </div>


                            <div class="flex-1">

                                <p class="text-sm font-bold text-blue-700">
                                    {{ $jadual->pegawai->name ?? 'Tiada Pegawai' }}
                                </p>

                                <p class="text-xs text-blue-600">
                                    {{ ucfirst($jadual->jenis) }}
                                </p>

                            </div>


                            <div class="text-right">

                                <p class="text-xs font-semibold text-gray-700">
                                    {{ \Carbon\Carbon::parse($jadual->tarikh)->format('d/m/Y') }}
                                </p>

                                @if($adaLaporan)

                                    <span class="text-[9px] text-green-600">
                                        Selesai
                                    </span>

                                @else

                                    <span class="text-[9px] text-orange-600">
                                        Menunggu
                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="text-center py-10 text-gray-400">
                        Tiada jadual bertugas.
                    </div>

                @endforelse

            </div>


            {{-- MODAL FOOTER --}}
            <div class="px-5 py-3 border-t flex justify-end">

                <button
                    @click="showModal = false"
                    class="px-5 py-2 rounded-full bg-purple-700 text-white text-xs"
                >
                    Tutup
                </button>

            </div>

        </div>

    </div>

</div>
