<x-app-layout>
    <div class="py-8 min-h-screen bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px]">
        <div class="w-full px-4 sm:px-6 lg:px-8 space-y-4">

            <x-page-header title="Pengesahan Laporan" :breadcrumbs="['Pengesahan' => '#']" />

            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 text-sm text-gray-500 uppercase bg-gray-50">
                            <th class="p-3">Maklumat Tugas</th>
                            <th class="p-3">Pegawai Bertugas</th>
                            <th class="p-3">Ringkasan & Insiden</th>
                            <th class="p-3">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($laporans as $laporan)
                            <tr class="hover:bg-gray-50">

                                <td class="p-3 align-top">
                                    <p class="font-bold text-purple-900">{{ $laporan->kod_laporan }}</p>
                                    <p class="text-gray-500">{{ \Carbon\Carbon::parse($laporan->jadual->tarikh)->format('d/m/Y') }}</p>
                                    <p class="text-xs">{{ $laporan->jadual->bahagian->kod_bahagian ?? '-' }} ({{ $laporan->jadual->aras }})</p>
                                </td>


                                <td class="p-3 align-top font-medium">
                                    {{ $laporan->jadual->pegawai->name ?? '-' }}
                                </td>


                                <td class="p-3 align-top">
                                    <p class="font-semibold {{ $laporan->status_insiden === 'Aman / Tiada Insiden' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $laporan->status_insiden }}
                                    </p>
                                    <p class="text-gray-600 mt-1 line-clamp-2">{{ $laporan->ringkasan_tugas }}</p>
                                </td>


                                <td class="p-3 align-top">
                                    <div class="flex gap-2">

                                        <form action="{{ route('pengesahan.sahkan', $laporan->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status_pengesahan" value="disahkan">
                                            <button type="submit" onclick="return confirm('Sahkan laporan ini?')" class="px-3 py-1.5 bg-green-100 text-green-700 hover:bg-green-200 rounded-lg font-semibold text-xs transition-colors">
                                                ✓ Sahkan
                                            </button>
                                        </form>


                                        <form action="{{ route('pengesahan.sahkan', $laporan->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status_pengesahan" value="ditolak">
                                            <button type="submit" onclick="return confirm('Tolak laporan ini?')" class="px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg font-semibold text-xs transition-colors">
                                                ✕ Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-400">
                                    Syabas! Tiada laporan baru yang memerlukan pengesahan buat masa ini.
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
