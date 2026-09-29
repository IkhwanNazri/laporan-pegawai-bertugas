<x-app-layout>
    <div class="py-8 min-h-screen bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <x-page-header title="Pengurusan Bahagian" :breadcrumbs="['Bahagian' => '#']" />

            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="md:col-span-1">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-4">Tambah Bahagian Baru</h3>
                        <form action="{{ route('admin.bahagian.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kod Bahagian (Cth: BPM)</label>
                                <input type="text" name="kod_bahagian" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 uppercase" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Penuh Bahagian</label>
                                <input type="text" name="nama_bahagian" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                            </div>
                            <button type="submit" class="w-full py-2 bg-purple-900 text-white rounded-lg text-sm font-medium hover:bg-purple-800 transition">
                                Simpan Data
                            </button>
                        </form>
                    </div>
                </div>


                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 text-sm text-gray-500 uppercase bg-gray-50">
                                    <th class="p-3">Kod</th>
                                    <th class="p-3">Nama Bahagian</th>
                                    <th class="p-3 text-right">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($bahagians as $bahagian)
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-3 font-semibold text-purple-900">{{ $bahagian->kod_bahagian }}</td>
                                        <td class="p-3 text-gray-700">{{ $bahagian->nama_bahagian }}</td>
                                        <td class="p-3 text-right">
                                            <x-delete-popup :action="route('admin.bahagian.destroy', $bahagian->id)" />

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="p-4 text-center text-gray-400">Tiada rekod bahagian ditemui.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4">{{ $bahagians->links() }}</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
