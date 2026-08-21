<x-app-layout>
    <div class="py-8 min-h-screen bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px]">
        <div class="w-full px-4 sm:px-6 lg:px-8 space-y-4">

            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-2">
                <div class="w-full">
                    <x-page-header title="Pengurusan Pengguna" :breadcrumbs="['Admin' => '#', 'Pengguna' => '#']" />
                </div>

                <div class="pb-1">
                    <a href="{{ route('pengguna.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 mb-4 bg-purple-900 text-white text-sm font-medium rounded-full hover:bg-purple-800 transition-all shadow-md whitespace-nowrap">
                        + Tambah Pengguna
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 text-sm text-gray-500 uppercase bg-gray-50">
                            <th class="p-3">Nama Lengkap</th>
                            <th class="p-3">No. Kad Pengenalan</th>
                            <th class="p-3">Peranan</th>
                            <th class="p-3">Bahagian</th>
                            <th class="p-3 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 font-semibold text-gray-900">{{ $user->name }}</td>
                                <td class="p-3 text-gray-600">{{ $user->no_ic }}</td>
                                <td class="p-3">
                                    <span class="px-2 py-1 text-xs rounded-full font-semibold
                                        {{ $user->role === 'superadmin' ? 'bg-red-100 text-red-700' :
                                        ($user->role === 'pegawai_keselamatan_aras' ? 'bg-blue-100 text-blue-700' :
                                        ($user->role === 'penolong_pegawai_keselamatan_jabatan' ? 'bg-red-100 text-green-700' :
                                        'bg-gray-100 text-gray-700')) }}">
                                        {{ strtoupper(str_replace('_', ' ', $user->role)) }}
                                    </span>
                                </td>
                                <td class="p-3">{{ $user->bahagian->kod_bahagian ?? '-' }}</td>
                                <td class="p-3 text-right">
                                    <form action="{{ route('pengguna.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Pasti mahu padam pengguna ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-xs">Padam</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-400">Tiada rekod pengguna ditemui.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
