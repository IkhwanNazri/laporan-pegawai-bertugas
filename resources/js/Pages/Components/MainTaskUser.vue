<script setup>
import { ref } from 'vue'

const props = defineProps({
    jaduals: {
        type: Array,
        default: () => [],
    },
})

const openMenu = ref(null)


/*
|--------------------------------------------------------------------------
| STATUS JADUAL
|--------------------------------------------------------------------------
*/

function getStatus(jadual) {

    const laporan = jadual.laporan

    if (!laporan) {

        return {
            text: 'Isi Borang',
            class: 'bg-green-500 text-white',
            progress: 0,
        }

    }

    if (laporan.status_pengesahan === 'selesai') {

        return {
            text: 'Selesai',
            class: 'bg-green-400 text-black',
            progress: 100,
        }

    }

    if (laporan.status_tindakan_pka === 'menunggu_pka') {

        return {
            text: 'Menunggu PKA',
            class: 'bg-yellow-300 text-black',
            progress: 75,
        }

    }

    return {

        text: 'Menunggu',

        class: 'bg-pink-500 text-white',

        progress: 50,

    }
}


/*
|--------------------------------------------------------------------------
| FORMAT TARIKH
|--------------------------------------------------------------------------
*/

function formatTarikh(tarikh) {

    if (!tarikh) {
        return '-'
    }

    const date = new Date(tarikh)

    return date.toLocaleDateString('ms-MY', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
    })
}


function formatTarikhAkhir(jadual) {

    if (!jadual.tarikh) {
        return '-'
    }

    const date = new Date(jadual.tarikh)

    if ((jadual.jenis || '').toLowerCase() === 'mingguan') {

        date.setDate(date.getDate() + 6)

    }

    return date.toLocaleDateString('ms-MY', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
    })
}


/*
|--------------------------------------------------------------------------
| MENU
|--------------------------------------------------------------------------
*/

function bukaMenu(id) {

    if (openMenu.value === id) {

        openMenu.value = null

    } else {

        openMenu.value = id

    }
}


function tutupMenu() {

    openMenu.value = null

}


/*
|--------------------------------------------------------------------------
| REMINDER
|--------------------------------------------------------------------------
*/

function hantarReminder(jadual) {

    window.location.href = `/pka/jadual/${jadual.id}/reminder`

}
</script>


<template>

    <div class="font-['Poppins']">


        <!-- ====================================================== -->
        <!-- HEADER -->
        <!-- ====================================================== -->

        <div class="flex items-center justify-between mb-3 px-1">

            <div class="flex items-center gap-3">

                <h2 class="text-2xl font-bold font-['Poppins']">
                    Main Task
                </h2>


                <span class="text-lg text-purple-900">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">

                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />

                    </svg>

                </span>

            </div>

        </div>



        <!-- ====================================================== -->
        <!-- ADA JADUAL -->
        <!-- ====================================================== -->

        <template v-if="jaduals.length > 0">


            <div v-for="jadual in jaduals" :key="jadual.id"
                class="relative bg-white rounded-xl shadow-lg px-4 py-3 mb-4 flex items-center gap-5">


                <!-- USER ICON -->

                <div class="w-9 h-9 rounded-full bg-black flex items-center justify-center shrink-0">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 text-white">

                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.5-1.632z" />

                    </svg>

                </div>



                <!-- NAMA PEGAWAI -->

                <div class="w-24 font-semibold text-sm">

                    {{ jadual.pegawai?.name ?? 'Tiada Pegawai' }}

                </div>



                <!-- JENIS -->

                <div class="flex-1 text-blue-700 text-sm">

                    {{
                        jadual.jenis
                            ? jadual.jenis.charAt(0).toUpperCase() + jadual.jenis.slice(1)
                            : '-'
                    }}

                </div>



                <!-- TARIKH -->

                <div class="flex-1 text-blue-700 text-sm">

                    <template v-if="(jadual.jenis || '').toLowerCase() === 'mingguan'">

                        {{ formatTarikh(jadual.tarikh) }}

                        -

                        {{ formatTarikhAkhir(jadual) }}

                    </template>


                    <template v-else>

                        {{ formatTarikh(jadual.tarikh) }}

                    </template>

                </div>



                <!-- PROGRESS -->

                <div class="w-28">

                    <div class="text-[10px] text-gray-500 mb-1">

                        Progress
                        {{ getStatus(jadual).progress }}%

                    </div>


                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">

                        <div class="h-full bg-purple-600 rounded-full transition-all" :style="{
                            width: getStatus(jadual).progress + '%'
                        }"></div>

                    </div>

                </div>



                <!-- STATUS -->

                <div>

                    <!-- ISI BORANG -->

                    <a v-if="getStatus(jadual).text === 'Isi Borang'"
                        :href="`/user/laporan/laporanb?jadual_id=${jadual.id}`"
                        class="inline-flex items-center justify-center px-4 py-1.5 text-xs font-md text-white bg-green-600 space-x-2 gap-2 rounded-lg hover:bg-green-700 transition-all shadow-sm whitespace-nowrap">

                        <span>
                            Isi Borang
                        </span>


                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-3 h-3">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />

                        </svg>

                    </a>


                    <!-- STATUS LAIN -->

                    <span v-else :class="getStatus(jadual).class"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-md rounded-lg whitespace-nowrap">

                        <template v-if="getStatus(jadual).text === 'Selesai'">

                            ✓

                        </template>


                        <template v-else>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-3 h-3">

                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5" />

                                <circle cx="12" cy="12" r="9" />

                            </svg>

                        </template>


                        {{ getStatus(jadual).text }}

                    </span>

                </div>



                <!-- ================================================== -->
                <!-- MENU -->
                <!-- ================================================== -->

                <div class="relative">

                    <button type="button" @click="bukaMenu(jadual.id)"
                        class="p-2 rounded-lg hover:bg-gray-100 transition">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-gray-500">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.75h.008v.008H12V6.75zm0 5.25h.008v.008H12V12zm0 5.25h.008v.008H12V17.25z" />

                        </svg>

                    </button>



                    <!-- DROPDOWN -->

                    <div v-if="openMenu === jadual.id"
                        class="absolute right-0 top-10 z-50 w-48 bg-white rounded-xl shadow-xl border border-gray-200 p-2">

                        <div class="px-3 py-2 text-xs font-semibold text-gray-500 border-b">
                            Ingatkan Pegawai
                        </div>


                        <!-- ADA EMAIL -->

                        <template v-if="jadual.pegawai?.email">

                            <button type="button" @click="hantarReminder(jadual)"
                                class="w-full text-left block px-3 py-2 text-sm hover:bg-purple-50 rounded-lg">

                                Emel Pegawai

                            </button>

                        </template>


                        <!-- TIADA EMAIL -->

                        <div v-else class="px-3 py-2 text-xs text-gray-400">

                            Tiada emel pegawai

                        </div>

                    </div>

                </div>

            </div>

        </template>



        <!-- ====================================================== -->
        <!-- TIADA JADUAL -->
        <!-- ====================================================== -->

        <div v-else class="bg-white rounded-3xl p-6 text-center text-gray-400">

            Tiada jadual bertugas.

        </div>

    </div>

</template>
