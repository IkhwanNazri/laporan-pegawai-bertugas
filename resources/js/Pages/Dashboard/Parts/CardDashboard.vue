<script setup>
import { formatTarikh } from '../../Laporan/statusLaporan.js'

defineProps({
    jadualDalamProses: { type: Array, default: () => [] },
    laporanDalamProses: { type: Array, default: () => [] },
})

const ucfirst = (s) => (s ? s.charAt(0).toUpperCase() + s.slice(1) : '')
const clock = 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'
const check = 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'
</script>

<template>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 font-['Poppins']">
        <!-- DALAM PROSES -->
        <div class="bg-white rounded-2xl shadow-xl p-4 hover:shadow-md transition">
            <h2 class="font-semibold text-lg text-gray-800 mb-4">Dalam Proses 📈</h2>
            <div class="space-y-4">
                <div v-for="j in jadualDalamProses" :key="j.id" class="bg-purple-50 p-3 border-r-4 border-purple-800 flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-purple-800 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" :d="clock" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-purple-900">Dalam Proses - {{ j.pegawai?.name ?? 'Tiada Pegawai' }}</p>
                        <p class="text-xs text-purple-800 mt-1">Jadual {{ ucfirst(j.jenis) }} - {{ formatTarikh(j.tarikh) }}</p>
                    </div>
                </div>
                <div v-if="!jadualDalamProses.length" class="bg-purple-50 p-4 text-center rounded-lg">
                    <svg class="w-6 h-6 mx-auto text-green-600 mb-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" :d="check" /></svg>
                    <p class="text-xs font-semibold text-gray-500">Tiada jadual dalam proses</p>
                </div>
            </div>
            <a href="/pka/jadual" class="inline-block mt-3 px-7 py-1 rounded-full bg-purple-700 text-white text-xs">View All</a>
        </div>

        <!-- LAPORAN -->
        <div class="bg-white rounded-2xl shadow-xl p-4 hover:shadow-md transition">
            <h2 class="font-semibold text-lg text-gray-800 mb-4">Laporan 📋</h2>
            <div class="space-y-4">
                <div v-for="l in laporanDalamProses" :key="l.id" class="bg-purple-50 p-3 border-r-4 border-purple-800 flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-purple-800 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" :d="clock" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-purple-900">Dalam Proses - {{ l.jadual?.pegawai?.name ?? 'Tiada Pegawai' }}</p>
                        <p class="text-xs text-purple-800 mt-1">Menunggu pengesahan PKA</p>
                    </div>
                </div>
                <div v-if="!laporanDalamProses.length" class="bg-purple-50 p-4 text-center rounded-lg">
                    <svg class="w-6 h-6 mx-auto text-green-600 mb-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" :d="check" /></svg>
                    <p class="text-xs font-semibold text-gray-500">Tiada laporan dalam proses</p>
                </div>
            </div>
            <a href="/pka/laporan" class="inline-block mt-5 px-7 py-1 rounded-full bg-purple-700 text-white text-xs">View All</a>
        </div>
    </div>
</template>
