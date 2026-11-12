<script setup>
import { ref, computed } from 'vue'
import Header from '../../Components/Header.vue'

const props = defineProps({
    jaduals: {
        type: Object,
        default: () => ({
            data: [],
            links: [],
        }),
    },
})

const selectedIds = ref([])
const selectAll = ref(false)

const currentMonth = computed(() => {
    return new Intl.DateTimeFormat('ms-MY', {
        month: 'long',
    }).format(new Date())
})

const jadualList = computed(() => {
    return props.jaduals?.data ?? []
})

const toggleSelectAll = () => {
    if (selectAll.value) {
        selectedIds.value = jadualList.value.map(jadual => jadual.id)
    } else {
        selectedIds.value = []
    }
}

const toggleSelect = (id) => {
    if (selectedIds.value.includes(id)) {
        selectedIds.value = selectedIds.value.filter(item => item !== id)
    } else {
        selectedIds.value.push(id)
    }

    selectAll.value =
        jadualList.value.length > 0 &&
        selectedIds.value.length === jadualList.value.length
}

const isSelected = (id) => {
    return selectedIds.value.includes(id)
}

const getJenis = (jadual) => {
    return String(jadual.jenis ?? '').toLowerCase()
}

const formatDate = (date) => {
    if (!date) return '-'

    return new Intl.DateTimeFormat('ms-MY', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
    }).format(new Date(date))
}

const formatDay = (date) => {
    if (!date) return '-'

    return new Intl.DateTimeFormat('ms-MY', {
        weekday: 'long',
    }).format(new Date(date))
}

const formatDateRange = (jadual) => {
    if (getJenis(jadual) === 'mingguan') {
        return `${formatDate(jadual.tarikh_mula)} - ${formatDate(jadual.tarikh_tamat)}`
    }

    return formatDate(jadual.tarikh)
}

const formatDayRange = (jadual) => {
    if (getJenis(jadual) === 'mingguan') {
        return `${formatDay(jadual.tarikh_mula)} - ${formatDay(jadual.tarikh_tamat)}`
    }

    return formatDay(jadual.tarikh)
}

const viewJadual = (jadual) => {
    console.log('View jadual:', jadual)

    // Modal kita sambung selepas ini
}

const sendReminder = (jadual) => {
    const form = document.getElementById(`reminder-form-${jadual.id}`)

    if (form) {
        form.submit()
    }
}

const deleteJadual = (jadual) => {
    if (!confirm('Anda pasti mahu memadam jadual ini?')) {
        return
    }

    const form = document.getElementById(`delete-form-${jadual.id}`)

    if (form) {
        form.submit()
    }
}

const submitBulkEmail = () => {
    if (selectedIds.value.length === 0) {
        alert('Sila pilih sekurang-kurangnya satu jadual terlebih dahulu.')
        return
    }

    if (!confirm(`Hantar emel kepada ${selectedIds.value.length} pegawai yang dipilih?`)) {
        return
    }

    const form = document.getElementById('bulkEmailForm')

    if (form) {
        selectedIds.value.forEach(id => {
            const input = document.createElement('input')
            input.type = 'hidden'
            input.name = 'ids[]'
            input.value = id
            input.classList.add('bulk-id')

            form.appendChild(input)
        })

        form.submit()
    }
}

const submitBulkDelete = () => {
    if (selectedIds.value.length === 0) {
        alert('Sila pilih sekurang-kurangnya satu jadual terlebih dahulu.')
        return
    }

    if (!confirm(`Anda pasti mahu memadam ${selectedIds.value.length} jadual yang dipilih?`)) {
        return
    }

    const form = document.getElementById('bulkDeleteForm')

    if (form) {
        selectedIds.value.forEach(id => {
            const input = document.createElement('input')
            input.type = 'hidden'
            input.name = 'ids[]'
            input.value = id
            input.classList.add('bulk-id')

            form.appendChild(input)
        })

        form.submit()
    }
}

const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    ?.getAttribute('content')
</script>

<template>
    <div class="py-8 min-h-screen bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px]">
        <Sidebar :user="user" />

        <div class="max-w-full px-4 sm:px-6 lg:px-8 space-y-6">
            <Header :user="user" :notifications="notifications" :unread-count="unreadCount" :profile-url="profileUrl"
                :logout-url="logoutUrl" :notifications-read-url="notificationsReadUrl" />

            <!-- HEADER -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        Jadual Sistem Pegawai Bertugas
                    </h1>

                    <div class="flex items-center gap-2 text-sm text-gray-500 mt-1">
                        <span>Jadual</span>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2">

                    <!-- EXPORT PDF -->
                    <a href="#"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>

                        Export PDF
                    </a>

                    <!-- TAMBAH JADUAL -->
                    <a href="/pka/jadual/pilihan"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-purple-700 text-white rounded-lg hover:bg-purple-800 transition">
                        <span class="text-lg">+</span>
                        Tambah Jadual
                    </a>

                </div>
            </div>


            <!-- MAIN CARD -->
            <div class="bg-white rounded-2xl shadow-sm border justify-between border-gray-200 overflow-hidden">

                <!-- CARD HEADER -->
                <div
                    class="px-6 py-5 border-b border-gray-200 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                    <div>
                        <h2 class="text-xl font-bold text-gray-800">
                            Jadual Bulanan
                        </h2>

                        <p class="text-sm text-gray-500 mt-1 capitalize">
                            {{ currentMonth }}
                        </p>
                    </div>


                    <!-- ACTION BUTTONS -->
                    <div class="flex items-center gap-2">

                        <!-- BULK EMAIL -->
                        <form id="bulkEmailForm" action="/pka/jadual/bulk-email" method="POST">
                            <input type="hidden" name="_token" :value="csrfToken">

                            <button type="button" @click="submitBulkEmail"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-purple-700 text-white rounded-lg hover:bg-purple-800 transition"
                                title="Pilih Emel">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>

                                Hantar Emel
                            </button>
                        </form>


                        <!-- BULK DELETE -->
                        <form id="bulkDeleteForm" action="/pka/jadual/bulk-delete" method="POST">
                            <input type="hidden" name="_token" :value="csrfToken">

                            <button type="button" @click="submitBulkDelete"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h10" />
                                </svg>

                                Padam
                            </button>
                        </form>

                    </div>
                </div>


                <!-- TABLE -->
                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">

                            <tr>

                                <!-- SELECT ALL -->
                                <th class="px-6 py-4 text-left">
                                    <input v-model="selectAll" @change="toggleSelectAll" type="checkbox"
                                        class="rounded border-gray-300 text-purple-700 focus:ring-purple-500">
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Tarikh
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Hari
                                </th>

                                <th class="px-6 py-4"></th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Nama
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Emel
                                </th>

                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Hantar Emel
                                </th>

                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Tindakan
                                </th>

                            </tr>

                        </thead>


                        <tbody class="bg-white divide-y divide-gray-200">

                            <!-- RECORD -->
                            <tr v-for="jadual in jadualList" :key="jadual.id" class="hover:bg-gray-50 transition">

                                <!-- CHECKBOX -->
                                <td class="px-6 py-4">

                                    <input type="checkbox" :value="jadual.id" :checked="isSelected(jadual.id)"
                                        @change="toggleSelect(jadual.id)"
                                        class="jadual-checkbox rounded border-gray-300 text-purple-700 focus:ring-purple-500">

                                </td>


                                <!-- TARIKH -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">

                                    {{ formatDateRange(jadual) }}

                                </td>


                                <!-- HARI -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">

                                    {{ formatDayRange(jadual) }}

                                </td>


                                <!-- EMPTY -->
                                <td class="px-6 py-4"></td>


                                <!-- NAMA -->
                                <td class="px-6 py-4 text-sm font-medium text-gray-800">

                                    {{ jadual.pegawai?.name ?? '-' }}

                                </td>


                                <!-- EMAIL -->
                                <td class="px-6 py-4 text-sm text-gray-600">

                                    {{ jadual.pegawai?.email ?? '-' }}

                                </td>


                                <!-- REMINDER -->
                                <td class="px-6 py-4 text-center">

                                    <template v-if="jadual.pegawai?.email">

                                        <form :id="`reminder-form-${jadual.id}`"
                                            :action="`/pka/jadual/${jadual.id}/reminder`" method="POST" class="inline">

                                            <input type="hidden" name="_token" :value="csrfToken">

                                            <button type="button" @click="sendReminder(jadual)"
                                                class="inline-flex items-center px-3 py-1.5 bg-purple-700 text-white text-sm rounded-lg hover:bg-purple-800 transition">
                                                Hantar
                                            </button>

                                        </form>

                                    </template>

                                    <span v-else class="text-sm text-gray-400">
                                        Tiada Emel
                                    </span>

                                </td>


                                <!-- ACTION -->
                                <td class="px-6 py-4">

                                    <div class="flex items-center justify-center gap-2">

                                        <!-- VIEW -->
                                        <button type="button" @click="viewJadual(jadual)"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                            title="Lihat">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>


                                        <!-- EDIT -->
                                        <a :href="`/pka/jadual/${jadual.id}/edit`"
                                            class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-8.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 8.5-8.5z" />
                                            </svg>
                                        </a>


                                        <!-- DELETE -->
                                        <form :id="`delete-form-${jadual.id}`" :action="`/pka/jadual/${jadual.id}`"
                                            method="POST" class="inline">

                                            <input type="hidden" name="_token" :value="csrfToken">

                                            <input type="hidden" name="_method" value="DELETE">

                                            <button type="button" @click="deleteJadual(jadual)"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                                title="Padam">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4h10M10 11v6m4-6v6M9 7V4h6v3" />
                                                </svg>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>


                            <!-- EMPTY -->
                            <tr v-if="jadualList.length === 0">

                                <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                    Tiada rekod jadual harian ditemui.
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>


                <!-- PAGINATION -->
                <div v-if="jaduals?.links?.length" class="px-6 py-4 border-t border-gray-200">

                    <div class="flex flex-wrap items-center gap-2">

                        <template v-for="(link, index) in jaduals.links" :key="index">

                            <a v-if="link.url" :href="link.url" v-html="link.label"
                                class="px-3 py-2 text-sm rounded-lg border border-gray-200 hover:bg-gray-50 transition"
                                :class="{
                                    'bg-purple-700 text-white border-purple-700':
                                        link.active
                                }"></a>

                            <span v-else v-html="link.label"
                                class="px-3 py-2 text-sm rounded-lg border border-gray-200 text-gray-400"></span>

                        </template>

                    </div>

                </div>

            </div>

        </div>

    </div>
</template>
