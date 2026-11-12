<script setup>
import { ref } from 'vue'

const props = defineProps({
    user: {
        type: Object,
        default: null,
    },

    notifications: {
        type: Array,
        default: () => [],
    },

    unreadCount: {
        type: Number,
        default: 0,
    },

    profileUrl: {
        type: String,
        default: '/profile',
    },

    logoutUrl: {
        type: String,
        default: '/logout',
    },

    notificationsReadUrl: {
        type: String,
        default: '/pka/notifications/read',
    },
})

const notificationOpen = ref(false)

const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    ?.getAttribute('content')

const markNotificationsRead = () => {
    const form = document.createElement('form')

    form.method = 'POST'
    form.action = props.notificationsReadUrl

    const csrf = document.createElement('input')
    csrf.type = 'hidden'
    csrf.name = '_token'
    csrf.value = csrfToken ?? ''

    form.appendChild(csrf)

    document.body.appendChild(form)
    form.submit()
}

const notificationUrl = (notification) => {
    return notification?.data?.url ?? '#'
}

const notificationTitle = (notification) => {
    return notification?.data?.tajuk ?? 'Pemberitahuan'
}

const notificationMessage = (notification) => {
    return notification?.data?.mesej ?? ''
}

const notificationTime = (notification) => {
    return notification?.created_at_human ?? ''
}
</script>


<template>

    <header class="hidden md:flex shrink-0 w-full pt-6 px-8 pb-4 justify-end items-center gap-3 z-20">

        <!-- Profile Badge Nama User -->

        <div
            class="py-2 px-4 bg-white shadow-sm border border-gray-100 rounded-xl text-sm text-gray-700 flex items-center font-medium">

            <span class="text-gray-900 font-bold">
                {{ user?.name }}
            </span>

            <span class="mx-2.5 text-gray-300">
                |
            </span>

            <span
                class="capitalize text-xs font-semibold px-2 py-0.5 bg-purple-50 text-purple-700 rounded-md border border-purple-100">
                {{ user?.role?.replaceAll('_', ' ') }}
            </span>

        </div>


        <!-- NOTIFICATION -->

        <div class="relative">

            <button @click="notificationOpen = !notificationOpen" title="Notifikasi"
                class="relative p-2.5 text-gray-600 bg-white shadow-sm border border-gray-100 transition-all rounded-xl hover:bg-purple-50 hover:text-purple-700 focus:outline-none">

                <!-- Bell -->

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>


                <!-- Unread Badge -->

                <span v-if="unreadCount > 0"
                    class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-extrabold text-white shadow-md ring-2 ring-white animate-pulse">
                    {{ unreadCount }}
                </span>

            </button>


            <!-- Dropdown -->

            <div v-if="notificationOpen" @click.self="notificationOpen = false" class="fixed inset-0 z-40"></div>


            <div v-if="notificationOpen"
                class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 overflow-hidden">

                <!-- Header -->

                <div class="p-4 bg-purple-900 text-white flex items-center justify-between">

                    <div class="flex items-center gap-2">

                        <svg class="w-4 h-4 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5" />
                        </svg>

                        <h4 class="text-xs font-bold uppercase tracking-wider">
                            Notifikasi Sistem
                        </h4>

                    </div>


                    <!-- Mark Read -->

                    <button v-if="unreadCount > 0" type="button" @click="markNotificationsRead"
                        class="text-[10px] bg-white/10 hover:bg-white/20 text-purple-100 px-2.5 py-1 rounded-full transition font-semibold"
                        title="Tandakan semua telah dibaca">

                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>

                    </button>

                </div>


                <!-- Notifications -->

                <div class="max-h-80 overflow-y-auto divide-y divide-gray-100">

                    <template v-if="notifications.length > 0">

                        <a v-for="notification in notifications" :key="notification.id"
                            :href="notificationUrl(notification)"
                            class="block p-3.5 hover:bg-purple-50/50 transition-colors" :class="notification.unread
                                ? 'bg-purple-50/30 font-semibold'
                                : 'opacity-70'">

                            <div class="flex items-start justify-between gap-2">

                                <p class="text-xs text-gray-900">
                                    {{ notificationTitle(notification) }}
                                </p>

                                <span class="text-[9px] text-gray-400 font-medium whitespace-nowrap">
                                    {{ notificationTime(notification) }}
                                </span>

                            </div>

                            <p class="text-xs text-gray-500 mt-1 leading-snug">
                                {{ notificationMessage(notification) }}
                            </p>

                        </a>

                    </template>


                    <!-- Empty -->

                    <div v-else class="text-center py-8">

                        <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5" />
                        </svg>

                        <p class="text-xs text-gray-400 font-medium">
                            Tiada notifikasi baharu.
                        </p>

                    </div>

                </div>

            </div>

        </div>


        <!-- PROFILE -->

        <a :href="profileUrl" title="Profil"
            class="p-2.5 text-gray-600 bg-white shadow-sm border border-gray-100 transition-all rounded-xl hover:bg-purple-50 hover:text-purple-700">

            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0ZM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7Z" />
            </svg>

        </a>


        <!-- LOGOUT -->

        <form :action="logoutUrl" method="POST" class="m-0">

            <input type="hidden" name="_token" :value="csrfToken">

            <button type="submit" title="Log Keluar"
                class="p-2.5 text-red-500 bg-white shadow-sm border border-gray-100 transition-all rounded-xl hover:bg-red-50 hover:text-red-700">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12H3m0 0l4-4m-4 4l4 4m5-10V5a2 2 0 012-2h5a2 2 0 012 2v14a2 2 0 01-2 2h-5a2 2 0 01-2-2v-1" />
                </svg>

            </button>

        </form>

    </header>

</template>
