<x-app-layout>
    <div class="py-8 min-h-screen bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px]">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">

            <x-page-header title="Tambah Pengguna Baru" :breadcrumbs="['Admin' => '#', 'Pengguna' => route('pengguna.index'), 'Tambah' => '#']" />

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mt-4">
                <form action="{{ route('pengguna.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Penuh</label>
                        <input type="text" name="name" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. Kad Pengenalan</label>
                        <input type="text" name="no_ic" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kata Laluan</label>
                        <input type="password" name="password" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Peranan (Role)</label>
                            <select name="role" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                                <option value="pegawai_bertugas">Pegawai Bertugas</option>
                                <option value="pegawai_keselamatan_aras">Pegawai Keselamatan Aras(PKA)</option>
                                <option value="ppkj">Penolong Pegawai Keselamatan Jabatan(PPKJ)</option>

                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bahagian</label>
                            <select name="bahagian_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                                <option value="">-- Pilih Bahagian --</option>
                                @foreach(\App\Models\Bahagian::all() as $b)
                                    <option value="{{ $b->id }}">{{ $b->kod_bahagian }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('pengguna.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-purple-900 text-white rounded-lg text-sm hover:bg-purple-800 transition">Simpan Pengguna</button>
                    </div>
                </form>
                @if($errors->any())
    <div class="p-4 mb-4 text-red-700 bg-red-100 rounded-lg">
        <ul>
            @foreach($errors->all() as $error)
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            </div>

        </div>
    </div>
</x-app-layout>
