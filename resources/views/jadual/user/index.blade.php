<x-app-layout>
    <div class="py-8 min-h-screen bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px]">
        <div class="max-w-full px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Bahagian Header (Tanpa Butang Tambah) -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-3">
                 <div class="w-full">
                    <x-page-header class="" title="Jadual Sistem Pegawai Bertugas" :breadcrumbs="['Jadual' => '#']" />
                </div>
            </div>

            <!-- Mesej Berjaya -->
            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Bahagian Jadual -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6">

                <div class="flex items-center gap-2 mb-4">
                    <div class="w-2 h-6 bg-purple-600 rounded-full"></div>
                    <h3 class="text-base font-bold text-gray-800 uppercase">Jadual Tugasan Anda</h3>
                </div>

                <div class="overflow-x-auto border border-gray-200 rounded-lg">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 text-xs text-gray-600 uppercase bg-gray-100/50">
                                <th class="p-3 w-32">Tarikh</th>
                                <th class="p-3">Jenis</th>
                                <th class="p-3">Bahagian / Aras</th>
                                <th class="p-3">Pegawai Bertugas</th>
                                <th class="p-3">No Telefon</th>
                                <th class="p-3">Pegawai Pengganti</th>
                                <th class="p-3 text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">

                            <!-- Loop melalui senarai jadual -->
                            @forelse($jaduals as $jadual)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 font-semibold">{{ \Carbon\Carbon::parse($jadual->tarikh)->format('d/m/Y') }}</td>

                                    <!-- Paparan Badge (Harian / Mingguan) -->
                                    <td class="p-3">
                                        @if(strtolower($jadual->jenis ?? 'harian') === 'mingguan')
                                            <span class="px-2.5 py-1 text-[10px] font-bold text-emerald-700 bg-emerald-100 rounded-full uppercase tracking-wider">Mingguan</span>
                                        @else
                                            <span class="px-2.5 py-1 text-[10px] font-bold text-purple-700 bg-purple-100 rounded-full uppercase tracking-wider">Harian</span>
                                        @endif
                                    </td>

                                    <td class="p-3">{{ $jadual->bahagian->kod_bahagian ?? '-' }} <span class="text-gray-400">|</span> Aras {{ $jadual->aras }}</td>
                                    <td class="p-3 font-bold text-gray-800">{{ $jadual->pegawai->name ?? '-' }}</td>
                                    <td class="p-3 text-gray-600">{{ $jadual->no_telefon ?? '-' }}</td>
                                    <td class="p-3 text-gray-500">{{ $jadual->pegawaiGanti->name ?? '-' }}</td>

                                    <!-- Butang Ke Borang Laporan -->
                                    <td class="p-3 text-center">
                                        @if($jadual->laporan)
                                            <!-- Jika laporan telah diisi -->
                                            @if($jadual->laporan->status_pengesahan === 'selesai')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-green-700 bg-green-100 border border-green-300 rounded-full shadow-sm">
                                                    ✓ Selesai
                                                </span>
                                            @else
                                                <span class="flex items-center gap-2 text-xs font-semibold text-purple-800">
                                                    <x-heroicon-s-clock class="w-3 h-3"></x-heroicon-s-clock>
                                                    Sedang Disemak
                                                </span>
                                            @endif
                                        @else
                                            <!-- Jika laporan belum diisi -->
                                            <a href="{{ route('user.laporan.laporanb', ['jadual_id' => $jadual->id]) }}" class="inline-flex items-center justify-center px-4 py-1.5 text-xs font-bold text-white bg-purple-600 space-x-2 gap-2 rounded-full hover:bg-purple-700 transition-all shadow-sm">
                                                <span>Isi Borang</span>
                                                <x-heroicon-o-arrow-right class="w-3 h-3" />
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-gray-400 font-medium">Tiada jadual tugasan untuk anda buat masa ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginasi -->
                <div class="mt-4 pb-2">
                    {{ $jaduals->links() }}
                </div>
            </div>

        </div>
    </div>
    <x-footer></x-footer>
</x-app-layout>
