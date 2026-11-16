<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AppLayout from '../../Layouts/AppLayout.vue'
import BannerAtas from '../Components/BannerAtas.vue'
import MainTaskUser from '../Components/MainTaskUser.vue'
import UserMobile from './UserMobile.vue'
import CardDashboard from './Parts/CardDashboard.vue'
import Kalender from './Parts/Kalender.vue'
import MainTask from './Parts/MainTask.vue'
import MainTaskPpkj from './Parts/MainTaskPpkj.vue'
import PegawaiBertugas from './Parts/PegawaiBertugas.vue'

// Data dihantar ikut role oleh DashboardController
defineProps({
    card: { type: Object, default: () => ({}) },
    events: { type: Array, default: () => [] },
    mainTask: { type: Object, default: () => ({ data: [], links: [] }) },
    semuaJadual: { type: Array, default: () => [] },
    recent: { type: Array, default: () => [] },
    history: { type: Array, default: () => [] },
    jaduals: { type: Array, default: () => [] },
})

const user = computed(() => usePage().props.auth?.user)
const role = computed(() => user.value?.role)
</script>

<template>
    <AppLayout>
        <!-- PKA -->
        <div v-if="role === 'pegawai_keselamatan_aras'" class="grid grid-cols-1 xl:grid-cols-3 gap-5">
            <div class="xl:col-span-2 space-y-10">
                <BannerAtas />
                <CardDashboard v-bind="card" />
                <MainTask :jaduals="mainTask" />
            </div>
            <div class="space-y-5">
                <Kalender :events="events" />
                <PegawaiBertugas :semua-jadual="semuaJadual" />
            </div>
        </div>

        <!-- SUPERADMIN -->
        <div v-else-if="role === 'superadmin'" class="space-y-6">
            <BannerAtas />
            <CardDashboard v-bind="card" />
            <Kalender :events="events" />
        </div>

        <!-- PPKJ -->
        <div v-else-if="role === 'penolong_pegawai_keselamatan_jabatan'" class="space-y-6">
            <BannerAtas />
            <MainTaskPpkj :recent="recent" :history="history" />
        </div>

        <!-- PEGAWAI BERTUGAS -->
        <template v-else>
            <div class="hidden md:block space-y-6">
                <BannerAtas />
                <MainTaskUser :jaduals="jaduals" />
            </div>
            <div class="md:hidden">
                <UserMobile :user="user" />
            </div>
        </template>
    </AppLayout>
</template>
