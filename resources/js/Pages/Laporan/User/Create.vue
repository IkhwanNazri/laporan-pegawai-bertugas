<script setup>
import { computed, ref, watch } from 'vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'
import AppLayout from '../../../Layouts/AppLayout.vue'
import { senaraiSemak, tarikhLaporan } from '../senaraiSemak.js'

const props = defineProps({
    jadual: { type: Object, default: null },
    bahagians: { type: Array, default: () => [] },
    pegawais: { type: Array, default: () => [] },
})

// Dropdown pegawai terakhir: pilih bahagian dulu, kemudian nama pegawai
const bahagianTerakhir = ref('')
const pegawaiIkutBahagian = computed(() =>
    bahagianTerakhir.value ? props.pegawais.filter((p) => p.bahagian_id === bahagianTerakhir.value) : [],
)

const user = computed(() => usePage().props.auth?.user)

// Bina struktur kosong: status[bil] atau status[bil][index]
const kosong = () =>
    Object.fromEntries(Object.entries(senaraiSemak).map(([bil, [, sub]]) => [bil, sub ? sub.map(() => '') : '']))

const form = useForm({
    jadual_id: props.jadual?.id,
    status: kosong(),
    catatan: kosong(),
    ulasan: '',
    catatan_tambahan: '',
    nama_pegawai_terakhir: '',
})

const pilihan = [
    { value: '/', label: '/', aktif: 'bg-green-500 text-white border-green-500', hover: 'hover:bg-green-50 hover:text-green-600' },
    { value: 'X', label: 'X', aktif: 'bg-red-500 text-white border-red-500', hover: 'hover:bg-red-50 hover:text-red-600' },
    { value: '-', label: '−', aktif: 'bg-gray-500 text-white border-gray-500', hover: 'hover:bg-gray-100 hover:text-gray-700' },
]

// Klik sekali pilih, klik lagi nyahpilih
const setStatus = (bil, index, value) => {
    if (index === null) form.status[bil] = form.status[bil] === value ? '' : value
    else form.status[bil][index] = form.status[bil][index] === value ? '' : value
}
const nilai = (bil, index) => (index === null ? form.status[bil] : form.status[bil][index])

const tarikh = computed(() => tarikhLaporan(props.jadual?.tarikh))

watch(bahagianTerakhir, () => (form.nama_pegawai_terakhir = ''))

const submit = () => form.post('/user/laporan')
</script>

<template>
    <AppLayout title="Laporan Pegawai Bertugas">
        <div v-if="jadual" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 p-6 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-800 text-center uppercase mb-4">
                    Laporan Pegawai Bertugas<br>Kementerian Perpaduan Negara
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                    <div>
                        <p><span class="font-semibold inline-block w-40">Bahagian/ Unit:</span>{{ jadual.bahagian?.nama_bahagian ?? 'BPM' }}</p>
                        <p><span class="font-semibold inline-block w-40">Nama Pegawai:</span><span class="uppercase">{{ user?.name }}</span></p>
                    </div>
                    <div>
                        <p><span class="font-semibold inline-block w-40">Aras:</span>{{ jadual.aras }}</p>
                        <p><span class="font-semibold inline-block w-40">Tarikh:</span>{{ tarikh }}</p>
                    </div>
                </div>
            </div>

            <form @submit.prevent="submit">
                <div class="p-4 sm:p-6">
                    <div v-if="Object.keys(form.errors).length" class="p-4 mb-4 bg-red-100 border border-red-400 text-red-700 rounded-xl text-sm">
                        <li v-for="(msg, key) in form.errors" :key="key">{{ msg }}</li>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-base font-bold text-gray-800 uppercase">Bahagian A</h3>
                        <p class="text-sm text-gray-500 mt-1">Senarai Semak Pemeriksaan Oleh Pegawai Bertugas</p>
                    </div>

                    <div class="overflow-x-auto border border-gray-200 rounded-xl">
                        <table class="w-full text-sm border-collapse">
                            <thead>
                                <tr class="bg-purple-900 text-white">
                                    <th class="p-3 w-14 text-center font-semibold">Bil.</th>
                                    <th class="p-3 text-left font-semibold min-w-[400px]">Perkara Diperiksa</th>
                                    <th class="p-3 w-[230px] text-center font-semibold">Tanda</th>
                                    <th class="p-3 w-[280px] text-left font-semibold">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr v-for="([perkara, sub], bil) in senaraiSemak" :key="bil" class="hover:bg-gray-50">
                                    <td class="p-4 text-center align-top font-semibold text-gray-700 bg-gray-50">{{ bil }}</td>

                                    <td class="p-4 align-top">
                                        <p :class="sub ? 'font-semibold text-gray-800' : 'font-medium text-gray-800'">{{ perkara }}</p>
                                        <div v-if="sub" class="mt-3 space-y-2">
                                            <div v-for="s in sub" :key="s" class="text-gray-600 pl-2 h-9 flex items-center">{{ s }}</div>
                                        </div>
                                    </td>

                                    <td class="p-4 align-top">
                                        <div :class="sub ? 'mt-9 space-y-2' : ''">
                                            <div v-for="index in (sub ? sub.map((_, i) => i) : [null])" :key="String(index)"
                                                class="flex items-center justify-center gap-1.5">
                                                <button v-for="p in pilihan" :key="p.value" type="button" @click="setStatus(bil, index, p.value)"
                                                    :class="['w-10 h-9 rounded-lg border text-sm font-semibold active:scale-95 transition-all duration-200',
                                                        nilai(bil, index) === p.value ? p.aktif + ' shadow-sm' : 'border-gray-200 bg-gray-50 text-gray-500 ' + p.hover]">
                                                    {{ p.label }}
                                                </button>
                                            </div>
                                        </div>
                                        <div v-if="!sub" class="text-xs text-gray-400 text-center mt-2">/ Ya &nbsp; X Tidak &nbsp; − Tiada</div>
                                    </td>

                                    <td class="p-4 align-top">
                                        <div v-if="sub" class="mt-9 space-y-2">
                                            <input v-for="(s, i) in sub" :key="i" v-model="form.catatan[bil][i]" type="text" placeholder="Catatan..."
                                                class="w-full h-9 px-3 rounded-lg border border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500">
                                        </div>
                                        <input v-else v-model="form.catatan[bil]" type="text" placeholder="Nama pegawai / Catatan..."
                                            class="w-full h-9 px-3 rounded-lg border border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="px-6 py-5 border-t border-gray-200 bg-gray-50">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Ulasan Keseluruhan Pegawai Bertugas</label>
                    <textarea v-model="form.ulasan" rows="3" placeholder="Masukkan ulasan jika ada..."
                        class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-purple-500 focus:ring-purple-500" />
                </div>

                <div class="px-6 py-5 border-t border-gray-200">
                    <div class="mb-4">
                        <h3 class="text-sm font-bold text-gray-800 uppercase">Bahagian B</h3>
                        <p class="text-xs text-gray-500 mt-1">Dilengkapkan oleh pegawai terakhir meninggalkan pejabat <span class="italic">(Pilihan)</span></p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Catatan Tambahan</label>
                            <textarea v-model="form.catatan_tambahan" rows="3" placeholder="Catatan tambahan..."
                                class="mt-1 block w-full rounded-lg border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Pegawai Terakhir</label>
                            <select v-model="bahagianTerakhir"
                                class="mt-1 block w-full h-10 rounded-lg border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500">
                                <option value="">-- Pilih Bahagian --</option>
                                <option v-for="b in bahagians" :key="b.id" :value="b.id">{{ b.kod_bahagian }} - {{ b.nama_bahagian }}</option>
                            </select>
                            <select v-model="form.nama_pegawai_terakhir" :disabled="!bahagianTerakhir"
                                class="mt-2 block w-full h-10 rounded-lg border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500 disabled:bg-gray-100">
                                <option value="">-- Pilih Nama Pegawai --</option>
                                <option v-for="p in pegawaiIkutBahagian" :key="p.id" :value="p.name">{{ p.name }}</option>
                            </select>
                            <p class="text-[11px] text-gray-400 mt-1">PKA akan dimaklumkan jika pegawai terakhir dipilih.</p>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-5 border-t border-gray-200 flex flex-col sm:flex-row justify-end gap-3">
                    <Link href="/user/jadual" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium text-center hover:bg-gray-200">Batal</Link>
                    <button type="submit" :disabled="form.processing"
                        class="px-6 py-2.5 bg-purple-900 text-white rounded-lg text-sm font-medium hover:bg-purple-800 shadow-sm disabled:opacity-50">
                        {{ form.processing ? 'Menghantar...' : 'Hantar Laporan' }}
                    </button>
                </div>
            </form>
        </div>

        <div v-else class="bg-white rounded-xl border border-gray-200 shadow-sm p-8 text-center">
            <h2 class="text-base font-semibold text-gray-800">Jadual bertugas tidak ditemui</h2>
            <p class="text-sm text-gray-500 mt-2">Sila pilih jadual bertugas terlebih dahulu sebelum mengisi laporan.</p>
            <Link href="/user/jadual" class="inline-block mt-5 px-5 py-2.5 bg-purple-900 text-white rounded-lg text-sm font-medium hover:bg-purple-800">
                Kembali ke Jadual
            </Link>
        </div>
    </AppLayout>
</template>
