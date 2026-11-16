<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '../../../Layouts/AppLayout.vue'
import Pagination from '../../Components/Pagination.vue'

defineProps({ jaduals: Object })

const formatTarikh = (d) => (d ? new Date(d).toLocaleDateString('ms-MY', { day: '2-digit', month: '2-digit', year: 'numeric' }) : '-')
const isMingguan = (jadual) => (jadual.jenis ?? 'harian').toLowerCase() === 'mingguan'
</script>

<template>
    <AppLayout title="Jadual Sistem Pegawai Bertugas">
        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-2 h-6 bg-purple-600 rounded-full"></div>
                <h3 class="text-base font-bold text-gray-800 uppercase">Jadual Tugasan Anda</h3>
            </div>

            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 text-xs text-gray-600 uppercase bg-gray-100/50">
                            <th class="p-3 w-32">Tarikh</th>
                            <th class="p-3">Jenis</th>
                            <th class="p-3">Bahagian / Aras</th>
                            <th class="p-3">Pegawai Bertugas</th>
                            <th class="p-3">No Telefon</th>
                            <th class="p-3">Pegawai Pengganti</th>
                            <th class="p-3 text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <tr v-for="jadual in jaduals.data" :key="jadual.id" class="hover:bg-gray-50">
                            <td class="p-3 font-semibold">{{ formatTarikh(jadual.tarikh) }}</td>
                            <td class="p-3">
                                <span v-if="isMingguan(jadual)" class="px-2.5 py-1 text-[10px] font-bold text-emerald-700 bg-emerald-100 rounded-full uppercase tracking-wider">Mingguan</span>
                                <span v-else class="px-2.5 py-1 text-[10px] font-bold text-purple-700 bg-purple-100 rounded-full uppercase tracking-wider">Harian</span>
                            </td>
                            <td class="p-3">{{ jadual.bahagian?.kod_bahagian ?? '-' }} <span class="text-gray-400">|</span> Aras {{ jadual.aras }}</td>
                            <td class="p-3 font-bold text-gray-800">{{ jadual.pegawai?.name ?? '-' }}</td>
                            <td class="p-3 text-gray-600">{{ jadual.no_telefon ?? '-' }}</td>
                            <td class="p-3 text-gray-500">{{ jadual.pegawai_ganti?.name ?? '-' }}</td>
                            <td class="p-3 text-center">
                                <span v-if="jadual.laporan?.status_pengesahan === 'selesai'"
                                    class="inline-flex px-3 py-1.5 text-xs font-bold text-green-700 bg-green-100 border border-green-300 rounded-full">
                                    ✓ Selesai
                                </span>
                                <span v-else-if="jadual.laporan" class="inline-flex items-center gap-2 text-xs font-semibold text-purple-800">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                    Sedang Disemak
                                </span>
                                <Link v-else :href="`/user/laporan/laporanb?jadual_id=${jadual.id}`"
                                    class="inline-flex items-center gap-2 px-4 py-1.5 text-xs font-bold text-white bg-purple-600 rounded-full hover:bg-purple-700 shadow-sm">
                                    Isi Borang →
                                </Link>
                            </td>
                        </tr>

                        <tr v-if="!jaduals.data.length">
                            <td colspan="7" class="p-8 text-center text-gray-400 font-medium">Tiada jadual tugasan untuk anda buat masa ini.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <Pagination :links="jaduals.links" />
        </div>
    </AppLayout>
</template>
