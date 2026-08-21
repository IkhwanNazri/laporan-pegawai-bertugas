<x-app-layout>
    <div class="py-8 min-h-screen bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px]">
        <div class="max-w-full mx-auto px-4 p-4 sm:px-6 lg:px-8">

            <x-page-header title="Isi Laporan Bertugas" :breadcrumbs="['Jadual' => route('jadual.pka'), 'Isi Laporan' => '#']" />

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mt-4 overflow-hidden">


                <div class="bg-gray-50 p-6 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-800 text-center uppercase mb-4">Laporan Pegawai Bertugas<br>Kementerian Perpaduan Negara</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                        <div>
                            <p><span class="font-semibold inline-block w-40">Bahagian/ Unit:</span> {{ $jadual->bahagian->nama_bahagian ?? 'BPM' }}</p>
                            <p><span class="font-semibold inline-block w-40">Nama Pegawai:</span> <span class="uppercase">{{ Auth::user()->name }}</span></p>
                        </div>
                        <div>
                            <p><span class="font-semibold inline-block w-40">Aras:</span> {{ $jadual->aras }}</p>
                            <p><span class="font-semibold inline-block w-40">Tarikh:</span> {{ \Carbon\Carbon::parse($jadual->tarikh)->format('d.m.Y (l)') }}</p>
                        </div>
                    </div>
                </div>


                <form action="{{ route('laporan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="jadual_id" value="{{ $jadual->id }}">

                    <div class="p-3 overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-purple-900 text-white text-sm">
                                    <th colspan="4" class="p-3 font-semibold uppercase">Bahagian A : Senarai Semak Pemeriksaan Oleh Pegawai Bertugas</th>
                                </tr>
                                <tr class="bg-gray-100 text-sm text-gray-700 border-b border-gray-200">
                                    <th class="p-3 w-12 text-center border-r border-gray-200">BIL</th>
                                    <th class="p-3 border-r border-gray-200">PERKARA DIPERIKSA</th>
                                    <th class="p-3 w-40 text-center border-r border-gray-200">TANDA ( / , X , - )</th>
                                    <th class="p-3 w-64">CATATAN</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-sm align-top">

                                @php
                                    $senarai_semak = [
                                        '1' => ['Semua pegawai telah meninggalkan pejabat pada jam 6.00 petang.', ''],
                                        '2' => ['Pegawai-pegawai bekerja lebih masa (selepas jam 6.00 petang)', ''],
                                        '3' => ['Pintu-pintu bilik yang berkaitan telah ditutup/dikunci:', ['(i) Pintu kecemasan (rintangan api)', '(ii) Pintu bilik pegawai', '(iii) Bilik-bilik lain (stor/ fail dll)']],
                                        '4' => ['Suis elektrik di ruang gunasama telah dimatikan:', ['(i) Lampu-lampu gunasama', '(ii) Mesin fotostat/ mesin pejabat']],
                                        '5' => ['Workstation (ruang kerja) pegawai:', ['(i) Suis komputer dimatikan', '(ii) Dokumen/ fail terperingkat tidak berada di atas meja']],
                                        '6' => ['Bilik mesyuarat/ perbincangan:', ['(i) Semua suis elektrik dimatikan', '(ii) Peralatan makan/ minum dikemaskan selepas mesyuarat']],
                                        '7' => ['Bilik pantry:', ['(i) Paip air telah ditutup', '(ii) Suis peralatan elektrik telah dimatikan']],
                                    ];
                                @endphp

                                @foreach($senarai_semak as $bil => $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-3 text-center border-r border-gray-200 font-medium">{{ $bil }}.</td>

                                        @if(is_array($item[1]))

                                            <td class="p-3 border-r border-gray-200">
                                                <p class="font-medium mb-2">{{ $item[0] }}</p>
                                                <div class="space-y-3">
                                                    @foreach($item[1] as $index => $sub)
                                                        <p class="text-gray-600 pl-4">{{ $sub }}</p>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="p-3 border-r border-gray-200 space-y-2">
                                                <div class="mt-8 space-y-3">
                                                    @foreach($item[1] as $index => $sub)
                                                        <select name="status[{{ $bil }}][{{ $index }}]" class="block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                                            <option value="/">/ (Ya)</option>
                                                            <option value="X">X (Tidak)</option>
                                                            <option value="-">- (Tiada)</option>
                                                        </select>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="p-3 space-y-2">
                                                <div class="mt-8 space-y-3">
                                                    @foreach($item[1] as $index => $sub)
                                                        <input type="text" name="catatan[{{ $bil }}][{{ $index }}]" placeholder="Catatan..." class="block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                                    @endforeach
                                                </div>
                                            </td>
                                        @else

                                            <td class="p-3 border-r border-gray-200 font-medium">{{ $item[0] }}</td>
                                            <td class="p-3 border-r border-gray-200">
                                                <select name="status[{{ $bil }}]" class="block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                                    <option value="/">/ (Ya)</option>
                                                    <option value="X">X (Tidak)</option>
                                                    <option value="-">- (Tiada)</option>
                                                </select>
                                            </td>
                                            <td class="p-3">
                                                <input type="text" name="catatan[{{ $bil }}]" placeholder="Nama pegawai / Catatan..." class="block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>


                    <div class="p-6 border-t border-gray-200 bg-gray-50">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Ulasan Keseluruhan Pegawai Bertugas:</label>
                        <textarea name="ulasan" rows="3" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm" placeholder="Contoh: Selain yang dinyatakan di dalam catatan di atas, semua peraturan berkaitan keselamatan pejabat dipatuhi..."></textarea>
                    </div>


                    <div class="p-6 border-t border-gray-200">
                        <h3 class="text-sm font-bold text-gray-800 mb-3 uppercase">Bahagian B : Dilengkapkan oleh pegawai terakhir meninggalkan pejabat (Pilihan)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Catatan Tambahan</label>
                                <textarea name="catatan_tambahan" rows="2" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm" placeholder="Catatan pegawai terakhir keluar..."></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Pegawai Terakhir</label>
                                <input type="text" name="nama_pegawai_terakhir" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm" placeholder="Contoh: Ayu Binti Mayuni">
                            </div>
                        </div>
                    </div>


                    <div class="p-6 border-t border-gray-200 flex justify-end gap-3 bg-white rounded-b-2xl">
                        <a href="{{ route('jadual.pka') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition">Batal</a>
                        <button type="submit" class="px-5 py-2.5 bg-purple-900 text-white rounded-lg text-sm font-medium hover:bg-purple-800 transition shadow-md">Hantar Laporan</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
