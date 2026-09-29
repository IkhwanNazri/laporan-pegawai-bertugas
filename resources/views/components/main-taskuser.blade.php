@php
    use App\Models\Jadual;

    $jaduals = Jadual::with(['pegawai', 'bahagian', 'laporan'])
        ->orderBy('tarikh', 'asc')
        ->get();
@endphp

<div x-data="{ openMenu: null }" class="font-['Poppins']">

    <div class="flex items-center justify-between mb-3 px-1">
        <div class="flex items-center gap-3">
            <h2 class="text-2xl font-bold font-['Poppins']">
                Main Task
            </h2>

            <span class="text-lg text-purple-900">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
</svg>

            </span>
        </div>



    </div>

    @forelse($jaduals as $jadual)

        @php
            $laporan = $jadual->laporan;
            $jenis = strtolower($jadual->jenis ?? 'harian');

            if (!$laporan) {
                $statusText = 'Isi Borang';
                $statusClass = 'bg-green-500 text-white';
                $progress = 0;
            } elseif ($laporan->status_pengesahan === 'selesai') {
                $statusText = 'Selesai';
                $statusClass = 'bg-green-400 text-black';
                $progress = 100;
            } elseif ($laporan->status_tindakan_pka === 'menunggu_pka') {
                $statusText = 'Menunggu PKA';
                $statusClass = 'bg-yellow-300 text-black';
                $progress = 75;
            } else {
                $statusText = 'Menunggu';
                $statusClass = 'bg-pink-500 text-white';
                $progress = 50;
            }

            $tarikhMula = \Carbon\Carbon::parse($jadual->tarikh);
            $tarikhAkhir = $jenis === 'mingguan'
                ? $tarikhMula->copy()->addDays(6)
                : $tarikhMula;
        @endphp

        <div class="relative bg-white rounded-xl shadow-lg px-4 py-3 mb-4 flex items-center gap-5">

            <div class="w-9 h-9 rounded-full bg-black flex items-center justify-center">
                <x-heroicon-o-user class="w-5 h-5 text-white" />
            </div>

            <div class="w-24 font-semibold text-sm">
                {{ $jadual->pegawai->name ?? 'Tiada Pegawai' }}
            </div>

            <div class="flex-1 text-blue-700 text-sm">
                {{ ucfirst($jadual->jenis) }}
            </div>

            <div class="flex-1 text-blue-700 text-sm">
                @if($jenis === 'mingguan')
                    {{ $tarikhMula->format('d/m/Y') }}
                    -
                    {{ $tarikhAkhir->format('d/m/Y') }}
                @else
                    {{ $tarikhMula->format('d/m/Y') }}
                @endif
            </div>

            <div class="w-28">
                <div class="text-[10px] text-gray-500 mb-1">
                    Progress {{ $progress }}%
                </div>

                <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div
                        class="h-full bg-purple-600 rounded-full transition-all"
                        style="width: {{ $progress }}%">
                    </div>
                </div>
            </div>

            @if($statusText === 'Isi Borang')
                <a href="{{ route('user.laporan.laporanb', ['jadual_id' => $jadual->id]) }}"
                   class="inline-flex items-center justify-center px-4 py-1.5 text-xs font-md text-white bg-green-600 space-x-2 gap-2 rounded-lg hover:bg-green-700 transition-all shadow-sm whitespace-nowrap">
                    <span>Isi Borang</span>
                    <x-heroicon-o-arrow-right class="w-3 h-3" />
                </a>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-md {{ $statusClass }} rounded-lg whitespace-nowrap">
                    @if($statusText === 'Selesai')
                        ✓
                    @else
                        <x-heroicon-s-clock class="w-3 h-3" />
                    @endif

                    {{ $statusText }}
                </span>
            @endif



            <div
                x-show="openMenu === {{ $loop->index }}"
                @click.outside="openMenu = null"
                x-transition
                class="absolute right-5 top-14 z-50 w-48 bg-white rounded-xl shadow-xl border border-gray-200 p-2"
                style="display: none;">

                <div class="px-3 py-2 text-xs font-semibold text-gray-500 border-b">
                    Ingatkan Pegawai
                </div>

                @if($jadual->pegawai?->email)
                    <form method="POST" action="{{ route('pka.jadual.reminder', $jadual->id) }}">
                        @csrf

                        <button
                            type="submit"
                            class="w-full text-left block px-3 py-2 text-sm hover:bg-purple-50 rounded-lg">
                            Emel Pegawai
                        </button>
                    </form>
                @else
                    <div class="px-3 py-2 text-xs text-gray-400">
                        Tiada emel pegawai
                    </div>
                @endif

            </div>

        </div>

    @empty

        <div class="bg-white rounded-3xl p-6 text-center text-gray-400">
            Tiada jadual bertugas.
        </div>

    @endforelse

</div>
