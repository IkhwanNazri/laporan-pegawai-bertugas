<script setup>
import { ref } from 'vue'
import { formatTarikh } from '../../Laporan/statusLaporan.js'
import LaporanPaparan from '../../Laporan/LaporanPaparan.vue'

defineProps({
    recent: { type: Array, default: () => [] },
    history: { type: Array, default: () => [] },
})

const selected = ref(null)
const ucfirst = (s) => (s ? s.charAt(0).toUpperCase() + s.slice(1) : '')
const isMingguan = (j) => (j.jenis ?? 'harian').toLowerCase() === 'mingguan'

const julatTarikh = (j) => {
    if (!isMingguan(j)) return formatTarikh(j.tarikh)
    const akhir = new Date(j.tarikh)
    akhir.setDate(akhir.getDate() + 6)
    return `${formatTarikh(j.tarikh)} - ${formatTarikh(akhir)}`
}

const status = (j) =>
    j.laporan?.status_tindakan_pka === 'menunggu_pka'
        ? { text: 'Menunggu PKA', class: 'bg-yellow-300 text-black', progress: 75 }
        : { text: 'Menunggu', class: 'bg-pink-500 text-white', progress: 50 }

</script>

<template>
    <div class="font-['Poppins']">
        <h2 class="text-2xl font-bold mb-3 px-1">Main Task 📋</h2>

        <!-- RECENT -->
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-3 px-1">
                <h3 class="text-lg font-bold text-gray-800">Recent</h3>
                <span class="px-2 py-1 text-xs font-semibold bg-purple-100 text-purple-700 rounded-full">{{ recent.length }}</span>
            </div>

            <div v-for="j in recent" :key="j.id" class="bg-white rounded-xl shadow-lg px-4 py-3 mb-4 flex items-center gap-5">
                <div class="w-9 h-9 rounded-full bg-black flex items-center justify-center shrink-0 text-white">👤</div>
                <div class="w-32 shrink-0">
                    <div class="font-semibold text-sm text-gray-800">{{ j.pegawai?.name ?? 'Tiada Pegawai' }}</div>
                    <div class="text-xs text-gray-500">{{ ucfirst(j.jenis) }}</div>
                </div>
                <div class="flex-1 text-sm text-blue-700">{{ julatTarikh(j) }}</div>
                <div class="w-28 shrink-0">
                    <div class="text-[10px] text-gray-500 mb-1">Progress {{ status(j).progress }}%</div>
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-purple-600 rounded-full" :style="{ width: status(j).progress + '%' }"></div>
                    </div>
                </div>
                <span :class="['px-3 py-1.5 text-xs font-medium rounded-lg whitespace-nowrap', status(j).class]">{{ status(j).text }}</span>
                <button @click="selected = j" class="px-3 py-1.5 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg">View</button>
                <a href="/ppkj/pengesahan" class="text-blue-600 text-lg px-2 hover:text-blue-800">→</a>
            </div>
            <div v-if="!recent.length" class="bg-white rounded-xl shadow-sm p-5 text-center text-gray-400">Tiada laporan terkini.</div>
        </div>

        <!-- HISTORY -->
        <div>
            <div class="flex items-center gap-2 mb-3 px-1">
                <h3 class="text-lg font-bold text-gray-800">History</h3>
                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">{{ history.length }}</span>
            </div>

            <div v-for="j in history" :key="j.id" class="bg-white rounded-xl shadow-lg px-4 py-3 mb-4 flex items-center gap-5">
                <div class="w-9 h-9 rounded-full bg-green-500 flex items-center justify-center shrink-0 text-white">✓</div>
                <div class="w-32 shrink-0">
                    <div class="font-semibold text-sm text-gray-800">{{ j.pegawai?.name ?? 'Tiada Pegawai' }}</div>
                    <div class="text-xs text-gray-500">{{ ucfirst(j.jenis) }}</div>
                </div>
                <div class="flex-1 text-sm text-blue-700">{{ julatTarikh(j) }}</div>
                <div class="w-28 shrink-0">
                    <div class="text-[10px] text-gray-500 mb-1">Progress 100%</div>
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden"><div class="h-full bg-purple-600 rounded-full w-full"></div></div>
                </div>
                <span class="px-3 py-1.5 text-xs font-medium bg-green-400 text-black rounded-lg whitespace-nowrap">✓ Selesai</span>
                <button @click="selected = j" class="px-3 py-1.5 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg">View</button>
            </div>
            <div v-if="!history.length" class="bg-white rounded-xl shadow-sm p-5 text-center text-gray-400">Tiada history.</div>
        </div>
    </div>

    <!-- MODAL LAPORAN -->
    <Teleport to="body">
        <div v-if="selected" class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50" @click="selected = null"></div>
            <div class="relative w-full max-w-3xl max-h-[90vh] overflow-y-auto bg-white rounded-2xl shadow-2xl">
                <div class="sticky top-0 flex items-center justify-between px-6 py-4 bg-white border-b">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Laporan Pegawai</h3>
                        <p class="text-xs text-gray-500 mt-1">{{ selected.laporan?.kod_laporan ?? '-' }}</p>
                    </div>
                    <button @click="selected = null" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600">✕</button>
                </div>

                <div class="p-6 space-y-5">
                    <LaporanPaparan :jadual="selected" />

                    <div class="flex justify-end pt-2 border-t">
                        <a href="/ppkj/pengesahan" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-lg">Pergi Pengesahan</a>
                    </div>
                </div>
            </div>
        </div>
    </Teleport>
</template>
