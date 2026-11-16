<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AppLayout from '../../Layouts/AppLayout.vue'

const props = defineProps({ user: Object, status: String })

const profil = useForm({ name: props.user.name, no_ic: props.user.no_ic })
const simpanProfil = () => profil.patch('/profile', { preserveScroll: true })

const kataLaluan = useForm({ current_password: '', password: '', password_confirmation: '' })
const simpanKataLaluan = () =>
    kataLaluan.put('/password', {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => kataLaluan.reset(),
    })

const sahPadam = ref(false)
const padam = useForm({ password: '' })
const padamAkaun = () => padam.delete('/profile', { errorBag: 'userDeletion', preserveScroll: true })

const input = 'mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500'
const kad = 'p-6 bg-white shadow-sm rounded-2xl border border-gray-100'
</script>

<template>
    <AppLayout title="Profil">
        <!-- MAKLUMAT PROFIL -->
        <section :class="kad">
            <h2 class="text-lg font-medium text-gray-900">Maklumat Profil</h2>
            <p class="mt-1 text-sm text-gray-600">Kemas kini nama dan no. kad pengenalan anda.</p>

            <form @submit.prevent="simpanProfil" class="mt-6 space-y-4 max-w-xl">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <input v-model="profil.name" type="text" :class="input" required>
                    <p v-if="profil.errors.name" class="text-xs text-red-600 mt-1">{{ profil.errors.name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">No. Kad Pengenalan</label>
                    <input v-model="profil.no_ic" type="text" :class="input" required>
                    <p v-if="profil.errors.no_ic" class="text-xs text-red-600 mt-1">{{ profil.errors.no_ic }}</p>
                </div>
                <div class="flex items-center gap-4">
                    <button :disabled="profil.processing" class="px-4 py-2 bg-purple-900 text-white rounded-lg text-sm hover:bg-purple-800 disabled:opacity-50">Simpan</button>
                    <span v-if="profil.recentlySuccessful" class="text-sm text-gray-600">Disimpan.</span>
                </div>
            </form>
        </section>

        <!-- KATA LALUAN -->
        <section :class="kad">
            <h2 class="text-lg font-medium text-gray-900">Tukar Kata Laluan</h2>
            <p class="mt-1 text-sm text-gray-600">Gunakan kata laluan yang panjang dan sukar diteka.</p>

            <form @submit.prevent="simpanKataLaluan" class="mt-6 space-y-4 max-w-xl">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kata Laluan Semasa</label>
                    <input v-model="kataLaluan.current_password" type="password" autocomplete="current-password" :class="input">
                    <p v-if="kataLaluan.errors.current_password" class="text-xs text-red-600 mt-1">{{ kataLaluan.errors.current_password }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kata Laluan Baharu</label>
                    <input v-model="kataLaluan.password" type="password" autocomplete="new-password" :class="input">
                    <p v-if="kataLaluan.errors.password" class="text-xs text-red-600 mt-1">{{ kataLaluan.errors.password }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sahkan Kata Laluan</label>
                    <input v-model="kataLaluan.password_confirmation" type="password" autocomplete="new-password" :class="input">
                </div>
                <div class="flex items-center gap-4">
                    <button :disabled="kataLaluan.processing" class="px-4 py-2 bg-purple-900 text-white rounded-lg text-sm hover:bg-purple-800 disabled:opacity-50">Simpan</button>
                    <span v-if="kataLaluan.recentlySuccessful" class="text-sm text-gray-600">Disimpan.</span>
                </div>
            </form>
        </section>

        <!-- PADAM AKAUN -->
        <section :class="kad">
            <h2 class="text-lg font-medium text-gray-900">Padam Akaun</h2>
            <p class="mt-1 text-sm text-gray-600">Semua data akaun akan dipadam secara kekal.</p>

            <button v-if="!sahPadam" @click="sahPadam = true" class="mt-4 px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700">Padam Akaun</button>

            <form v-else @submit.prevent="padamAkaun" class="mt-4 space-y-3 max-w-xl">
                <p class="text-sm text-gray-700">Masukkan kata laluan untuk sahkan pemadaman akaun.</p>
                <input v-model="padam.password" type="password" placeholder="Kata laluan" :class="input" required>
                <p v-if="padam.errors.password" class="text-xs text-red-600">{{ padam.errors.password }}</p>
                <div class="flex gap-2">
                    <button type="button" @click="sahPadam = false; padam.reset()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm">Batal</button>
                    <button :disabled="padam.processing" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700 disabled:opacity-50">Sahkan Padam</button>
                </div>
            </form>
        </section>
    </AppLayout>
</template>
