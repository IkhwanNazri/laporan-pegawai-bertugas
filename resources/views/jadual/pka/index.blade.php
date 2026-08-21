<x-app-layout>
    <div class="py-8 min-h-screen bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px]">
        <div class="max-w-full px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-3">
                 <div class="w-full">
                    <x-page-header class="" title="Jadual Sistem Pegawai Bertugas" :breadcrumbs="['Jadual' => '#']" />
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto mb-4">
                    <!-- Butang Export PDF -->
                    <a href="#" class="inline-flex items-center justify-center px-4 py-2.5 bg-red-600 text-white text-sm font-medium rounded-full hover:bg-red-700 transition-all shadow-md whitespace-nowrap mb-4">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export PDF
                    </a>

                    <a href="{{ route('pka.jadual.pilihan') }}" class="inline-flex items-center justify-center px-5 py-2.5 mb-4 bg-purple-900 text-white text-sm font-medium rounded-full hover:bg-purple-800 transition-all shadow-md whitespace-nowrap">
                        + Tambah Jadual
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Borang Penapis / Carian -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                <form action="{{ route('pka.jadual.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end">

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Carian Bebas</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau no. telefon..." class="w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Bahagian</label>
                        <select name="bahagian" class="w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="">Semua Bahagian</option>
                            <option value="BPM" {{ request('bahagian') == 'BPM' ? 'selected' : '' }}>BPM</option>
                            <option value="BKP" {{ request('bahagian') == 'BKP' ? 'selected' : '' }}>BKP</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Aras</label>
                        <select name="aras" class="w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="">Semua Aras</option>
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ request('aras') == $i ? 'selected' : '' }}>Aras {{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Bulan & Tahun</label>
                        <input type="month" name="bulan" value="{{ request('bulan') }}" class="w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>

                    <div class="flex space-x-2">
                        <button type="submit" class="inline-flex items-center justify-center p-3 bg-gray-800 text-white text-sm font-medium rounded-full hover:bg-gray-900 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                            </svg>
                        </button>
                        @if(request()->anyFilled(['search', 'bahagian', 'aras', 'bulan']))
                            <a href="{{ route('pka.jadual.index') }}" class="inline-flex items-center justify-center px-3 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition">
                                ✕
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            @php
                $jadualHarian = $jaduals->filter(function($item) {
                    return strtolower($item->jenis ?? '') !== 'mingguan';
                });
                $jadualMingguan = $jaduals->filter(function($item) {
                    return strtolower($item->jenis ?? '') === 'mingguan';
                });
            @endphp

            <!-- JADUAL HARIAN -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-2 h-6 bg-purple-600 rounded-full"></div>
                    <h3 class="text-base font-bold text-gray-800 uppercase">Jadual Bertugas (Harian)</h3>
                </div>

                <div class="overflow-x-auto border border-gray-200 rounded-lg">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 text-xs text-gray-600 uppercase bg-gray-100/50">
                                <th class="p-3 w-32">Tarikh</th>
                                <th class="p-3">Bahagian / Aras</th>
                                <th class="p-3">Pegawai Bertugas</th>
                                <th class="p-3">No Telefon</th>
                                <th class="p-3">Pegawai Pengganti</th>
                                <th class="p-3 text-center w-28">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($jadualHarian as $jadual)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 font-semibold">{{ \Carbon\Carbon::parse($jadual->tarikh)->format('d/m/Y') }}</td>
                                    <td class="p-3">{{ $jadual->bahagian->kod_bahagian ?? '-' }} <span class="text-gray-400">|</span> Aras {{ $jadual->aras }}</td>
                                    <td class="p-3 font-bold text-purple-900">{{ $jadual->pegawai->name ?? '-' }}</td>
                                    <td class="p-3 text-gray-600">{{ $jadual->no_telefon ?? '-' }}</td>
                                    <td class="p-3 text-gray-500">{{ $jadual->pegawaiGanti->name ?? '-' }}</td>

                                    <!-- BUTANG EDIT & DELETE -->
                                    <td class="p-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Edit -->
                                            <a href="{{ route('pka.jadual.edit', $jadual->id) }}" class="p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition" title="Edit Jadual">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <!-- Padam -->
                                            <form action="{{ route('pka.jadual.destroy', $jadual->id) }}" method="POST" onsubmit="return confirm('Adakah anda pasti untuk memadam jadual harian ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition" title="Padam Jadual">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-400 font-medium">Tiada rekod jadual harian ditemui.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- JADUAL MINGGUAN -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-2 h-6 bg-emerald-500 rounded-full"></div>
                    <h3 class="text-base font-bold text-gray-800 uppercase">Jadual Bertugas (Mingguan)</h3>
                </div>

                <div class="overflow-x-auto border border-gray-200 rounded-lg">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 text-xs text-gray-600 uppercase bg-gray-100/50">
                                <th class="p-3 w-32">Tarikh Mula</th>
                                <th class="p-3">Bahagian / Aras</th>
                                <th class="p-3">Pegawai Bertugas</th>
                                <th class="p-3">No Telefon</th>
                                <th class="p-3">Pegawai Pengganti</th>
                                <th class="p-3 text-center w-28">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($jadualMingguan as $jadual)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 font-semibold">{{ \Carbon\Carbon::parse($jadual->tarikh)->format('d/m/Y') }}</td>
                                    <td class="p-3">{{ $jadual->bahagian->kod_bahagian ?? '-' }} <span class="text-gray-400">|</span> Aras {{ $jadual->aras }}</td>
                                    <td class="p-3 font-bold text-emerald-700">{{ $jadual->pegawai->name ?? '-' }}</td>
                                    <td class="p-3 text-gray-600">{{ $jadual->no_telefon ?? '-' }}</td>
                                    <td class="p-3 text-gray-500">{{ $jadual->pegawaiGanti->name ?? '-' }}</td>

                                    <!-- BUTANG EDIT & DELETE -->
                                    <td class="p-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Edit -->
                                            <a href="{{ route('pka.jadual.edit', $jadual->id) }}" class="p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition" title="Edit Jadual">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <!-- Padam -->
                                            <form action="{{ route('pka.jadual.destroy', $jadual->id) }}" method="POST" onsubmit="return confirm('Adakah anda pasti untuk memadam jadual mingguan ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition" title="Padam Jadual">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-400 font-medium">Tiada rekod jadual mingguan ditemui.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 pb-8">
                {{ $jaduals->links() }}
            </div>

        </div>
    </div>
    <x-footer></x-footer>
</x-app-layout>
