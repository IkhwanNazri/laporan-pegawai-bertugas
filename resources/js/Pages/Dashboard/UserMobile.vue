<script setup>
import { computed, ref } from 'vue'

const activeTab = ref('home')

const props = defineProps({
    user: {
        type: Object,
        default: null,
    },
})

const userFirstName = computed(() => {
    return props.user?.name?.split(' ')[0] ?? 'Pengguna'
})

const userInitial = computed(() => {
    return props.user?.name?.charAt(0) ?? 'U'
})
</script>

<template>
    <div
        class="relative min-h-screen w-full max-w-md mx-auto bg-gray-50 shadow-xl sm:border-x sm:border-gray-200 flex flex-col pb-20">


        <header class="bg-purple-900 text-white px-5 py-4 sticky top-0 z-40 rounded-b-2xl shadow-md">
            <div class="flex justify-between items-center">

                <div>
                    <p class="text-xs text-purple-200 font-medium uppercase tracking-wider">
                        Selamat Bertugas
                    </p>

                    <h1 class="text-lg font-bold">
                        {{ userFirstName }} 👋
                    </h1>
                </div>

                <div
                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-purple-900 font-bold shadow-inner">
                    {{ userInitial }}
                </div>

            </div>
        </header>


        <!-- CONTENT -->
        <main class="flex-1 overflow-y-auto p-5 space-y-6">

            <!-- LAPORAN -->
            <div v-show="activeTab === 'home'" class="space-y-4">

                <h2 class="text-gray-800 font-extrabold text-lg border-b border-gray-200 pb-2">
                    Borang Laporan Baru
                </h2>

                <form action="#" method="POST"
                    class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 space-y-4">

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">
                            Pilih Jadual Hari Ini
                        </label>

                        <select name="jadual_id"
                            class="w-full text-sm border-gray-300 rounded-xl focus:ring-purple-500 focus:border-purple-500 bg-gray-50">
                            <option value="">
                                -- Sila Pilih --
                            </option>

                            <option value="1">
                                14 Ogos 2026 - Aras 3 (BPM)
                            </option>
                        </select>
                    </div>


                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">
                            Ulasan / Laporan Keselamatan
                        </label>

                        <textarea name="ulasan" rows="4" placeholder="Tiada sebarang insiden berlaku..."
                            class="w-full text-sm border-gray-300 rounded-xl focus:ring-purple-500 focus:border-purple-500 bg-gray-50"></textarea>
                    </div>


                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">
                            Gambar Bukti (Jika Ada)
                        </label>

                        <input type="file" name="gambar"
                            class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                    </div>


                    <button type="submit"
                        class="w-full bg-purple-900 text-white font-bold py-3 rounded-xl shadow-md hover:bg-purple-800 transition active:scale-95">
                        Hantar Laporan
                    </button>

                </form>
            </div>


            <!-- JADUAL -->
            <div v-show="activeTab === 'jadual'" class="space-y-4">

                <h2 class="text-gray-800 font-extrabold text-lg border-b border-gray-200 pb-2">
                    Jadual Bertugas Anda
                </h2>


                <div
                    class="bg-white p-4 rounded-2xl shadow-sm border border-l-4 border-l-emerald-500 flex justify-between items-center">

                    <div>
                        <p class="text-xs text-gray-500 font-semibold mb-1">
                            Jumaat, 14 Ogos 2026
                        </p>

                        <p class="font-bold text-gray-800">
                            Aras 3
                        </p>

                        <p class="text-xs text-gray-600">
                            Bahagian: BPM
                        </p>
                    </div>

                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-full">
                        Hari Ini
                    </span>

                </div>


                <div
                    class="bg-white p-4 rounded-2xl shadow-sm border border-l-4 border-l-blue-500 flex justify-between items-center opacity-80">

                    <div>
                        <p class="text-xs text-gray-500 font-semibold mb-1">
                            Isnin, 17 Ogos 2026
                        </p>

                        <p class="font-bold text-gray-800">
                            Aras 5
                        </p>

                        <p class="text-xs text-gray-600">
                            Bahagian: BKP
                        </p>
                    </div>

                    <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold rounded-full">
                        Akan Datang
                    </span>

                </div>

            </div>


            <!-- NOTIFIKASI -->
            <div v-show="activeTab === 'notifikasi'" class="space-y-4">

                <h2 class="text-gray-800 font-extrabold text-lg border-b border-gray-200 pb-2">
                    Notifikasi Terkini
                </h2>


                <div
                    class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex gap-3 relative overflow-hidden">

                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-purple-500"></div>

                    <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0z" />
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-bold text-gray-800">
                            Laporan Disahkan
                        </p>

                        <p class="text-xs text-gray-500 mt-0.5">
                            Laporan anda bertarikh 10 Ogos telah disahkan oleh PPKJ.
                        </p>

                        <p class="text-[10px] text-gray-400 mt-1 font-semibold">
                            2 jam lepas
                        </p>
                    </div>

                </div>


                <div
                    class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex gap-3 relative overflow-hidden">

                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-blue-500"></div>

                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-bold text-gray-800">
                            Jadual Baru
                        </p>

                        <p class="text-xs text-gray-500 mt-0.5">
                            Anda telah ditugaskan di Aras 5 pada 17 Ogos 2026.
                        </p>

                        <p class="text-[10px] text-gray-400 mt-1 font-semibold">
                            1 hari lepas
                        </p>
                    </div>

                </div>

            </div>

        </main>


        <!-- BOTTOM NAVIGATION -->
        <nav
            class="fixed bottom-0 left-0 right-0 w-full max-w-md mx-auto bg-white border-t border-gray-200 flex justify-around items-center px-2 py-3 z-50 rounded-t-2xl shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">

            <button @click="activeTab = 'home'" class="flex flex-col items-center gap-1 p-2 w-16 transition-colors"
                :class="activeTab === 'home' ? 'text-purple-700' : 'text-gray-400 hover:text-gray-600'">
                <span class="text-[10px] font-bold">
                    Laporan
                </span>
            </button>


            <button @click="activeTab = 'jadual'" class="flex flex-col items-center gap-1 p-2 w-16 transition-colors"
                :class="activeTab === 'jadual' ? 'text-purple-700' : 'text-gray-400 hover:text-gray-600'">
                <span class="text-[10px] font-bold">
                    Jadual
                </span>
            </button>


            <button @click="activeTab = 'notifikasi'"
                class="flex flex-col items-center gap-1 p-2 w-16 transition-colors relative"
                :class="activeTab === 'notifikasi' ? 'text-purple-700' : 'text-gray-400 hover:text-gray-600'">

                <span class="absolute top-2 right-4 w-2 h-2 bg-red-500 rounded-full border border-white"></span>

                <span class="text-[10px] font-bold">
                    Notis
                </span>

            </button>

        </nav>

    </div>
</template>
