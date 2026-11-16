<script setup>
import { onMounted, onBeforeUnmount, ref } from 'vue'

const props = defineProps({ events: { type: Array, default: () => [] } })

const el = ref(null)
const modal = ref(null) // data pegawai yang dipilih
let calendar = null

// Muat FullCalendar dari CDN sekali sahaja
const loadFullCalendar = () =>
    window.FullCalendar
        ? Promise.resolve()
        : new Promise((resolve, reject) => {
              const s = document.createElement('script')
              s.src = 'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.21/index.global.min.js'
              s.onload = resolve
              s.onerror = reject
              document.head.appendChild(s)
          })

const resize = () => calendar?.updateSize()

onMounted(async () => {
    await loadFullCalendar()
    calendar = new window.FullCalendar.Calendar(el.value, {
        initialView: 'dayGridMonth',
        locale: 'ms',
        firstDay: 1,
        height: 420,
        expandRows: true,
        headerToolbar: { left: 'prev,next', center: 'title', right: 'today' },
        buttonText: { today: 'Hari Ini' },
        events: props.events,
        dayMaxEvents: 2,
        eventClick(info) {
            info.jsEvent.preventDefault()
            modal.value = {
                ...info.event.extendedProps,
                tarikh: info.event.start?.toLocaleDateString('ms-MY', { day: 'numeric', month: 'long', year: 'numeric' }) ?? '-',
            }
        },
    })
    calendar.render()
    setTimeout(resize, 100)
    window.addEventListener('resize', resize)
})

onBeforeUnmount(() => {
    window.removeEventListener('resize', resize)
    calendar?.destroy()
})
</script>

<template>
    <div class="relative overflow-hidden rounded-3xl border border-white/70 bg-white/55 p-5 shadow-[0_8px_35px_rgba(88,28,135,0.08)] backdrop-blur-xl">
        <h2 class="font-['Poppins'] text-xl font-semibold tracking-tight text-gray-800">Kalendar Bertugas</h2>
        <p class="mt-1 mb-4 text-[11px] font-medium text-gray-500">Lihat jadual pegawai secara bulanan</p>
        <div ref="el" class="kalender w-full"></div>
    </div>

    <!-- MODAL PEGAWAI -->
    <Teleport to="body">
        <div v-if="modal" @keydown.esc="modal = null" class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" @click="modal = null"></div>
            <div class="relative w-full max-w-md rounded-[24px] border border-white/50 bg-white/80 backdrop-blur-2xl shadow-2xl font-[Poppins]">
                <div class="px-6 py-5 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800">Pegawai Bertugas</h3>
                        <p class="text-[10px] text-purple-900 mt-0.5">{{ modal.tarikh }}</p>
                    </div>
                    <button @click="modal = null" class="w-8 h-8 rounded-md hover:bg-gray-100 text-gray-800">✕</button>
                </div>
                <div class="px-6 pb-5 space-y-4 text-xs">
                    <div>
                        <p class="text-[10px] uppercase tracking-wide text-gray-800 font-medium">Nama Pegawai</p>
                        <p class="mt-0.5 text-sm font-semibold text-gray-800">{{ modal.pegawai }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-x-8 border-t border-gray-100 pt-4">
                        <div><p class="text-[10px] uppercase text-gray-800 font-medium">Bahagian</p><p class="mt-1 font-semibold text-gray-700">{{ modal.bahagian }}</p></div>
                        <div><p class="text-[10px] uppercase text-gray-800 font-medium">Aras</p><p class="mt-1 font-semibold text-gray-700">{{ modal.aras }}</p></div>
                    </div>
                    <div class="border-t border-gray-100 pt-4">
                        <p class="text-[10px] uppercase text-gray-800 font-medium">Jenis Tugasan</p>
                        <p class="mt-1 font-semibold text-purple-700">{{ modal.jenis }}</p>
                    </div>
                    <div class="border-t border-gray-100 pt-4">
                        <p class="text-[10px] uppercase text-gray-800 font-medium">No. Telefon</p>
                        <p class="mt-0.5 font-semibold text-gray-800">{{ modal.telefon }}</p>
                    </div>
                </div>
                <div class="px-6 pb-6">
                    <button @click="modal = null" class="w-full py-3 bg-purple-900 hover:bg-purple-800 text-white text-xs font-semibold tracking-widest">Tutup</button>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<style>
.kalender { font-size: 10px; }
.kalender .fc-toolbar { margin-bottom: 12px; }
.kalender .fc-toolbar-title { font-size: 15px !important; font-weight: 700 !important; color: #581c87 !important; }
.kalender .fc-button { background: #f3e8ff !important; border: none !important; color: #7c3aed !important; border-radius: 9999px !important; font-size: 9px !important; padding: 5px 9px !important; box-shadow: none !important; }
.kalender .fc-button:hover { background: #e9d5ff !important; }
.kalender .fc-button-active { background: #7c3aed !important; color: white !important; }
.kalender .fc-scrollgrid { border: none !important; }
.kalender td, .kalender th { border-color: transparent !important; }
.kalender .fc-col-header-cell { background: transparent !important; padding: 5px 0 !important; }
.kalender .fc-col-header-cell-cushion { color: #7c3aed !important; font-size: 9px !important; font-weight: 700 !important; text-decoration: none !important; }
.kalender .fc-daygrid-day { background: transparent !important; padding: 2px !important; min-height: 45px; }
.kalender .fc-daygrid-day-number { display: flex !important; align-items: center; justify-content: center; width: 27px; height: 27px; margin: 3px 3px 2px auto; border-radius: 9999px; color: #64748b; font-size: 10px; font-weight: 600; text-decoration: none !important; }
.kalender .fc-day-today { background: transparent !important; }
.kalender .fc-day-today .fc-daygrid-day-number { background: #7c3aed !important; color: white !important; }
.kalender .fc-day-other .fc-daygrid-day-number { opacity: .25; }
.kalender .fc-daygrid-event { border: none !important; border-radius: 9999px !important; margin: 2px 3px !important; padding: 3px 6px !important; font-size: 8px !important; font-weight: 600 !important; cursor: pointer; }
.kalender .fc-event-title { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.kalender .fc-more-link { color: #7c3aed !important; font-size: 8px !important; font-weight: 700; text-decoration: none !important; }
</style>
