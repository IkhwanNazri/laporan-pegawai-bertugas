<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import LaporanPaparan from '../Laporan/LaporanPaparan.vue'
import AppLayout from '../../Layouts/AppLayout.vue'
import Pagination from '../Components/Pagination.vue'
import { formatTarikh } from '../Laporan/statusLaporan.js'

defineProps({ laporans: Object })

const forms = {}
const ulasanForm = (id) => (forms[id] ??= useForm({ ulasan_ppkj: '' }))
// Laporan dipilih untuk paparan penuh (format sama seperti borang)
const dilihat = ref(null)
const lihat = (l) => (dilihat.value = { ...l.jadual, laporan: l })

const sahkan = (id) => ulasanForm(id).post(`/ppkj/pengesahan/${id}`, { preserveScroll: true })
</script>

<template>
    <AppLayout title="Semakan Akhir PPKJ (Bahagian C)">
        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 text-sm text-gray-500 uppercase bg-gray-50">
                            <th class="p-3">Maklumat Laporan</th>
                            <th class="p-3">Ulasan Pegawai</th>
                            <th class="p-3 w-1/3">Tindakan / Ulasan PPKJ (Bahagian C)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <tr v-for="l in laporans.data" :key="l.id" class="hover:bg-gray-50 align-top">
                            <td class="p-3">
                                <p class="font-bold text-purple-900 mb-1">{{ l.kod_laporan }}</p>
                                <p class="text-gray-600">Tarikh: <span class="font-semibold">{{ formatTarikh(l.jadual?.tarikh) }}</span></p>
                                <p class="text-gray-600">Aras: <span class="font-semibold">{{ l.jadual?.aras ?? '-' }}</span></p>
                                <p class="text-gray-600">Pegawai: <span class="font-semibold uppercase">{{ l.jadual?.pegawai?.name ?? '-' }}</span></p>
                                <button @click="lihat(l)" class="mt-2 px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg">Lihat Laporan</button>
                            </td>
                            <td class="p-3 text-gray-700">
                                <p class="italic">"{{ l.ulasan ?? 'Tiada ulasan ditinggalkan.' }}"</p>
                                <p class="mt-2 text-xs text-blue-600 font-bold">✓ Telah disahkan oleh PKA (Penyelia)</p>
                            </td>
                            <td class="p-3">
                                <form v-if="!l.ulasan_ppkj" @submit.prevent="sahkan(l.id)" class="space-y-2">
                                    <textarea v-model="ulasanForm(l.id).ulasan_ppkj" rows="2" required
                                        class="w-full text-xs rounded-lg border-gray-300 p-2" placeholder="Masukkan ulasan PPKJ..." />
                                    <p v-if="ulasanForm(l.id).errors.ulasan_ppkj" class="text-xs text-red-600">{{ ulasanForm(l.id).errors.ulasan_ppkj }}</p>
                                    <button type="submit" :disabled="ulasanForm(l.id).processing"
                                        class="px-3 py-1.5 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 disabled:opacity-50">
                                        Sahkan Laporan
                                    </button>
                                </form>
                                <div v-else class="text-xs text-gray-700 bg-gray-50 p-2 rounded border">
                                    <p class="font-semibold text-gray-500">Ulasan PPKJ:</p>
                                    <p class="italic">"{{ l.ulasan_ppkj }}"</p>
                                    <span class="text-green-600 font-bold text-[10px]">✓ Laporan Telah Disahkan</span>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="!laporans.data.length">
                            <td colspan="3" class="p-8 text-center text-gray-500 font-medium">
                                Tiada laporan yang menunggu semakan PPKJ pada masa ini.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Pagination :links="laporans.links" />
        </div>

        <Teleport to="body">
            <div v-if="dilihat" class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-black/50" @click="dilihat = null"></div>
                <div class="relative w-full max-w-4xl max-h-[90vh] overflow-y-auto bg-white rounded-2xl shadow-2xl">
                    <div class="sticky top-0 z-10 flex justify-end p-3 bg-white border-b">
                        <button @click="dilihat = null" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600">✕</button>
                    </div>
                    <div class="p-4"><LaporanPaparan :jadual="dilihat" /></div>
                </div>
            </div>
        </Teleport>
    </AppLayout>
</template>
