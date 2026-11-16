<script setup>
import { ref, computed } from 'vue'
import { formatTarikh } from '../../Laporan/statusLaporan.js'

// semuaJadual: setiap jadual ada `ada_laporan` (boolean, dari controller)
const props = defineProps({ semuaJadual: { type: Array, default: () => [] } })

const showModal = ref(false)
const ringkas = computed(() => props.semuaJadual.slice(0, 2))
const hariIni = new Date().toLocaleDateString('ms-MY', { day: '2-digit', month: '2-digit', year: 'numeric' })
const ucfirst = (s) => (s ? s.charAt(0).toUpperCase() + s.slice(1) : '')
</script>

<template>
    <div @click="showModal = true" class="bg-white rounded-2xl shadow-lg p-4 cursor-pointer hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4 font-['Poppins']">
            <h2 class="font-bold text-xl">Pegawai Bertugas</h2>
            <span class="text-xs">{{ hariIni }}</span>
        </div>

        <div class="space-y-3">
            <div v-for="j in ringkas" :key="j.id" class="bg-blue-50 p-3">
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs shrink-0">{{ j.ada_laporan ? '✓' : '⏱' }}</div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-blue-700">{{ j.pegawai?.name ?? 'Tiada Pegawai' }}</p>
                        <p class="text-[11px] text-blue-600">{{ j.ada_laporan ? 'Tugasan Selesai' : 'Menunggu tugasan' }}</p>
                    </div>
                    <div class="flex gap-1">
                        <span class="px-3 py-1 rounded-full bg-green-200 text-green-700 text-[9px]">{{ ucfirst(j.jenis) }}</span>
                        <span class="px-2 py-1 rounded-full bg-blue-300 text-blue-700 text-[9px]">6.00pm</span>
                    </div>
                </div>
                <p class="text-[9px] text-right text-gray-500 mt-3">{{ formatTarikh(j.tarikh) }}</p>
            </div>
            <div v-if="!ringkas.length" class="bg-blue-50 p-5 text-center text-xs text-gray-500">Tiada pegawai bertugas</div>
        </div>

        <p v-if="semuaJadual.length > 2" class="text-center text-[10px] text-blue-600 mt-3">Klik untuk lihat semua jadual</p>
    </div>

    <Teleport to="body">
        <div v-if="showModal" @click.self="showModal = false" class="fixed inset-0 z-[999] flex items-center justify-center bg-black/40 px-4">
            <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b">
                    <div>
                        <h2 class="font-bold text-lg text-purple-800">Senarai Pegawai Bertugas</h2>
                        <p class="text-xs text-gray-500">Keseluruhan jadual bertugas</p>
                    </div>
                    <button @click="showModal = false" class="text-gray-500 hover:text-red-500 text-xl">✕</button>
                </div>
                <div class="p-5 max-h-[60vh] overflow-y-auto">
                    <div v-for="j in semuaJadual" :key="j.id" class="bg-blue-50 p-4 mb-3 rounded-xl flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white shrink-0">{{ j.ada_laporan ? '✓' : '⏱' }}</div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-blue-700">{{ j.pegawai?.name ?? 'Tiada Pegawai' }}</p>
                            <p class="text-xs text-blue-600">{{ ucfirst(j.jenis) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-semibold text-gray-700">{{ formatTarikh(j.tarikh) }}</p>
                            <span :class="['text-[9px]', j.ada_laporan ? 'text-green-600' : 'text-orange-600']">{{ j.ada_laporan ? 'Selesai' : 'Menunggu' }}</span>
                        </div>
                    </div>
                    <div v-if="!semuaJadual.length" class="text-center py-10 text-gray-400">Tiada jadual bertugas.</div>
                </div>
            </div>
        </div>
    </Teleport>
</template>
