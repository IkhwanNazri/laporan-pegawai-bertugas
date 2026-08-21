<x-app-layout>
    <div class="py-8 min-h-screen bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px]">
        <div class="w-full px-4 sm:px-6 lg:px-8 space-y-4">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2">
                <div class="w-full">
                    <x-page-header title="Senarai Laporan Saya" :breadcrumbs="['Laporan' => '#']" />
                </div>
            </div>

            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm font-semibold">
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
                                <th class="p-3 w-1/3">Ulasan Saya</th>
                                <th class="p-3 text-center">Status Laporan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($laporans as $laporan)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 font-semibold text-purple-900">{{ $laporan->kod_laporan }}</td>
                                    <td class="p-3">{{ \Carbon\Carbon::parse($laporan->jadual->tarikh)->format('d/m/Y') }}</td>
                                    <td class="p-3">{{ $laporan->jadual->bahagian->kod_bahagian ?? '-' }} (Aras {{ $laporan->jadual->aras }})</td>
                                    <td class="p-3 text-gray-600">
                                        {{ Str::limit($laporan->ulasan ?? 'Tiada ulasan', 60) }}
                                    </td>

                                    <!-- Status Paparan Khas Untuk User -->
                                    <td class="p-3 text-center align-middle border-l border-gray-100">

                                        @if($laporan->status_pengesahan === 'dalam_proses' || $laporan->status_pengesahan === 'menunggu_pka')
                                            <!-- FASA 1: Menunggu PKA -->
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 border border-yellow-200 rounded-full shadow-xs">
                                                <svg class="w-3.5 h-3.5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                                Sedang Disemak (PKA)
                                            </span>

                                        @elseif($laporan->status_pengesahan === 'dihantar_ppkj' || $laporan->status_pengesahan === 'dihantar')
                                            <!-- FASA 2: Menunggu PPKJ -->
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium text-blue-800 bg-blue-100 border border-blue-200 rounded-full shadow-xs">
                                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                                Dalam Semakan PPKJ
                                            </span>

                                        @elseif($laporan->status_pengesahan === 'disahkan')
                                            <!-- FASA 3: Disahkan oleh PPKJ -->
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium text-indigo-800 bg-indigo-100 border border-indigo-200 rounded-full shadow-xs">
                                                Tindakan PKA
                                            </span>

                                        @elseif($laporan->status_pengesahan === 'selesai')
                                            <!-- FASA 4: Selesai -->
                                            <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full font-bold border border-green-200">
                                                ✓ Selesai
                                            </span>

                                        @elseif($laporan->status_pengesahan === 'menunggu_tindakan_user')
                                        <form action="{{ route('user.laporan.update_ulasan', $laporan->id) }}" method="POST" class="flex flex-col gap-2 p-2 bg-amber-50 border border-amber-200 rounded-xl text-left">
                                                @csrf
                                                @method('PATCH')

                                                <label class="text-[11px] font-bold text-amber-900">Kemaskini Ulasan / Tindakan Lanjut:</label>

                                                <textarea name="ulasan" rows="2" class="w-full text-xs p-2 border-amber-300 rounded-lg focus:ring-amber-500 focus:border-amber-500" placeholder="Taip ulasan/tindakan terkini di sini..." required>{{ old('ulasan', $laporan->ulasan) }}</textarea>

                                                <button type="submit" class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-lg shadow-sm transition">
                                                    Hantar Semula
                                                </button>
                                    </form>
                                    @endif

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-400 font-medium">
                                        Tiada rekod laporan ditemui.
                                    </td>
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
