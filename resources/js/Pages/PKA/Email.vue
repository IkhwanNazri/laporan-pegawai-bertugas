<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '../../Layouts/AppLayout.vue'

const props = defineProps({
    emails: { type: Array, default: () => [] },
    unread: { type: Number, default: 0 },
})

const aktif = ref(null)
const urlIframe = ref('/pka/email-raw')

const buka = (email) => {
    aktif.value = email.id
    email.unread = false
    urlIframe.value = `/pka/email-raw/${email.id}?t=${Date.now()}`
}

const muatSemula = () => router.reload({ only: ['emails', 'unread'] })
</script>

<template>
    <AppLayout>
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800">📥 Peti Masuk E-mel</h2>
            <button @click="muatSemula"
                class="px-3 py-1.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-purple-50 hover:text-purple-700">
                ⟳ Muat Semula
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex h-[750px]">
            <!-- SENARAI INBOX -->
            <div class="w-1/3 border-r border-gray-200 flex flex-col">
                <div class="p-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                    <span class="font-bold text-gray-700 text-sm">Inbox Utama</span>
                    <span v-if="unread" class="text-xs bg-purple-100 text-purple-700 px-2.5 py-1 rounded-full font-bold">{{ unread }} Baru</span>
                </div>

                <div class="flex-1 overflow-y-auto divide-y divide-gray-100">
                    <div v-for="e in emails" :key="e.id" @click="buka(e)"
                        :class="['p-4 cursor-pointer border-l-4 transition-colors',
                            aktif === e.id ? 'bg-purple-50 border-purple-500' : 'hover:bg-gray-50 border-transparent']">
                        <div class="flex justify-between items-baseline mb-0.5">
                            <p :class="['text-sm truncate', e.unread ? 'font-bold text-gray-900' : 'text-gray-600']">Sistem PKA</p>
                            <p :class="['text-[10px]', e.unread ? 'font-bold text-purple-600' : 'text-gray-400']">{{ e.masa }}</p>
                        </div>
                        <p :class="['text-xs truncate', e.unread ? 'font-bold text-gray-800' : 'text-gray-500']">{{ e.tajuk }}</p>
                        <p class="text-xs text-gray-400 truncate mt-0.5">{{ e.mesej }}</p>
                    </div>

                    <div v-if="!emails.length" class="p-8 text-center text-gray-400 text-sm">Peti masuk anda kosong.</div>
                </div>
            </div>

            <!-- PAPARAN E-MEL -->
            <div class="w-2/3 bg-gray-50 flex flex-col">
                <div class="p-3 border-b border-gray-200 bg-white h-14 flex items-center justify-end">
                    <span class="text-xs text-gray-400 font-medium">Paparan Interaktif</span>
                </div>
                <iframe :src="urlIframe" class="w-full flex-1 border-0 bg-white" title="Paparan Sebenar" />
            </div>
        </div>
    </AppLayout>
</template>
