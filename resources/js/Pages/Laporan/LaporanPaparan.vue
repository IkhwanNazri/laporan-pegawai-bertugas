<script setup>
// Paparan laporan (baca sahaja) — susun atur sama seperti borang laporan sebenar
import { senaraiSemak, tarikhLaporan } from './senaraiSemak.js'

const props = defineProps({
    jadual: { type: Object, required: true }, // jadual dengan laporan, pegawai, bahagian
})

const laporan = () => props.jadual.laporan ?? {}
const status = (bil, i) => {
    const v = laporan().senarai_semak?.status?.[bil]
    return (i === null ? v : v?.[i]) || ''
}
const catatan = (bil, i) => {
    const v = laporan().senarai_semak?.catatan?.[bil]
    return (i === null ? v : v?.[i]) || ''
}
const warna = { '/': 'bg-green-500 text-white border-green-500', X: 'bg-red-500 text-white border-red-500', '-': 'bg-gray-500 text-white border-gray-500' }
</script>

<template>
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden text-sm">
        <div class="bg-gray-50 p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 text-center uppercase mb-4">Laporan Pegawai Bertugas<br>Kementerian Perpaduan Negara</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-gray-700">
                <p><span class="font-semibold inline-block w-40">Bahagian/ Unit:</span>{{ jadual.bahagian?.nama_bahagian ?? '-' }}</p>
                <p><span class="font-semibold inline-block w-40">Aras:</span>{{ jadual.aras ?? '-' }}</p>
                <p><span class="font-semibold inline-block w-40">Nama Pegawai:</span><span class="uppercase">{{ jadual.pegawai?.name ?? '-' }}</span></p>
                <p><span class="font-semibold inline-block w-40">Tarikh:</span>{{ tarikhLaporan(jadual.tarikh) }}</p>
                <p><span class="font-semibold inline-block w-40">Kod Laporan:</span>{{ laporan().kod_laporan ?? '-' }}</p>
            </div>
        </div>

        <div class="p-4 sm:p-6">
            <h3 class="text-base font-bold text-gray-800 uppercase">Bahagian A</h3>
            <p class="text-sm text-gray-500 mt-1 mb-4">Senarai Semak Pemeriksaan Oleh Pegawai Bertugas</p>

            <div class="overflow-x-auto border border-gray-200 rounded-xl">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-purple-900 text-white">
                            <th class="p-3 w-14 text-center">Bil.</th>
                            <th class="p-3 text-left">Perkara Diperiksa</th>
                            <th class="p-3 w-24 text-center">Tanda</th>
                            <th class="p-3 w-56 text-left">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="([perkara, sub], bil) in senaraiSemak" :key="bil">
                            <td class="p-3 text-center align-top font-semibold bg-gray-50">{{ bil }}</td>
                            <td class="p-3 align-top">
                                <p class="font-medium text-gray-800">{{ perkara }}</p>
                                <div v-if="sub" class="mt-2 space-y-2">
                                    <div v-for="s in sub" :key="s" class="text-gray-600 pl-2 h-8 flex items-center">{{ s }}</div>
                                </div>
                            </td>
                            <td class="p-3 align-top">
                                <div :class="sub ? 'mt-8 space-y-2' : ''">
                                    <div v-for="i in (sub ? sub.map((_, n) => n) : [null])" :key="String(i)" class="h-8 flex items-center justify-center">
                                        <span :class="['w-10 h-8 rounded-lg border flex items-center justify-center font-semibold', warna[status(bil, i)] ?? 'border-gray-200 text-gray-300']">
                                            {{ status(bil, i) || '·' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-3 align-top text-gray-700">
                                <div :class="sub ? 'mt-8 space-y-2' : ''">
                                    <div v-for="i in (sub ? sub.map((_, n) => n) : [null])" :key="String(i)" class="h-8 flex items-center">{{ catatan(bil, i) || '-' }}</div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="text-xs text-gray-400 mt-2">/ Ya &nbsp; X Tidak &nbsp; − Tiada</p>
        </div>

        <div class="px-6 py-5 border-t border-gray-200 bg-gray-50">
            <p class="font-bold text-gray-700 mb-1">Ulasan Keseluruhan Pegawai Bertugas</p>
            <p class="text-gray-700 whitespace-pre-line">{{ laporan().ulasan || '-' }}</p>
        </div>

        <div class="px-6 py-5 border-t border-gray-200">
            <h3 class="font-bold text-gray-800 uppercase">Bahagian B</h3>
            <p class="text-xs text-gray-500 mt-1 mb-3">Dilengkapkan oleh pegawai terakhir meninggalkan pejabat</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><p class="text-xs text-gray-500">Catatan Tambahan</p><p class="text-gray-800 whitespace-pre-line">{{ laporan().catatan_tambahan || '-' }}</p></div>
                <div><p class="text-xs text-gray-500">Nama Pegawai Terakhir</p><p class="text-gray-800">{{ laporan().nama_pegawai_terakhir || '-' }}</p></div>
            </div>
        </div>

        <div v-if="laporan().ulasan_ppkj" class="px-6 py-5 border-t border-gray-200 bg-blue-50/50">
            <h3 class="font-bold text-gray-800 uppercase">Bahagian C</h3>
            <p class="text-xs text-gray-500 mt-1 mb-2">Ulasan PPKJ</p>
            <p class="text-gray-800 italic">"{{ laporan().ulasan_ppkj }}"</p>
        </div>
    </div>
</template>
