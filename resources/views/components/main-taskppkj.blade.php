@php
    use App\Models\Jadual;
    use Carbon\Carbon;

    $jaduals = Jadual::with(['pegawai', 'bahagian', 'laporan'])
        ->whereHas('laporan')
        ->latest('updated_at')
        ->get();

    $recentJaduals = $jaduals
        ->filter(fn ($jadual) => $jadual->laporan?->status_pengesahan !== 'selesai')
        ->take(5);

    $historyJaduals = $jaduals
        ->filter(fn ($jadual) => $jadual->laporan?->status_pengesahan === 'selesai')
        ->take(5);
@endphp

<div
    x-data="{
        showModal: false,
        selectedReport: null,

        openReport(report) {
            this.selectedReport = report;
            this.showModal = true;
        },

        closeReport() {
            this.showModal = false;
            this.selectedReport = null;
        }
    }"
    class="font-['Poppins']"
>

    <div class="flex items-center justify-between mb-3 px-1">
        <div class="flex items-center gap-3">
            <h2 class="text-2xl font-bold">
                Main Task
            </h2>

            <x-heroicon-o-clipboard-document-list class="w-6 h-6 text-purple-900" />
        </div>
    </div>

    <div class="mb-6">

        <div class="flex items-center gap-2 mb-3 px-1">
            <h3 class="text-lg font-bold text-gray-800">
                Recent
            </h3>

            <span class="px-2 py-1 text-xs font-semibold bg-purple-100 text-purple-700 rounded-full">
                {{ $recentJaduals->count() }}
            </span>
        </div>

        @forelse($recentJaduals as $jadual)

            @php
                $laporan = $jadual->laporan;
                $jenis = strtolower($jadual->jenis ?? 'harian');
                $tarikhMula = Carbon::parse($jadual->tarikh);

                $tarikhAkhir = $jenis === 'mingguan'
                    ? $tarikhMula->copy()->addDays(6)
                    : $tarikhMula;

                if ($laporan->status_tindakan_pka === 'menunggu_pka') {
                    $statusText = 'Menunggu PKA';
                    $statusClass = 'bg-yellow-300 text-black';
                    $progress = 75;
                } else {
                    $statusText = 'Menunggu';
                    $statusClass = 'bg-pink-500 text-white';
                    $progress = 50;
                }

                $reportData = [
                    'jadual_id' => $jadual->id,
                    'kod' => $laporan->kod_laporan ?? '-',
                    'nama' => $jadual->pegawai->name ?? '-',
                    'tarikh' => $tarikhMula->format('d/m/Y'),
                    'tarikh_akhir' => $jenis === 'mingguan'
                        ? $tarikhAkhir->format('d/m/Y')
                        : null,
                    'jenis' => ucfirst($jenis),
                    'bahagian' => $jadual->bahagian->nama ?? '-',
                    'aras' => $jadual->aras ?? '-',
                    'masa_tandatangan' => $laporan->masa_tandatangan
                        ? Carbon::parse($laporan->masa_tandatangan)->format('d/m/Y H:i')
                        : '-',
                    'ulasan' => $laporan->ulasan ?? '-',
                    'senarai_semak' => $laporan->senarai_semak ?? [],
                    'status' => $laporan->status_pengesahan ?? '-',
                ];
            @endphp

            <div class="bg-white rounded-xl shadow-lg px-4 py-3 mb-4">

                <div class="flex items-center gap-5">

                    <div class="w-9 h-9 rounded-full bg-black flex items-center justify-center shrink-0">
                        <x-heroicon-o-user class="w-5 h-5 text-white" />
                    </div>

                    <div class="w-32 shrink-0">
                        <div class="font-semibold text-sm text-gray-800">
                            {{ $jadual->pegawai->name ?? 'Tiada Pegawai' }}
                        </div>

                        <div class="text-xs text-gray-500">
                            {{ ucfirst($jenis) }}
                        </div>
                    </div>

                    <div class="flex-1 text-sm text-blue-700">
                        @if($jenis === 'mingguan')
                            {{ $tarikhMula->format('d/m/Y') }}
                            -
                            {{ $tarikhAkhir->format('d/m/Y') }}
                        @else
                            {{ $tarikhMula->format('d/m/Y') }}
                        @endif
                    </div>

                    <div class="w-28 shrink-0">
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

                    <span class="px-3 py-1.5 text-xs font-medium {{ $statusClass }} rounded-lg whitespace-nowrap">
                        {{ $statusText }}
                    </span>

                    <button
                        type="button"
                        @click="openReport(@js($reportData))"
                        class="px-3 py-1.5 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg">
                        View
                    </button>

                    <form
                        action="{{ url('/ppkj/pengesahan/index') }}"
                        method="POST"
                        class="inline">
                        @csrf

                        <input
                            type="hidden"
                            name="jadual_id"
                            value="{{ $jadual->id }}">

                        <a href="{{ route('ppkj.pengesahan.index') }}"

                            class="text-blue-600 text-lg px-2 hover:text-blue-800">
                            →
                        </a>
                    </form>

                </div>

            </div>

        @empty

            <div class="bg-white rounded-xl shadow-sm p-5 text-center text-gray-400">
                Tiada laporan terkini.
            </div>

        @endforelse

    </div>

    <div>

        <div class="flex items-center gap-2 mb-3 px-1">
            <h3 class="text-lg font-bold text-gray-800">
                History
            </h3>

            <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                {{ $historyJaduals->count() }}
            </span>
        </div>

        @forelse($historyJaduals as $jadual)

            @php
                $laporan = $jadual->laporan;
                $jenis = strtolower($jadual->jenis ?? 'harian');
                $tarikhMula = Carbon::parse($jadual->tarikh);

                $tarikhAkhir = $jenis === 'mingguan'
                    ? $tarikhMula->copy()->addDays(6)
                    : $tarikhMula;

                $reportData = [
                    'jadual_id' => $jadual->id,
                    'kod' => $laporan->kod_laporan ?? '-',
                    'nama' => $jadual->pegawai->name ?? '-',
                    'tarikh' => $tarikhMula->format('d/m/Y'),
                    'tarikh_akhir' => $jenis === 'mingguan'
                        ? $tarikhAkhir->format('d/m/Y')
                        : null,
                    'jenis' => ucfirst($jenis),
                    'bahagian' => $jadual->bahagian->nama ?? '-',
                    'aras' => $jadual->aras ?? '-',
                    'masa_tandatangan' => $laporan->masa_tandatangan
                        ? Carbon::parse($laporan->masa_tandatangan)->format('d/m/Y H:i')
                        : '-',
                    'ulasan' => $laporan->ulasan ?? '-',
                    'senarai_semak' => $laporan->senarai_semak ?? [],
                    'status' => $laporan->status_pengesahan ?? '-',
                ];
            @endphp

            <div class="bg-white rounded-xl shadow-lg px-4 py-3 mb-4">

                <div class="flex items-center gap-5">

                    <div class="w-9 h-9 rounded-full bg-green-500 flex items-center justify-center shrink-0">
                        <x-heroicon-s-check class="w-5 h-5 text-white" />
                    </div>

                    <div class="w-32 shrink-0">
                        <div class="font-semibold text-sm text-gray-800">
                            {{ $jadual->pegawai->name ?? 'Tiada Pegawai' }}
                        </div>

                        <div class="text-xs text-gray-500">
                            {{ ucfirst($jenis) }}
                        </div>
                    </div>

                    <div class="flex-1 text-sm text-blue-700">
                        @if($jenis === 'mingguan')
                            {{ $tarikhMula->format('d/m/Y') }}
                            -
                            {{ $tarikhAkhir->format('d/m/Y') }}
                        @else
                            {{ $tarikhMula->format('d/m/Y') }}
                        @endif
                    </div>

                    <div class="w-28 shrink-0">
                        <div class="text-[10px] text-gray-500 mb-1">
                            Progress 100%
                        </div>

                        <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-purple-600 rounded-full w-full"></div>
                        </div>
                    </div>

                    <span class="px-3 py-1.5 text-xs font-medium bg-green-400 text-black rounded-lg whitespace-nowrap">
                        ✓ Selesai
                    </span>

                    <button
                        type="button"
                        @click="openReport(@js($reportData))"
                        class="px-3 py-1.5 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg">
                        View
                    </button>

                </div>

            </div>

        @empty

            <div class="bg-white rounded-xl shadow-sm p-5 text-center text-gray-400">
                Tiada history.
            </div>

        @endforelse

    </div>

    <div
        x-show="showModal"
        x-transition.opacity
        class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
        style="display: none;"
    >

        <div
            class="absolute inset-0 bg-black/50"
            @click="closeReport()">
        </div>

        <div
            x-show="showModal"
            x-transition
            class="relative w-full max-w-3xl max-h-[90vh] overflow-y-auto bg-white rounded-2xl shadow-2xl"
        >

            <div class="sticky top-0 z-10 flex items-center justify-between px-6 py-4 bg-white border-b">

                <div>
                    <h3 class="text-lg font-bold text-gray-800">
                        Laporan Pegawai
                    </h3>

                    <p
                        class="text-xs text-gray-500 mt-1"
                        x-text="selectedReport?.kod">
                    </p>
                </div>

                <button
                    type="button"
                    @click="closeReport()"
                    class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600">
                    ✕
                </button>

            </div>

            <div
                class="p-6 space-y-5"
                x-show="selectedReport">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="text-xs text-gray-500 mb-1">
                            Nama Pegawai
                        </div>

                        <div
                            class="font-semibold text-gray-800"
                            x-text="selectedReport?.nama">
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="text-xs text-gray-500 mb-1">
                            Jenis
                        </div>

                        <div
                            class="font-semibold text-gray-800"
                            x-text="selectedReport?.jenis">
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="text-xs text-gray-500 mb-1">
                            Tarikh
                        </div>

                        <div class="font-semibold text-gray-800">
                            <span x-text="selectedReport?.tarikh"></span>

                            <template x-if="selectedReport?.tarikh_akhir">
                                <span>
                                    -
                                    <span x-text="selectedReport?.tarikh_akhir"></span>
                                </span>
                            </template>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="text-xs text-gray-500 mb-1">
                            Bahagian
                        </div>

                        <div
                            class="font-semibold text-gray-800"
                            x-text="selectedReport?.bahagian">
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="text-xs text-gray-500 mb-1">
                            Aras
                        </div>

                        <div
                            class="font-semibold text-gray-800"
                            x-text="selectedReport?.aras">
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="text-xs text-gray-500 mb-1">
                            Masa Tandatangan
                        </div>

                        <div
                            class="font-semibold text-gray-800"
                            x-text="selectedReport?.masa_tandatangan">
                        </div>
                    </div>

                </div>

                <div>
                    <h4 class="text-sm font-bold text-gray-800 mb-2">
                        Ulasan Pegawai
                    </h4>

                    <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-700 whitespace-pre-line">
                        <span x-text="selectedReport?.ulasan"></span>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-gray-800 mb-2">
                        Senarai Semak
                    </h4>

                    <div class="bg-gray-50 rounded-xl p-4">

                        <template x-if="Array.isArray(selectedReport?.senarai_semak)">

                            <div class="space-y-2">

                                <template
                                    x-for="(item, index) in selectedReport.senarai_semak"
                                    :key="index">

                                    <div class="flex items-center justify-between gap-4 py-2 border-b last:border-0">

                                        <span
                                            class="text-sm text-gray-700"
                                            x-text="typeof item === 'object'
                                                ? (item.nama ?? item.label ?? item.perkara ?? '-')
                                                : item">
                                        </span>

                                        <span
                                            class="text-xs font-semibold text-gray-600"
                                            x-text="typeof item === 'object'
                                                ? (item.status ?? '-')
                                                : ''">
                                        </span>

                                    </div>

                                </template>

                            </div>

                        </template>

                        <template x-if="!Array.isArray(selectedReport?.senarai_semak)">
                            <div class="text-sm text-gray-500">
                                Tiada data senarai semak.
                            </div>
                        </template>

                    </div>
                </div>

                <div class="flex items-center justify-between pt-2 border-t">

                    <div>
                        <div class="text-xs text-gray-500">
                            Status Pengesahan
                        </div>

                        <div
                            class="text-sm font-semibold text-gray-800 mt-1"
                            x-text="selectedReport?.status">
                        </div>
                    </div>

                    <form
                        action="{{ url('/ppkj/pengesahan/index') }}"
                        method="POST">

                        @csrf

                        <input
                            type="hidden"
                            name="jadual_id"
                            :value="selectedReport?.jadual_id">

                        <button
                            type="submit"
                            class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-lg">
                            Pergi Pengesahan
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
