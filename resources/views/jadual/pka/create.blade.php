<x-app-layout>


    <div class="py-8 min-h-screen bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px]">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-6 mb-4 ">
                 <div class="w-full">
                    <x-page-header class="" title="Jadual Sistem Pegawai Bertugas" :breadcrumbs="['Jadual' => '#']" />
                </div>

            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">

                <form action="{{ route('pka.jadual.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bahagian</label>
                        <select name="bahagian_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                            <option value="">-- Pilih Bahagian --</option>
                            @foreach($bahagians as $b)
                                <option value="{{ $b->id }}">{{ $b->kod_bahagian }} - {{ $b->nama_bahagian }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pegawai Bertugas</label>
                        <select name="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($pegawais as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->no_ic }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tarikh Tugas</label>
                        <input type="datetime-local" name="tarikh" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Aras</label>
                        <input type="text" name="aras" placeholder="Contoh: Aras 6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No Telefon</label>
                        <input type="text" name="no_telefon" placeholder="Contoh: 012-3456789" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pegawai Ganti (Pilihan)</label>
                        <select name="pegawai_ganti_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="">-- Tiada --</option>
                            @foreach($pegawais as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>



                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('pka.jadual.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-purple-900 text-white rounded-lg hover:bg-purple-800">Simpan Jadual</button>
                    </div>
                </form>
                <span class="text-black text-lg font-medium">Jadual disediakan oleh: Pegawai Keselamatan Aras (PKA)</span>
            </div>
        </div>
    </div>
</x-app-layout>
