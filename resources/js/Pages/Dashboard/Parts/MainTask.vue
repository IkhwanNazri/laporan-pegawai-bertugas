<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import Pagination from '../../Components/Pagination.vue'
import { formatTarikh } from '../../Laporan/statusLaporan.js'

// jaduals: paginator; setiap jadual ada `progress` (dikira di controller)
defineProps({ jaduals: { type: Object, default: () => ({ data: [], links: [] }) } })

const openMenu = ref(null)
const ucfirst = (s) => (s ? s.charAt(0).toUpperCase() + s.slice(1) : '')

const status = (p) =>
    p >= 100 ? { text: 'Selesai', class: 'bg-green-400 text-black' }
    : p > 0 ? { text: 'Dalam Proses', class: 'bg-yellow-300 text-black' }
    : { text: 'Menunggu', class: 'bg-pink-500 text-white' }

const emel = (id) => {
    openMenu.value = null
    router.post(`/pka/jadual/${id}/reminder`, {}, { preserveScroll: true })
}
</script>

<template>
    <div class="font-['Poppins']">
        <div class="flex items-center justify-between mb-3 px-1">
            <h2 class="text-2xl font-bold">Main Task 📋</h2>
            <a href="/pka/jadual" class="px-7 py-1 rounded-full bg-purple-700 text-white text-xs">View All</a>
        </div>

        <div v-for="(j, i) in jaduals.data" :key="j.id" class="relative bg-white rounded-full shadow-lg px-4 py-3 mb-4 flex items-center gap-5">
            <div class="w-9 h-9 rounded-full bg-black flex items-center justify-center shrink-0 text-white text-sm">👤</div>
            <div class="w-24 font-bold text-sm truncate">{{ j.pegawai?.name ?? 'Tiada Pegawai' }}</div>
            <div class="flex-1 text-blue-700 text-sm">{{ ucfirst(j.jenis) }}</div>
            <div class="flex-1 text-blue-700 text-sm">{{ formatTarikh(j.tarikh) }}</div>
            <div class="w-28">
                <div class="text-[10px] text-gray-500 mb-1">Progress {{ j.progress }}%</div>
                <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-purple-600 rounded-full" :style="{ width: j.progress + '%' }"></div>
                </div>
            </div>
            <span :class="['px-5 py-2 text-xs rounded-lg whitespace-nowrap', status(j.progress).class]">{{ status(j.progress).text }}</span>
            <button @click="openMenu = openMenu === i ? null : i" class="text-blue-600 text-lg px-2">⋮</button>

            <div v-if="openMenu === i" class="absolute right-5 top-14 z-50 w-48 bg-white rounded-xl shadow-xl border border-gray-200 p-2">
                <div class="px-3 py-2 text-xs font-semibold text-gray-500 border-b">Ingatkan Pegawai</div>
                <button v-if="j.pegawai?.email" @click="emel(j.id)" class="w-full text-left px-3 py-2 text-sm hover:bg-purple-50 rounded-lg">Emel Pegawai</button>
                <p v-else class="px-3 py-2 text-xs text-gray-400">Tiada emel</p>
            </div>
        </div>

        <div v-if="!jaduals.data.length" class="bg-white rounded-3xl p-6 text-center text-gray-400">Tiada jadual bertugas.</div>

        <div class="flex justify-center"><Pagination :links="jaduals.links" /></div>
    </div>
</template>
