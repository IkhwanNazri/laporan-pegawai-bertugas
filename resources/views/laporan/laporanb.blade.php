<x-app-layout>
    <div class="py-8 min-h-screen bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px]">
        <div class="max-w-full mx-auto px-4 p-4 sm:px-6 lg:px-8">

            <x-page-header title="Lampiran" :breadcrumbs="['Lampiran A' => route('laporan.index'), 'Lampiran' => '#']" />


            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mt-4 overflow-hidden">

                <!-- Header Maklumat (Auto-fill dari database) -->
                <div class="bg-gray-50 p-6 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-800 text-center uppercase mb-4">Laporan Pegawai Bertugas<br>Kementerian Perpaduan Negara</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                        <div>
                            <p><span class="font-semibold inline-block w-40">Bahagian/ Unit:</span> {{ $jadual->bahagian->nama_bahagian ?? 'BPM' }}</p>
                            <p><span class="font-semibold inline-block w-40">Nama Pegawai:</span> <span class="uppercase">{{ Auth::user()->name }}</span></p>
                        </div>

                    </div>
                </div>


                @if($jadual)
                <form action="{{ route('laporan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="jadual_id" value="{{ $jadual->id }}">

                    <div class="p-3 overflow-x-auto">
                        <h1>saya</h1>
                    </div>





                    <div class="p-6 border-t border-gray-200 flex justify-end gap-3 bg-white rounded-b-2xl">
                        <a href="{{ route('laporan.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition">Batal</a>
                        <button type="submit" class="px-5 py-2.5 bg-purple-900 text-white rounded-lg text-sm font-medium hover:bg-purple-800 transition shadow-md">Teruskan</button>
                    </div>

                </form>
                @else

                <div class="p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded mb-4">
                    <p>Sila pilih jadual dari <a href="{{ route('laporan.index') }}" class="font-bold underline text-blue-600">Senarai Laporan Biasa</a> terlebih dahulu sebelum mengisi Lampiran B.</p>
                </div>
            @endif
            </div>

        </div>
    </div>
</x-app-layout>
