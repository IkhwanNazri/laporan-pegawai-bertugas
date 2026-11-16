<script setup>
import { useForm } from '@inertiajs/vue3'
import AppLayout from '../../../Layouts/AppLayout.vue'
import Pagination from '../../Components/Pagination.vue'
import { formatTarikh, ringkas } from '../statusLaporan.js'

defineProps({ laporans: { type: Object, required: true } })

const forms = {}
const ulasanForm = (laporan) => (forms[laporan.id] ??= useForm({ ulasan: laporan.ulasan ?? '' }))

const hantarSemula = (laporan) =>
    ulasanForm(laporan).patch(`/user/laporan/${laporan.id}/update-ulasan`, { preserveScroll: true })

const badge = {
    pka: 'text-yellow-800 bg-yellow-100 border-yellow-200',
    ppkj: 'text-blue-800 bg-blue-100 border-blue-200',
}
</script>

<template>
    <AppLayout title="Senarai Laporan Saya">
        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 text-sm text-gray-500 uppercase bg-gray-50">
                            <th class="p-3">Kod Laporan</th>
                            <th class="p-3">Tarikh Tugas</th>
                            <th class="p-3">Bahagian / Aras</th>
                            <th class="p-3 w-1/3">Ulasan Saya</th>
                            <th class="p-3 text-center">Status Laporan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <tr v-for="l in laporans.data" :key="l.id" class="hover:bg-gray-50">
                            <td class="p-3 font-semibold text-purple-900">{{ l.kod_laporan }}</td>
                            <td class="p-3">{{ formatTarikh(l.jadual?.tarikh) }}</td>
                            <td class="p-3">{{ l.jadual?.bahagian?.kod_bahagian ?? '-' }} (Aras {{ l.jadual?.aras }})</td>
                            <td class="p-3 text-gray-600">{{ ringkas(l.ulasan) }}</td>

                            <td class="p-3 text-center align-middle border-l border-gray-100">
                                <span v-if="['dalam_proses', 'menunggu_pka'].includes(l.status_pengesahan)"
                                    :class="['inline-flex px-3 py-1 text-xs font-medium border rounded-full', badge.pka]">
                                    Sedang Disemak (PKA)
                                </span>

                                <span v-else-if="['dihantar_ppkj', 'dihantar'].includes(l.status_pengesahan)"
                                    :class="['inline-flex px-3 py-1 text-xs font-medium border rounded-full', badge.ppkj]">
                                    Dalam Semakan PPKJ
                                </span>

                                <span v-else-if="l.status_pengesahan === 'disahkan'"
                                    class="inline-flex px-3 py-1 text-xs font-medium text-indigo-800 bg-indigo-100 border border-indigo-200 rounded-full">
                                    Tindakan PKA
                                </span>

                                <span v-else-if="l.status_pengesahan === 'selesai'"
                                    class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full font-bold border border-green-200">
                                    ✓ Selesai
                                </span>

                                <form v-else-if="l.status_pengesahan === 'menunggu_tindakan_user'" @submit.prevent="hantarSemula(l)"
                                    class="flex flex-col gap-2 p-2 bg-amber-50 border border-amber-200 rounded-xl text-left">
                                    <label class="text-[11px] font-bold text-amber-900">Kemaskini Ulasan / Tindakan Lanjut:</label>
                                    <textarea v-model="ulasanForm(l).ulasan" rows="2" required
                                        class="w-full text-xs p-2 border-amber-300 rounded-lg focus:ring-amber-500 focus:border-amber-500"
                                        placeholder="Taip ulasan/tindakan terkini di sini..." />
                                    <button type="submit" :disabled="ulasanForm(l).processing"
                                        class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-lg disabled:opacity-50">
                                        Hantar Semula
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <tr v-if="!laporans.data.length">
                            <td colspan="5" class="p-8 text-center text-gray-400 font-medium">Tiada rekod laporan ditemui.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <Pagination :links="laporans.links" />
        </div>
    </AppLayout>
</template>
