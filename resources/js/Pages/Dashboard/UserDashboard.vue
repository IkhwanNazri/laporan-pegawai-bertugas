<script setup>
import Sidebar from '../Components/Sidebar.vue'
import BannerAtas from '../Components/BannerAtas.vue'
import MainTaskUser from '../Components/MainTaskUser.vue'
import Header from '../Components/Header.vue'

defineProps({
    user: {
        type: Object,
        default: null,
    },

    jaduals: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>

    <div class="flex h-screen overflow-hidden bg-gray-100">

        <!-- SIDEBAR -->
        <Sidebar :user="user" />


        <!-- MAIN AREA -->
        <div class="flex flex-col flex-1 min-w-0 overflow-hidden">

            <!-- HEADER -->
            <Header :user="user" :notifications="notifications" :unread-count="unreadCount" :profile-url="profileUrl"
                :logout-url="logoutUrl" :notifications-read-url="notificationsReadUrl" />


            <!-- CONTENT -->
            <main class="flex-1 min-h-0 overflow-x-hidden overflow-y-auto">

                <div class="py-4">

                    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

                        <BannerAtas :user="user" />

                        <MainTaskUser :jaduals="jaduals" />

                    </div>

                </div>

            </main>

        </div>

    </div>

</template>
