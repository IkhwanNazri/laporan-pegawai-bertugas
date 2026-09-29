<x-app-layout>
    <div class="py-8 min-h-screen bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px]">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-6 mb-4">
                 <div class="w-full">
                    <x-page-header class="" title="Jadual Sistem Pegawai Bertugas (Mingguan)" :breadcrumbs="['Jadual' => route('pka.jadual.mingguan'), 'Mingguan' => '#']" />
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                @if ($errors->any())
                    <div class="p-4 mb-4 bg-red-100 border border-red-400 text-red-700 rounded-xl">
                        <strong class="font-bold">Alamak! Ada masalah input:</strong>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

               @if(session('error'))
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                    {!! session('error') !!}
                </div>
            @endif

                <form action="{{ route('pka.jadual.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bahagian / Unit</label>
                            <select name="bahagian_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                                <option value="">-- Pilih Bahagian --</option>
                                @foreach($bahagians as $b)
                                    <option value="{{ $b->id }}">{{ $b->kod_bahagian }} - {{ $b->nama_bahagian }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Aras</label>
                            <input type="text" name="aras" placeholder="Contoh: Aras 6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bulan & Tahun</label>
                            <input type="month" id="bulan_input" name="bulan" value="{{ date('Y-m') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Minggu Bertugas
                                <span class="text-xs text-purple-600 font-semibold">(Auto Detect)</span>
                            </label>
                            <select id="minggu_select" name="minggu" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50" required>
                                <option value="">-- Pilih Minggu --</option>
                                <option value="Minggu 1">Minggu 1</option>
                                <option value="Minggu 2">Minggu 2</option>
                                <option value="Minggu 3">Minggu 3</option>
                                <option value="Minggu 4">Minggu 4</option>
                                <option value="Minggu 5">Minggu 5</option>
                            </select>
                        </div>
                    </div>

                    <!-- BAHAGIAN TARIKH AUTOMATIK -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Tarikh Mula (Isnin)
                                <span class="text-xs text-purple-600 font-semibold">(Auto Set Isnin)</span>
                            </label>
                            <input type="date" id="tarikh_mula" name="tarikh_mula" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Tarikh Tamat (Jumaat)
                                <span class="text-xs text-emerald-600 font-semibold">(Auto Kira +4 Hari)</span>
                            </label>
                            <input type="date" id="tarikh_tamat" name="tarikh_tamat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-gray-50" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                            <label class="block text-sm font-medium text-gray-700">No Telefon</label>
                            <input type="text" name="no_telefon" placeholder="Contoh: 012-3456789" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                        </div>
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

                    <input type="hidden" name="jenis" value="mingguan">

                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('pka.jadual.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-purple-900 text-white rounded-lg hover:bg-purple-800">Simpan Jadual Mingguan</button>
                    </div>
                </form>

                <div class="mt-6 border-t pt-4">
                    <span class="text-black text-lg font-medium">Jadual disediakan oleh: Pegawai Keselamatan Aras (PKA)</span>
                </div>
            </div>
        </div>
    </div>
    <x-footer></x-footer>

    <!-- JAVASCRIPT UNTUK AUTO KIRA, AUTO PICK HARINI & AUTO PICK MINGGU -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputMula = document.getElementById('tarikh_mula');
            const inputTamat = document.getElementById('tarikh_tamat');
            const inputBulan = document.getElementById('bulan_input');
            const selectMinggu = document.getElementById('minggu_select');

            // Format tarikh ke YYYY-MM-DD
            function formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            // Kira nombor minggu dalam bulan tersebut berdasarkan hari Isnin
            function calculateWeekOfMonth(date) {
                const dayOfMonth = date.getDate();
                const weekNumber = Math.ceil(dayOfMonth / 7);
                return Math.min(weekNumber, 5); // Maksimum Minggu 5
            }

            // Kemas kini keseluruhan medan automatik apabila tarikh mula bertukar
            function updateAllAutoFields(tarikhMulaStr) {
                if (!tarikhMulaStr) return;

                const tarikhMula = new Date(tarikhMulaStr);

                // 1. Auto Kira Tarikh Tamat (+4 hari ke Jumaat)
                const tarikhTamat = new Date(tarikhMula);
                tarikhTamat.setDate(tarikhMula.getDate() + 4);
                inputTamat.value = formatDate(tarikhTamat);

                // 2. Auto Select Bulan & Tahun
                const bulan = String(tarikhMula.getMonth() + 1).padStart(2, '0');
                const tahun = tarikhMula.getFullYear();
                inputBulan.value = `${tahun}-${bulan}`;

                // 3. AUTO PICK MINGGU BERTUGAS (Minggu 1 hingga Minggu 5)
                const mingguNum = calculateWeekOfMonth(tarikhMula);
                selectMinggu.value = `Minggu ${mingguNum}`;
            }

            // DEFAULT: SET UNTUK ISNIN MINGGU INI APABILA MULA DIBUKA
            const today = new Date();
            const dayOfWeek = today.getDay(); // 0 (Ahad) hingga 6 (Sabtu)

            // Cari hari Isnin minggu semasa
            const distanceToMonday = (dayOfWeek === 0 ? -6 : 1 - dayOfWeek);
            const mondayThisWeek = new Date(today);
            mondayThisWeek.setDate(today.getDate() + distanceToMonday);

            // Set nilai awal & jalankan auto-select
            inputMula.value = formatDate(mondayThisWeek);
            updateAllAutoFields(inputMula.value);

            // TUKAR AUTOMATIK BILA USER PILIH TARIKH MULA BAHARU
            inputMula.addEventListener('change', function () {
                updateAllAutoFields(this.value);
            });
        });
    </script>
</x-app-layout>
