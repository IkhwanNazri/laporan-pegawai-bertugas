<x-app-layout>
    <div class="py-8 pb-24 min-h-screen bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <x-page-header
                title="Isi Laporan Bertugas"
                :breadcrumbs="[
                    'Jadual' => route('user.jadual.index'),
                    'Isi Laporan' => '#'
                ]"
            />

            @if($jadual)

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mt-4 overflow-hidden">

                    <div class="bg-gray-50 p-6 border-b border-gray-200">

                        <h2 class="text-lg font-bold text-gray-800 text-center uppercase mb-4">
                            Laporan Pegawai Bertugas<br>
                            Kementerian Perpaduan Negara
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">

                            <div>
                                <p>
                                    <span class="font-semibold inline-block w-40">
                                        Bahagian/ Unit:
                                    </span>
                                    {{ $jadual->bahagian->nama_bahagian ?? 'BPM' }}
                                </p>

                                <p>
                                    <span class="font-semibold inline-block w-40">
                                        Nama Pegawai:
                                    </span>
                                    <span class="uppercase">
                                        {{ Auth::user()->name }}
                                    </span>
                                </p>
                            </div>

                            <div>
                                <p>
                                    <span class="font-semibold inline-block w-40">
                                        Aras:
                                    </span>
                                    {{ $jadual->aras }}
                                </p>

                                <p>
                                    <span class="font-semibold inline-block w-40">
                                        Tarikh:
                                    </span>
                                    {{ \Carbon\Carbon::parse($jadual->tarikh)->format('d.m.Y (l)') }}
                                </p>
                            </div>

                        </div>
                    </div>

                    <form action="{{ route('user.laporan.store') }}" method="POST">
                        @csrf

                        <input
                            type="hidden"
                            name="jadual_id"
                            value="{{ $jadual->id }}"
                        >

                        <div class="p-4 sm:p-6">

                            <div class="mb-4">
                                <h3 class="text-base font-bold text-gray-800 uppercase">
                                    Bahagian A
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Senarai Semak Pemeriksaan Oleh Pegawai Bertugas
                                </p>
                            </div>

                            <div class="overflow-x-auto border border-gray-200 rounded-xl">

                                <table class="w-full text-sm border-collapse">

                                    <thead>
                                        <tr class="bg-purple-900 text-white">

                                            <th class="p-3 w-14 text-center font-semibold">
                                                Bil.
                                            </th>

                                            <th class="p-3 text-left font-semibold min-w-[400px]">
                                                Perkara Diperiksa
                                            </th>

                                            <th class="p-3 w-[230px] text-center font-semibold">
                                                Tanda
                                            </th>

                                            <th class="p-3 w-[280px] text-left font-semibold">
                                                Catatan
                                            </th>

                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-200">

                                        @php
                                            $senarai_semak = [
                                                '1' => [
                                                    'Semua pegawai telah meninggalkan pejabat pada jam 6.00 petang.',
                                                    ''
                                                ],
                                                '2' => [
                                                    'Pegawai-pegawai bekerja lebih masa (selepas jam 6.00 petang)',
                                                    ''
                                                ],
                                                '3' => [
                                                    'Pintu-pintu bilik yang berkaitan telah ditutup/dikunci:',
                                                    [
                                                        '(i) Pintu kecemasan (rintangan api)',
                                                        '(ii) Pintu bilik pegawai',
                                                        '(iii) Bilik-bilik lain (stor/ fail dll)'
                                                    ]
                                                ],
                                                '4' => [
                                                    'Suis elektrik di ruang gunasama telah dimatikan:',
                                                    [
                                                        '(i) Lampu-lampu gunasama',
                                                        '(ii) Mesin fotostat/ mesin pejabat'
                                                    ]
                                                ],
                                                '5' => [
                                                    'Workstation (ruang kerja) pegawai:',
                                                    [
                                                        '(i) Suis komputer dimatikan',
                                                        '(ii) Dokumen/ fail terperingkat tidak berada di atas meja'
                                                    ]
                                                ],
                                                '6' => [
                                                    'Bilik mesyuarat/ perbincangan:',
                                                    [
                                                        '(i) Semua suis elektrik dimatikan',
                                                        '(ii) Peralatan makan/ minum dikemaskan selepas mesyuarat'
                                                    ]
                                                ],
                                                '7' => [
                                                    'Bilik pantry:',
                                                    [
                                                        '(i) Paip air telah ditutup',
                                                        '(ii) Suis peralatan elektrik telah dimatikan'
                                                    ]
                                                ],
                                            ];
                                        @endphp

                                        @foreach($senarai_semak as $bil => $item)

                                            <tr class="hover:bg-gray-50 transition-colors">

                                                <td class="p-4 text-center align-top font-semibold text-gray-700 bg-gray-50">
                                                    {{ $bil }}
                                                </td>

                                                @if(is_array($item[1]))

                                                    <td class="p-4 align-top">

                                                        <p class="font-semibold text-gray-800">
                                                            {{ $item[0] }}
                                                        </p>

                                                        <div class="mt-3 space-y-2">

                                                            @foreach($item[1] as $sub)
                                                                <div class="text-gray-600 pl-2">
                                                                    {{ $sub }}
                                                                </div>
                                                            @endforeach

                                                        </div>

                                                    </td>

                                                    <td class="p-4 align-top">

                                                        <div class="space-y-2">

                                                            @foreach($item[1] as $index => $sub)

                                                                @php
                                                                    $field = "status[$bil][$index]";
                                                                @endphp

                                                                <div class="flex items-center justify-center gap-1.5">

                                                                    <input
                                                                        type="hidden"
                                                                        name="status[{{ $bil }}][{{ $index }}]"
                                                                        value=""
                                                                        data-status-input="{{ $field }}"
                                                                    >

                                                                    <button
                                                                        type="button"
                                                                        data-status-button="{{ $field }}"
                                                                        data-status-value="/"
                                                                        onclick="setStatus(this)"
                                                                        class="w-10 h-9 rounded-lg border border-gray-200 bg-gray-50 text-gray-500 text-sm font-semibold hover:bg-green-50 hover:text-green-600 hover:border-green-200 active:scale-95 transition-all duration-200"
                                                                    >
                                                                        /
                                                                    </button>

                                                                    <button
                                                                        type="button"
                                                                        data-status-button="{{ $field }}"
                                                                        data-status-value="X"
                                                                        onclick="setStatus(this)"
                                                                        class="w-10 h-9 rounded-lg border border-gray-200 bg-gray-50 text-gray-500 text-sm font-semibold hover:bg-red-50 hover:text-red-600 hover:border-red-200 active:scale-95 transition-all duration-200"
                                                                    >
                                                                        X
                                                                    </button>

                                                                    <button
                                                                        type="button"
                                                                        data-status-button="{{ $field }}"
                                                                        data-status-value="-"
                                                                        onclick="setStatus(this)"
                                                                        class="w-10 h-9 rounded-lg border border-gray-200 bg-gray-50 text-gray-500 text-sm font-semibold hover:bg-gray-100 hover:text-gray-700 hover:border-gray-300 active:scale-95 transition-all duration-200"
                                                                    >
                                                                        −
                                                                    </button>

                                                                </div>

                                                            @endforeach

                                                        </div>

                                                    </td>

                                                    <td class="p-4 align-top">

                                                        <div class="space-y-2">

                                                            @foreach($item[1] as $index => $sub)

                                                                <input
                                                                    type="text"
                                                                    name="catatan[{{ $bil }}][{{ $index }}]"
                                                                    placeholder="Catatan..."
                                                                    class="w-full h-9 px-3 rounded-lg border border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500 transition"
                                                                >

                                                            @endforeach

                                                        </div>

                                                    </td>

                                                @else

                                                    @php
                                                        $field = "status[$bil]";
                                                    @endphp

                                                    <td class="p-4 align-top font-medium text-gray-800">
                                                        {{ $item[0] }}
                                                    </td>

                                                    <td class="p-4 align-top">

                                                        <input
                                                            type="hidden"
                                                            name="status[{{ $bil }}]"
                                                            value=""
                                                            data-status-input="{{ $field }}"
                                                        >

                                                        <div class="flex justify-center gap-1.5">

                                                            <button
                                                                type="button"
                                                                data-status-button="{{ $field }}"
                                                                data-status-value="/"
                                                                onclick="setStatus(this)"
                                                                class="w-10 h-9 rounded-lg border border-gray-200 bg-gray-50 text-gray-500 text-sm font-semibold hover:bg-green-50 hover:text-green-600 hover:border-green-200 active:scale-95 transition-all duration-200"
                                                            >
                                                                /
                                                            </button>

                                                            <button
                                                                type="button"
                                                                data-status-button="{{ $field }}"
                                                                data-status-value="X"
                                                                onclick="setStatus(this)"
                                                                class="w-10 h-9 rounded-lg border border-gray-200 bg-gray-50 text-gray-500 text-sm font-semibold hover:bg-red-50 hover:text-red-600 hover:border-red-200 active:scale-95 transition-all duration-200"
                                                            >
                                                                X
                                                            </button>

                                                            <button
                                                                type="button"
                                                                data-status-button="{{ $field }}"
                                                                data-status-value="-"
                                                                onclick="setStatus(this)"
                                                                class="w-10 h-9 rounded-lg border border-gray-200 bg-gray-50 text-gray-500 text-sm font-semibold hover:bg-gray-100 hover:text-gray-700 hover:border-gray-300 active:scale-95 transition-all duration-200"
                                                            >
                                                                −
                                                            </button>

                                                        </div>

                                                        <div class="text-xs text-gray-400 text-center mt-2">
                                                            / Ya &nbsp; X Tidak &nbsp; − Tiada
                                                        </div>

                                                    </td>

                                                    <td class="p-4 align-top">

                                                        <input
                                                            type="text"
                                                            name="catatan[{{ $bil }}]"
                                                            placeholder="Nama pegawai / Catatan..."
                                                            class="w-full h-9 px-3 rounded-lg border border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500 transition"
                                                        >

                                                    </td>

                                                @endif

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        </div>

                        <div class="px-6 py-5 border-t border-gray-200 bg-gray-50">

                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Ulasan Keseluruhan Pegawai Bertugas
                            </label>

                            <textarea
                                name="ulasan"
                                rows="3"
                                class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                placeholder="Masukkan ulasan jika ada..."
                            ></textarea>

                        </div>

                        <div class="px-6 py-5 border-t border-gray-200">

                            <div class="mb-4">

                                <h3 class="text-sm font-bold text-gray-800 uppercase">
                                    Bahagian B
                                </h3>

                                <p class="text-xs text-gray-500 mt-1">
                                    Dilengkapkan oleh pegawai terakhir meninggalkan pejabat
                                    <span class="italic">(Pilihan)</span>
                                </p>

                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                <div>

                                    <label class="block text-sm font-medium text-gray-700">
                                        Catatan Tambahan
                                    </label>

                                    <textarea
                                        name="catatan_tambahan"
                                        rows="3"
                                        class="mt-1 block w-full rounded-lg border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500"
                                        placeholder="Catatan tambahan..."
                                    ></textarea>

                                </div>

                                <div>

                                    <label class="block text-sm font-medium text-gray-700">
                                        Nama Pegawai Terakhir
                                    </label>

                                    <input
                                        type="text"
                                        name="nama_pegawai_terakhir"
                                        placeholder="Nama pegawai"
                                        class="mt-1 block w-full h-10 rounded-lg border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500"
                                    >

                                </div>

                            </div>

                        </div>

                        <div class="px-6 py-5 border-t border-gray-200 flex flex-col sm:flex-row justify-end gap-3 bg-white rounded-b-2xl">

                            <a
                                href="{{ route('user.jadual.index') }}"
                                class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium text-center hover:bg-gray-200 transition"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="px-6 py-2.5 bg-purple-900 text-white rounded-lg text-sm font-medium hover:bg-purple-800 transition shadow-sm"
                            >
                                Hantar Laporan
                            </button>

                        </div>

                    </form>

                </div>

            @else

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm mt-5 p-8 text-center">

                    <h2 class="text-base font-semibold text-gray-800">
                        Jadual bertugas tidak ditemui
                    </h2>

                    <p class="text-sm text-gray-500 mt-2">
                        Sila pilih jadual bertugas terlebih dahulu sebelum mengisi laporan.
                    </p>

                    <a
                        href="{{ route('user.jadual.index') }}"
                        class="inline-block mt-5 px-5 py-2.5 bg-purple-900 text-white rounded-lg text-sm font-medium hover:bg-purple-800"
                    >
                        Kembali ke Jadual
                    </a>

                </div>

            @endif

        </div>
    </div>

    <script>
        function setStatus(button) {
            const field = button.dataset.statusButton;
            const value = button.dataset.statusValue;
            const input = document.querySelector(`[data-status-input="${field}"]`);
            const buttons = document.querySelectorAll(`[data-status-button="${field}"]`);

            if (!input) {
                return;
            }

            buttons.forEach(item => {
                item.className = 'w-10 h-9 rounded-lg border border-gray-200 bg-gray-50 text-gray-500 text-sm font-semibold transition-all duration-200';
            });

            if (input.value === value) {
                input.value = '';
                return;
            }

            input.value = value;

            if (value === '/') {
                button.className = 'w-10 h-9 rounded-lg border bg-green-500 text-white border-green-500 text-sm font-semibold shadow-sm transition-all duration-200';
            }

            if (value === 'X') {
                button.className = 'w-10 h-9 rounded-lg border bg-red-500 text-white border-red-500 text-sm font-semibold shadow-sm transition-all duration-200';
            }

            if (value === '-') {
                button.className = 'w-10 h-9 rounded-lg border bg-gray-500 text-white border-gray-500 text-sm font-semibold shadow-sm transition-all duration-200';
            }
        }
    </script>
</x-app-layout>
