<script setup>
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '../../../Layouts/AppLayout.vue'
import Pagination from '../../Components/Pagination.vue'
import { roles } from '../roles.js'

defineProps({ users: Object })

const padam = (id) => {
    if (confirm('Pasti mahu padam pengguna ini?')) router.delete(`/admin/pengguna/${id}`, { preserveScroll: true })
}
</script>

<template>
    <AppLayout title="Pengurusan Pengguna">
        <div class="flex justify-end">
            <Link href="/admin/pengguna/create" class="px-5 py-2.5 bg-purple-900 text-white text-sm font-medium rounded-full hover:bg-purple-800 shadow-md">
                + Tambah Pengguna
            </Link>
        </div>

        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-6 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 text-sm text-gray-500 uppercase bg-gray-50">
                        <th class="p-3">Nama Lengkap</th>
                        <th class="p-3">No. Kad Pengenalan</th>
                        <th class="p-3">Peranan</th>
                        <th class="p-3">Bahagian</th>
                        <th class="p-3 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <tr v-for="u in users.data" :key="u.id" class="hover:bg-gray-50">
                        <td class="p-3 font-semibold text-gray-900">{{ u.name }}</td>
                        <td class="p-3 text-gray-600">{{ u.no_ic }}</td>
                        <td class="p-3">
                            <span :class="['px-2 py-1 text-xs rounded-full font-semibold', roles[u.role]?.class ?? 'bg-gray-100 text-gray-700']">
                                {{ u.role?.replaceAll('_', ' ').toUpperCase() }}
                            </span>
                        </td>
                        <td class="p-3">{{ u.bahagian?.kod_bahagian ?? '-' }}</td>
                        <td class="p-3 text-right">
                            <button @click="padam(u.id)" class="text-red-600 hover:text-red-900 font-medium text-xs">Padam</button>
                        </td>
                    </tr>
                    <tr v-if="!users.data.length">
                        <td colspan="5" class="p-4 text-center text-gray-400">Tiada rekod pengguna ditemui.</td>
                    </tr>
                </tbody>
            </table>
            <Pagination :links="users.links" />
        </div>
    </AppLayout>
</template>
