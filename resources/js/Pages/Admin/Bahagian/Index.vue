<script setup>
import { router, useForm } from '@inertiajs/vue3'
import AppLayout from '../../../Layouts/AppLayout.vue'
import Pagination from '../../Components/Pagination.vue'

defineProps({ bahagians: Object })

const form = useForm({ kod_bahagian: '', nama_bahagian: '' })
const simpan = () => form.post('/admin/bahagian', { preserveScroll: true, onSuccess: () => form.reset() })

const padam = (id) => {
    if (confirm('Pasti mahu padam bahagian ini?')) router.delete(`/admin/bahagian/${id}`, { preserveScroll: true })
}

const input = 'mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500'
</script>

<template>
    <AppLayout title="Pengurusan Bahagian">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-fit">
                <h3 class="font-bold text-gray-800 mb-4">Tambah Bahagian Baru</h3>
                <form @submit.prevent="simpan" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kod Bahagian (Cth: BPM)</label>
                        <input v-model="form.kod_bahagian" type="text" :class="[input, 'uppercase']" required>
                        <p v-if="form.errors.kod_bahagian" class="text-xs text-red-600 mt-1">{{ form.errors.kod_bahagian }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Penuh Bahagian</label>
                        <input v-model="form.nama_bahagian" type="text" :class="input" required>
                        <p v-if="form.errors.nama_bahagian" class="text-xs text-red-600 mt-1">{{ form.errors.nama_bahagian }}</p>
                    </div>
                    <button type="submit" :disabled="form.processing" class="w-full py-2 bg-purple-900 text-white rounded-lg text-sm font-medium hover:bg-purple-800 disabled:opacity-50">
                        Simpan Data
                    </button>
                </form>
            </div>

            <div class="md:col-span-2 bg-white shadow-sm rounded-2xl border border-gray-100 p-6 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 text-sm text-gray-500 uppercase bg-gray-50">
                            <th class="p-3">Kod</th>
                            <th class="p-3">Nama Bahagian</th>
                            <th class="p-3 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <tr v-for="b in bahagians.data" :key="b.id" class="hover:bg-gray-50">
                            <td class="p-3 font-semibold text-purple-900">{{ b.kod_bahagian }}</td>
                            <td class="p-3 text-gray-700">{{ b.nama_bahagian }}</td>
                            <td class="p-3 text-right">
                                <button @click="padam(b.id)" class="text-red-600 hover:text-red-900 font-medium text-xs">Padam</button>
                            </td>
                        </tr>
                        <tr v-if="!bahagians.data.length">
                            <td colspan="3" class="p-4 text-center text-gray-400">Tiada rekod bahagian ditemui.</td>
                        </tr>
                    </tbody>
                </table>
                <Pagination :links="bahagians.links" />
            </div>
        </div>
    </AppLayout>
</template>
