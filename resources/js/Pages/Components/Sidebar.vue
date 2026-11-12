<script setup>
import { ref, computed } from 'vue'
import SidebarLink from './SidebarLink.vue'
import SidebarDropdown from './SidebarDropdown.vue'
const logoUrl = '/asset/logo.PNG'


const props = defineProps({
    user: {
        type: Object,
        default: null,
    },
})

const open = ref(true)

const role = computed(() => props.user?.role ?? '')
console.log('USER:', props.user)
console.log('ROLE:', role.value)

const currentPath = computed(() => window.location.pathname)

const isActive = (path) => {
    return currentPath.value === path
}

const isPath = (prefix) => {
    return currentPath.value.startsWith(prefix)
}

const urls = {
    dashboard: '/dashboard',

    pengguna: '/admin/pengguna',

    bahagian: '/admin/bahagian',

    ppkjPengesahan: '/ppkj/pengesahan',

    pkaJadual: '/pka/jadual',

    pkaJadualHarian: '/pka/jadual/harian',

    pkaJadualMingguan: '/pka/jadual/mingguan',

    pkaLaporan: '/pka/laporan',

    emails: '/emails/preview',

    userJadual: '/user/jadual',

    userLaporan: '/user/laporan',
}
</script>


<template>

    <div :class="open
        ? 'w-128 rounded-none'
        : 'w-30 rounded-[2.5rem] mx-2 my-2 items-center'"
        class="hidden md:flex flex-col h-full py-8 bg-white/80 shadow-lg backdrop-filter backdrop-blur-md border border-white/50 transition-all duration-300 ease-in-out">

        <!-- Logo -->

        <div :class="open
            ? 'flex flex-row items-center justify-between w-full'
            : 'flex flex-col items-center w-full'">

            <div class="relative flex w-full" :class="open
                ? 'justify-center'
                : 'flex-col items-center'">

                <div class="flex flex-col items-center justify-center px-2">

                    <a href="/">

                        <img :src="logoUrl" alt="Logo Sistem" :class="open
                            ? 'h-16 mb-2'
                            : 'h-12 mb-4'" class="object-contain mx-auto transition-all duration-300">

                        <p v-show="open" class="text-purple-900 font-semibold whitespace-nowrap text-center text-md"
                            style="font-family: 'Poppins', sans-serif;">
                            Kementerian Perpaduan Negara
                        </p>

                    </a>

                </div>


                <!-- Toggle -->

                <button @click="open = !open" :class="open ? 'absolute bottom-20 right-0' : ''"
                    class="p-2 group hover:opacity-75 transition-opacity" title="Toggle Sidebar">

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="text-purple-800  transition-all duration-300"
                        :class="open ? 'w-6 h-6 rotate-180' : 'w-10 h-10 '">
                        <path fill-rule="evenodd"
                            d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

            </div>

        </div>


        <!-- Navigation -->

        <div class="flex flex-col justify-between flex-1 mt-6 overflow-y-auto overflow-x-hidden w-full px-2"
            :class="open ? 'px-4' : 'px-2'">

            <nav class="space-y-3 flex flex-col" :class="!open && 'items-center'">

                <!-- HOME -->

                <SidebarLink :href="urls.dashboard" :active="isActive(urls.dashboard)" label="Home" short-label="Home"
                    :open="open">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="">
                        <path
                            d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                        <path
                            d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                    </svg>

                </SidebarLink>


                <hr class="border-t-2 border-gray-300">


                <!-- SUPERADMIN -->

                <template v-if="role === 'superadmin'">

                    <p v-show="open" class="px-2 pt-4 text-xs font-semibold text-gray-400 uppercase">
                        Pentadbiran
                    </p>


                    <SidebarLink :href="urls.pengguna" :active="isPath('/admin/pengguna')" label=" Pengguna"
                        short-label="Pengguna" :open="open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-1a4 4 0 0 0-4-4h-1M9 20H4v-1a4 4 0 0 1 4-4h1m4-5a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm6 1a3 3 0 1 0 0-6" />
                        </svg>
                    </SidebarLink>


                    <SidebarLink :href="urls.bahagian" :active="isPath('/admin/bahagian')" label=" Bahagian"
                        short-label="Bahagian" :open="open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6M9 9h.01M15 9h.01M9 12h.01M15 12h.01" />
                        </svg>
                    </SidebarLink>


                    <SidebarLink :href="urls.ppkjPengesahan" :active="isPath('/ppkj/pengesahan')" label="Semakan PPKJ"
                        short-label="PPKJ" :open="open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m9 12 2 2 4-4m5 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </SidebarLink>

                </template>


                <!-- PKA -->

                <template v-if="role === 'pegawai_keselamatan_aras'">

                    <SidebarDropdown :active="isPath('/pka/jadual')" label="Jadual" short-label="Jadual" :open="open">

                        <template #icon>

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-6">
                                <path
                                    d="M12 11.993a.75.75 0 0 0-.75.75v.006c0 .414.336.75.75.75h.006a.75.75 0 0 0 .75-.75v-.006a.75.75 0 0 0-.75-.75H12ZM12 16.494a.75.75 0 0 0-.75.75v.005c0 .414.335.75.75.75h.005a.75.75 0 0 0 .75-.75v-.005a.75.75 0 0 0-.75-.75H12ZM8.999 17.244a.75.75 0 0 1 .75-.75h.006a.75.75 0 0 1 .75.75v.006a.75.75 0 0 1-.75.75h-.006a.75.75 0 0 1-.75-.75v-.006ZM7.499 16.494a.75.75 0 0 0-.75.75v.005c0 .414.336.75.75.75h.005a.75.75 0 0 0 .75-.75v-.005a.75.75 0 0 0-.75-.75H7.5ZM13.499 14.997a.75.75 0 0 1 .75-.75h.006a.75.75 0 0 1 .75.75v.005a.75.75 0 0 1-.75.75h-.006a.75.75 0 0 1-.75-.75v-.005ZM14.25 16.494a.75.75 0 0 0-.75.75v.006c0 .414.335.75.75.75h.005a.75.75 0 0 0 .75-.75v-.006a.75.75 0 0 0-.75-.75h-.005ZM15.75 14.995a.75.75 0 0 1 .75-.75h.005a.75.75 0 0 1 .75.75v.006a.75.75 0 0 1-.75.75H16.5a.75.75 0 0 1-.75-.75v-.006ZM13.498 12.743a.75.75 0 0 1 .75-.75h2.25a.75.75 0 1 1 0 1.5h-2.25a.75.75 0 0 1-.75-.75ZM6.748 14.993a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Z" />
                                <path fill-rule="evenodd"
                                    d="M18 2.993a.75.75 0 0 0-1.5 0v1.5h-9V2.994a.75.75 0 1 0-1.5 0v1.497h-.752a3 3 0 0 0-3 3v11.252a3 3 0 0 0 3 3h13.5a3 3 0 0 0 3-3V7.492a3 3 0 0 0-3-3H18V2.993ZM3.748 18.743v-7.5a1.5 1.5 0 0 1 1.5-1.5h13.5a1.5 1.5 0 0 1 1.5 1.5v7.5a1.5 1.5 0 0 1-1.5 1.5h-13.5a1.5 1.5 0 0 1-1.5-1.5Z"
                                    clip-rule="evenodd" />
                            </svg>


                        </template>


                        <a :href="urls.pkaJadual" class="block py-2 text-sm rounded-full transition-all duration-300"
                            :class="isPath('/pka/jadual')
                                ? 'bg-purple-100 text-purple-900 font-semibold pl-4 shadow-lg'
                                : 'text-purple-900 hover:bg-purple-200 hover:pl-5 hover:text-purple-900'"
                            :style="open ? {} : { textAlign: 'center' }">

                            <span v-show="open">Jadual</span>
                            <span v-show="!open">Jadual</span>

                        </a>


                        <a :href="urls.pkaJadualHarian"
                            class="block py-2 text-sm rounded-full transition-all duration-300" :class="isActive(urls.pkaJadualHarian)
                                ? 'bg-purple-100 text-purple-900 font-semibold pl-4 shadow-lg'
                                : 'text-purple-900 hover:bg-purple-200 hover:pl-5 hover:text-purple-900'">

                            <span v-show="open">- Harian</span>
                            <span v-show="!open">Hari</span>

                        </a>


                        <a :href="urls.pkaJadualMingguan"
                            class="block py-2 text-sm rounded-full transition-all duration-300" :class="isActive(urls.pkaJadualMingguan)
                                ? 'bg-purple-100 text-purple-900 font-semibold pl-4 shadow-lg'
                                : 'text-purple-900 hover:bg-purple-200 hover:pl-5 hover:text-purple-900'">

                            <span v-show="open">- Mingguan</span>
                            <span v-show="!open">Minggu</span>

                        </a>

                    </SidebarDropdown>


                    <SidebarLink :href="urls.pkaLaporan" :active="isPath('/pka/laporan')" label="Laporan"
                        short-label="Laporan" :open="open">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd"
                                d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z"
                                clip-rule="evenodd" />
                        </svg>

                    </SidebarLink>


                    <SidebarLink :href="urls.emails" :active="isActive(urls.emails)" label="Email" short-label="Email"
                        :open="open">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path
                                d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                            <path
                                d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                        </svg>

                    </SidebarLink>

                </template>


                <!-- PEGAWAI BERTUGAS -->

                <template v-if="role === 'pegawai_bertugas'">

                    <SidebarLink :href="urls.userJadual" :active="isPath('/user/jadual')" label="Jadual"
                        short-label="Jadual" :open="open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z" />
                        </svg>
                    </SidebarLink>


                    <SidebarLink :href="urls.userLaporan" :active="isPath('/user/laporan')" label=" Laporan"
                        short-label="Laporan" :open="open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2Z" />
                        </svg>
                    </SidebarLink>

                </template>


                <!-- PPKJ -->

                <template v-if="role === 'penolong_pegawai_keselamatan_jabatan'">

                    <SidebarLink :href="urls.ppkjPengesahan" :active="isPath('/ppkj/pengesahan')" label="Semakan PPKJ"
                        short-label="PPKJ" :open="open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m9 12 2 2 4-4m5 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </SidebarLink>

                </template>

            </nav>

        </div>

    </div>

</template>
