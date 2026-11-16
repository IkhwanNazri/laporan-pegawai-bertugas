<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import AppLayout from '../../../Layouts/AppLayout.vue'

const props = defineProps({
    jenis: { type: String, default: 'harian' }, // 'harian' | 'mingguan'
    bahagians: { type: Array, default: () => [] },
    pegawais: { type: Array, default: () => [] },
})

const isMingguan = props.jenis === 'mingguan'

const toYmd = (d) =>
    `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`

// Isnin minggu ini
const today = new Date()
const monday = new Date(today)
monday.setDate(today.getDate() + (today.getDay() === 0 ? -6 : 1 - today.getDay()))

const form = useForm({
    jenis: props.jenis,
    bahagian_id: '',
    user_id: '',
    aras: '',
    no_telefon: '',
    pegawai_ganti_id: '',
    tarikh: '',
    tarikh_mula: '',
    tarikh_tamat: '',
    bulan: '',
    minggu: '',
})

// Auto isi tarikh tamat (+4 hari), bulan & minggu bila tarikh mula berubah
const onTarikhMula = () => {
    if (!form.tarikh_mula) return
    const mula = new Date(form.tarikh_mula)
    const tamat = new Date(mula)
    tamat.setDate(mula.getDate() + 4)

    form.tarikh_tamat = toYmd(tamat)
    form.bulan = form.tarikh_mula.slice(0, 7)
    form.minggu = `Minggu ${Math.min(Math.ceil(mula.getDate() / 7), 5)}`
}

if (isMingguan) {
    form.tarikh_mula = toYmd(monday)
    onTarikhMula()
}

const submit = () => form.post('/pka/jadual')

const input = 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500'
</script>

<template>
    <AppLayout :title="`Jadual Sistem Pegawai Bertugas (${isMingguan ? 'Mingguan' : 'Harian'})`">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div v-if="Object.keys(form.errors).length" class="p-4 mb-4 bg-red-100 border border-red-400 text-red-700 rounded-xl">
                <strong class="font-bold">Alamak! Ada masalah input:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    <li v-for="(msg, key) in form.errors" :key="key">{{ msg }}</li>
                </ul>
            </div>

            <form @submit.prevent="submit" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bahagian / Unit</label>
                        <select v-model="form.bahagian_id" :class="input" required>
                            <option value="">-- Pilih Bahagian --</option>
                            <option v-for="b in bahagians" :key="b.id" :value="b.id">
                                {{ b.kod_bahagian }} - {{ b.nama_bahagian }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Aras</label>
                        <input v-model="form.aras" type="text" placeholder="Contoh: Aras 6" :class="input" required>
                    </div>
                </div>

                <!-- HARIAN -->
                <div v-if="!isMingguan">
                    <label class="block text-sm font-medium text-gray-700">Tarikh Tugas</label>
                    <input v-model="form.tarikh" type="date" :class="input" required>
                </div>

                <!-- MINGGUAN -->
                <template v-else>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bulan & Tahun</label>
                            <input v-model="form.bulan" type="month" :class="input" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Minggu Bertugas</label>
                            <select v-model="form.minggu" :class="[input, 'bg-gray-50']" required>
                                <option value="">-- Pilih Minggu --</option>
                                <option v-for="n in 5" :key="n" :value="`Minggu ${n}`">Minggu {{ n }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tarikh Mula (Isnin)</label>
                            <input v-model="form.tarikh_mula" @change="onTarikhMula" type="date" :class="input" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tarikh Tamat (Jumaat)</label>
                            <input v-model="form.tarikh_tamat" type="date" :class="[input, 'bg-gray-50']" required>
                        </div>
                    </div>
                </template>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pegawai Bertugas</label>
                        <select v-model="form.user_id" :class="input" required>
                            <option value="">-- Pilih Pegawai --</option>
                            <option v-for="p in pegawais" :key="p.id" :value="p.id">{{ p.name }} ({{ p.no_ic }})</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No Telefon</label>
                        <input v-model="form.no_telefon" type="text" placeholder="Contoh: 012-3456789" :class="input" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Pegawai Ganti (Pilihan)</label>
                    <select v-model="form.pegawai_ganti_id" :class="input">
                        <option value="">-- Tiada --</option>
                        <option v-for="p in pegawais" :key="p.id" :value="p.id">{{ p.name }}</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-4">
                    <Link href="/pka/jadual" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg">Batal</Link>
                    <button type="submit" :disabled="form.processing"
                        class="px-4 py-2 bg-purple-900 text-white rounded-lg hover:bg-purple-800 disabled:opacity-50">
                        {{ form.processing ? 'Menyimpan...' : `Simpan Jadual ${isMingguan ? 'Mingguan' : ''}` }}
                    </button>
                </div>
            </form>

            <span class="text-black text-lg font-medium">Jadual disediakan oleh: Pegawai Keselamatan Aras (PKA)</span>
        </div>
    </AppLayout>
</template>
