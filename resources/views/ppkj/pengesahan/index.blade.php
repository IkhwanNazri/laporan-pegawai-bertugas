<x-app-layout>
    <div class="py-8 min-h-screen bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px]">
        <div class="w-full px-4 sm:px-6 lg:px-8 space-y-4">


            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                <x-page-header title="Semakan Akhir PPKJ (Bahagian C)" :breadcrumbs="['PPKJ' => '#', 'Pengesahan' => '#']" />
            </div>

            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 mb-4 bg-red-100 text-red-700 rounded-lg text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 text-sm text-gray-500 uppercase bg-gray-50">
                            <th class="p-3">Maklumat Laporan</th>
                            <th class="p-3">Ulasan Pegawai</th>
                            <th class="p-3 w-1/3">Tindakan / Ulasan PPKJ (Bahagian C)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($laporans as $laporan)
                            <tr class="hover:bg-gray-50 align-top">


                                <td class="p-3">
                                    <p class="font-bold text-purple-900 mb-1">{{ $laporan->kod_laporan }}</p>
                                    <p class="text-gray-600">
                                    Tarikh:
                                    <span class="font-semibold">
                                        {{ $laporan->jadual?->tarikh ? \Carbon\Carbon::parse($laporan->jadual->tarikh)->format('d/m/Y') : '-' }}
                                    </span>
                                </p>


                                <p class="text-gray-600">
                                    Aras: <span class="font-semibold">{{ $laporan->jadual?->aras ?? '-' }}</span>
                                </p>


                                <p class="text-gray-600">
                                    Pegawai: <span class="font-semibold uppercase">{{ $laporan->jadual?->pegawai?->name ?? '-' }}</span>
                                </p>
                                </td>


                                <td class="p-3 text-gray-700">
                                    <p class="italic">"{{ $laporan->ulasan ?? 'Tiada ulasan ditinggalkan.' }}"</p>
                                    <p class="mt-2 text-xs text-blue-600 font-bold">✓ Telah disahkan oleh PKA (Penyelia)</p>
                                </td>


                                <td class="p-3">
    <td class="p-3">
    @if(empty($laporan->ulasan_ppkj))

        <form action="{{ route('ppkj.pengesahan.sahkan', $laporan->id) }}" method="POST" class="space-y-2">
            @csrf
            <textarea name="ulasan_ppkj" rows="2" class="w-full text-xs rounded-lg border-gray-300 p-2" placeholder="Masukkan ulasan PPKJ..." required></textarea>
            <button type="submit" class="px-3 py-1.5 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700">
                Hantar ke PKA
            </button>
        </form>
    @else

        <div class="text-xs text-gray-700 bg-gray-50 p-2 rounded border">
            <p class="font-semibold text-gray-500">Ulasan PPKJ:</p>
            <p class="italic">"{{ $laporan->ulasan_ppkj }}"</p>
            <span class="text-green-600 font-bold text-[10px]">✓ Telah dihantar ke PKA</span>
        </div>
    @endif
</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-8 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="font-medium">Tiada laporan yang menunggu semakan PPKJ pada masa ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $laporans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
