<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import Sidebar from '../Pages/Components/Sidebar.vue'
import Header from '../Pages/Components/Header.vue'

defineProps({
    title: { type: String, default: '' },
})

const page = usePage()
const user = computed(() => page.props.auth?.user)
const flash = computed(() => page.props.flash ?? {})
</script>

<template>
    <div class="flex h-screen overflow-hidden bg-gray-100">
        <Sidebar :user="user" />


        <main
            class="flex flex-col flex-1 overflow-hidden relative  bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px]">

            <Header class="w-full  mb-8" :user="user" :notifications="page.props.notifications"
                :unread-count="page.props.unreadCount" profile-url="/profile" logout-url="/logout"
                notifications-read-url="/notifications/mark-as-read" />

            <div class="flex-1 overflow-y-auto px-4 sm:px-6 lg:px-8 space-y-6">
                <h1 v-if="title" class="text-2xl font-bold text-gray-800">{{ title }}</h1>

                <div v-if="flash.success"
                    class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm font-semibold">
                    {{ flash.success }}
                </div>
                <div v-if="flash.error" class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm"
                    v-html="flash.error" />

                <slot />
            </div>


            <footer class="bg-white p-4 shadow-sm border border-gray-100">
                <h6 class="text-black text-center">Hak Cipta Terpelihara 2026 Kementerian Perpaduan Negara.</h6>
            </footer>

        </main>
    </div>
</template>
