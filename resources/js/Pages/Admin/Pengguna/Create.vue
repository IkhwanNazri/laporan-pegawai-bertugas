<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import AppLayout from '../../../Layouts/AppLayout.vue'
import { roles } from '../roles.js'

defineProps({ bahagians: Array })

const form = useForm({ name: '', no_ic: '', password: '', role: 'pegawai_bertugas', bahagian_id: '' })
const submit = () => form.post('/admin/pengguna')

const input = 'mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500'
</script>

<template>
    <AppLayout title="Tambah Pengguna Baru">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div v-if="Object.keys(form.errors).length" class="p-4 mb-4 text-red-700 bg-red-100 rounded-lg text-sm">
                <li v-for="(msg, key) in form.errors" :key="key">{{ msg }}</li>
            </div>

            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Penuh</label>
                    <input v-model="form.name" type="text" :class="input" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">No. Kad Pengenalan</label>
                    <input v-model="form.no_ic" type="text" :class="input" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kata Laluan</label>
                    <input v-model="form.password" type="password" :class="input" required>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Peranan (Role)</label>
                        <select v-model="form.role" :class="input" required>
                            <option v-for="(r, key) in roles" :key="key" :value="key">{{ r.label }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bahagian</label>
                        <select v-model="form.bahagian_id" :class="input" required>
                            <option value="">-- Pilih Bahagian --</option>
                            <option v-for="b in bahagians" :key="b.id" :value="b.id">{{ b.kod_bahagian }} - {{ b.nama_bahagian }}</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-4">
                    <Link href="/admin/pengguna" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm">Batal</Link>
                    <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-purple-900 text-white rounded-lg text-sm hover:bg-purple-800 disabled:opacity-50">
                        Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
