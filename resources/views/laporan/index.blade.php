<x-app-layout>
    <div class="py-8 min-h-screen bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px]">
        <div class="w-full px-4 sm:px-6 lg:px-8 space-y-4">


            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2">
                <div class="w-full">
                    <x-page-header title="Senarai Laporan" :breadcrumbs="['Laporan' => '#']" />
                </div>

               <x-button-tambahLaporan></x-button-tambahLaporan>
            </div>

            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 text-sm text-gray-500 uppercase bg-gray-50">
                                <th class="p-3">Kod Laporan</th>
                                <th class="p-3">Tarikh Tugas</th>
                                <th class="p-3">Bahagian / Aras</th>
                                <th class="p-3 w-1/3">Ulasan Pegawai</th>
                                <th class="p-3 text-center">Status / Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($laporans as $laporan)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 font-semibold text-purple-900">{{ $laporan->kod_laporan }}</td>
                                    <td class="p-3">{{ \Carbon\Carbon::parse($laporan->jadual->tarikh)->format('d/m/Y') }}</td>
                                    <td class="p-3">{{ $laporan->jadual->bahagian->kod_bahagian ?? '-' }} ({{ $laporan->jadual->aras }})</td>


                                    <td class="p-3 text-gray-600">
                                        {{ Str::limit($laporan->ulasan ?? 'Tiada ulasan', 60) }}
                                    </td>


                                <td class="p-3 text-center align-top border-l border-gray-100">

                                    @if($laporan->status_pengesahan === 'dalam_proses')
                                        <!-- FASA 1: PKA Perlu Hantar ke PPKJ -->
                                        <form action="{{ route('laporan.hantar', $laporan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Pasti untuk hantar kepada PPKJ?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white bg-purple-900 rounded-lg hover:bg-purple-800 transition shadow-sm">
                                                Hantar ke PPKJ
                                            </button>
                                        </form>

                                    @elseif($laporan->status_pengesahan === 'dihantar_ppkj' || $laporan->status_pengesahan === 'dihantar')

                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-medium text-yellow-800 bg-yellow-50 border border-yellow-200/60 shadow-2xs rounded-full">
                                    <svg class="w-3 h-3 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    Menunggu PPKJ
                                </span>

                                    @elseif($laporan->status_pengesahan === 'disahkan')

                                        <div class="text-left bg-blue-50/50 p-3 rounded-lg border border-blue-100 mb-2 text-xs">
                                            <span class="font-bold text-blue-900">Ulasan PPKJ:</span>
                                            <p class="italic text-gray-700 mt-1">"{{ $laporan->ulasan_ppkj }}"</p>
                                        </div>

                                        <form action="{{ route('laporan.selesai', $laporan->id) }}" method="POST" class="flex flex-col gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status_tindakan_pka" class="text-xs border-gray-300 shadow-sm rounded-lg focus:ring-green-500 focus:border-green-500" required>
                                                <option value="">-- Pilih Tindakan --</option>
                                                <option value="Sudah Bertindak">Sudah Bertindak</option>
                                                <option value="Belum Bertindak">Belum Bertindak</option>
                                            </select>
                                            <button type="submit" class="px-3 py-1.5 bg-green-600 text-white text-xs font-bold rounded-lg hover:bg-green-700 shadow-sm transition">
                                                Sahkan Tindakan
                                            </button>
                                        </form>

                                    @elseif($laporan->status_pengesahan === 'selesai')

                                        <div class="flex flex-col items-center gap-1">
                                            <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full font-bold border border-green-200">
                                                ✓ Selesai
                                            </span>
                                            <span class="text-[10px] text-gray-500 font-semibold uppercase">
                                                Tindakan PKA: {{ $laporan->status_tindakan_pka }}
                                            </span>
                                        </div>
                                    @endif

                                </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-gray-400">Tiada rekod laporan ditemui.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $laporans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
