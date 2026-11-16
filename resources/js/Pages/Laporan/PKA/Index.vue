<script setup>
import { Link, router, useForm } from '@inertiajs/vue3'
import AppLayout from '../../../Layouts/AppLayout.vue'
import Pagination from '../../Components/Pagination.vue'
import { formatTarikh, ringkas } from '../statusLaporan.js'

defineProps({ laporans: { type: Object, required: true } })

const hantarPpkj = (id) => {
    if (confirm('Pasti untuk hantar kepada PPKJ?')) {
        router.patch(`/pka/laporan/${id}/hantar-ppkj`, {}, { preserveScroll: true })
    }
}

const forms = {}
const tindakanForm = (id) => (forms[id] ??= useForm({ status_tindakan_pka: '' }))
const sahkan = (id) => tindakanForm(id).patch(`/pka/laporan/${id}/selesai`, { preserveScroll: true })
</script>

<template>
    <AppLayout title="Senarai Laporan">
        <div class="flex justify-end">
            <Link href="/pka/jadual"
                class="inline-flex px-5 py-2.5 bg-purple-900 text-white text-sm font-medium rounded-full hover:bg-purple-800 shadow-md">
                + Tambah Laporan
            </Link>
        </div>

        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 text-sm text-gray-500 uppercase bg-gray-50">
                            <th class="p-3">Kod Laporan</th>
                            <th class="p-3">Tarikh Tugas</th>
                            <th class="p-3">Bahagian / Aras</th>
                            <th class="p-3 w-1/3">Ulasan Pegawai</th>
                            <th class="p-3 text-center">Status / Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <tr v-for="l in laporans.data" :key="l.id" class="hover:bg-gray-50">
                            <td class="p-3 font-semibold text-purple-900">{{ l.kod_laporan }}</td>
                            <td class="p-3">{{ formatTarikh(l.jadual?.tarikh) }}</td>
                            <td class="p-3">{{ l.jadual?.bahagian?.kod_bahagian ?? '-' }} ({{ l.jadual?.aras }})</td>
                            <td class="p-3 text-gray-600">{{ ringkas(l.ulasan) }}</td>

                            <td class="p-3 text-center align-top border-l border-gray-100">
                                <!-- FASA 1 -->
                                <button v-if="['dalam_proses', 'menunggu_pka'].includes(l.status_pengesahan)" @click="hantarPpkj(l.id)"
                                    class="px-3 py-1.5 text-xs font-medium text-white bg-purple-900 rounded-lg hover:bg-purple-800 shadow-sm">
                                    Hantar ke PPKJ
                                </button>

                                <!-- FASA 2 -->
                                <span v-else-if="['dihantar_ppkj', 'dihantar'].includes(l.status_pengesahan)"
                                    class="inline-flex px-2.5 py-0.5 text-xs font-medium text-yellow-800 bg-yellow-50 border border-yellow-200 rounded-full">
                                    Menunggu PPKJ
                                </span>

                                <!-- FASA 3 -->
                                <template v-else-if="l.status_pengesahan === 'disahkan'">
                                    <div class="text-left bg-blue-50/50 p-3 rounded-lg border border-blue-100 mb-2 text-xs">
                                        <span class="font-bold text-blue-900">Ulasan PPKJ:</span>
                                        <p class="italic text-gray-700 mt-1">"{{ l.ulasan_ppkj }}"</p>
                                    </div>
                                    <form @submit.prevent="sahkan(l.id)" class="flex flex-col gap-2">
                                        <select v-model="tindakanForm(l.id).status_tindakan_pka" required
                                            class="text-xs border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                                            <option value="">-- Pilih Tindakan --</option>
                                            <option>Sudah Bertindak</option>
                                            <option>Belum Bertindak</option>
                                        </select>
                                        <button type="submit" :disabled="tindakanForm(l.id).processing"
                                            class="px-3 py-1.5 bg-green-600 text-white text-xs font-bold rounded-lg hover:bg-green-700 disabled:opacity-50">
                                            Sahkan Tindakan
                                        </button>
                                    </form>
                                </template>

                                <!-- FASA 4A -->
                                <div v-else-if="l.status_pengesahan === 'menunggu_tindakan_user'" class="flex flex-col items-center gap-1.5">
                                    <span class="px-2.5 py-1 text-xs bg-amber-100 text-amber-800 border border-amber-300 rounded-full font-semibold">⚠️ Belum Bertindak</span>
                                    <span class="text-[10px] text-gray-500">Menunggu Pegawai Bertugas kemas kini & hantar semula</span>
                                </div>

                                <!-- FASA 4B -->
                                <div v-else-if="l.status_pengesahan === 'selesai'" class="flex flex-col items-center gap-1">
                                    <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full font-bold border border-green-200">✓ Selesai</span>
                                    <span class="text-[10px] text-gray-500 font-semibold uppercase">Tindakan PKA: {{ l.status_tindakan_pka }}</span>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="!laporans.data.length">
                            <td colspan="5" class="p-4 text-center text-gray-400">Tiada rekod laporan ditemui.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <Pagination :links="laporans.links" />
        </div>
    </AppLayout>
</template>
