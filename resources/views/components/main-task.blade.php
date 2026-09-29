@php
    use App\Models\Jadual;
    use App\Models\LaporanBertugas;

    $jaduals = Jadual::with(['pegawai', 'bahagian'])
        ->orderBy('tarikh', 'asc')
         ->paginate(5);
@endphp

<div x-data="{ openMenu: null }" class="font-['Poppins']">

    {{-- HEADER --}}
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

        <a href="{{ route('pka.jadual.index') }}"
           class="mt-5 px-7 py-1 rounded-full bg-purple-700 text-white text-xs font-['Poppins']">
            View All
        </a>
    </div>


    {{-- SEMUA JADUAL --}}
    @forelse($jaduals as $jadual)

        @php
            $laporan = LaporanBertugas::where('jadual_id', $jadual->id)->first();

            $statusData = $laporan?->senarai_semak['status'] ?? [];

            $total = 0;
            $selesai = 0;

            foreach ($statusData as $item) {
                if (is_array($item)) {
                    foreach ($item as $status) {
                        $total++;

                        if ($status === '/') {
                            $selesai++;
                        }
                    }
                } else {
                    $total++;

                    if ($item === '/') {
                        $selesai++;
                    }
                }
            }

            $progress = $total > 0
                ? round(($selesai / $total) * 100)
                : 0;

            if ($progress >= 100) {
                $statusText = 'Selesai';
                $statusClass = 'bg-green-400 text-black';
            } elseif ($progress > 0) {
                $statusText = 'Dalam Proses';
                $statusClass = 'bg-yellow-300 text-black';
            } else {
                $statusText = 'Menunggu';
                $statusClass = 'bg-pink-500 text-white';
            }
        @endphp


        {{-- TASK --}}
        <div class="relative bg-white rounded-full shadow-lg px-4 py-3 mb-4 flex items-center gap-5">

            {{-- USER ICON --}}
            <div class="w-9 h-9 rounded-full bg-black flex items-center justify-center">
                <x-heroicon-o-user class="w-5 h-5 text-white" />
            </div>


            {{-- NAMA --}}
            <div class="w-24 font-bold text-sm">
                {{ $jadual->pegawai->name ?? 'Tiada Pegawai' }}
            </div>


            {{-- JENIS --}}
            <div class="flex-1 text-blue-700 text-sm">
                {{ ucfirst($jadual->jenis) }}
            </div>


            {{-- TARIKH --}}
            <div class="flex-1 text-blue-700 text-sm">
                {{ \Carbon\Carbon::parse($jadual->tarikh)->format('d/m/Y') }}
            </div>


            {{-- PROGRESS --}}
            <div class="w-28">

                <div class="text-[10px] text-gray-500 mb-1">
                    Progress {{ $progress }}%
                </div>

                <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div
                        class="h-full bg-purple-600 rounded-full"
                        style="width: {{ $progress }}%">
                    </div>
                </div>

            </div>


            {{-- STATUS --}}
            <span class="px-5 py-2 {{ $statusClass }} text-xs rounded-lg whitespace-nowrap">
                {{ $statusText }}
            </span>


            {{-- 3 TITIK --}}
            <button
                @click="openMenu = openMenu === {{ $loop->index }} ? null : {{ $loop->index }}"
                class="text-blue-600 text-lg px-2">
                ⋮
            </button>


            {{-- POPUP --}}
            <div
                x-show="openMenu === {{ $loop->index }}"
                @click.outside="openMenu = null"
                x-transition
                class="absolute right-5 top-14 z-50 w-48 bg-white rounded-xl shadow-xl border border-gray-200 p-2"
                style="display: none;"
            >

                <div class="px-3 py-2 text-xs font-semibold text-gray-500 border-b">
                    Ingatkan Pegawai
                </div>

                @if($jadual->pegawai?->email)

                    <form method="POST" action="{{ route('pka.jadual.reminder', $jadual->id) }}">
                        @csrf

                        <button
                            type="submit"
                            class="w-full text-left block px-3 py-2 text-sm hover:bg-purple-50 rounded-lg"
                        >
                            Emel Pegawai
                        </button>
                    </form>

                @endif



            </div>

        </div>

    @empty

        <div class="bg-white rounded-3xl p-6 text-center text-gray-400">
            Tiada jadual bertugas.
        </div>

    @endforelse
    @if($jaduals->hasPages())
    <div class="flex justify-center mt-5">
        {{ $jaduals->links() }}
    </div>
@endif

</div>
