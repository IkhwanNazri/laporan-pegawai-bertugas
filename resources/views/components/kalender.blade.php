@php
    $jadualEvents = \App\Models\Jadual::with(['pegawai', 'bahagian'])
        ->orderBy('tarikh')
        ->get()
        ->map(function ($jadual) {
            return [
                'id' => $jadual->id,
                'title' => $jadual->pegawai->name ?? 'Tiada Pegawai',
                'start' => $jadual->tarikh,
                'color' => strtolower($jadual->jenis ?? '') === 'mingguan' ? '#10b981' : '#3b82f6',
                'extendedProps' => [
                    'pegawai' => $jadual->pegawai->name ?? 'Tiada Pegawai',
                    'bahagian' => $jadual->bahagian->kod_bahagian ?? '-',
                    'aras' => $jadual->aras ?? '-',
                    'jenis' => ucfirst($jadual->jenis ?? 'Harian'),
                    'telefon' => $jadual->no_telefon ?? '-',
                ],
            ];
        })
        ->values();
@endphp

<div class="relative overflow-hidden rounded-3xl border border-white/70 bg-white/55 p-5 shadow-[0_8px_35px_rgba(88,28,135,0.08)] backdrop-blur-xl hover:shadow-md transition">
    <div class="pointer-events-none absolute -right-16 -top-16 h-32 w-32 rounded-full bg-purple-300/10 blur-2xl backdrop-blur-md"></div>

    <div class="relative mb-4">
        <h2 class="font-['Poppins'] text-xl font-semibold tracking-tight text-gray-800">
            Kalendar Bertugas
        </h2>

        <p class="mt-1 text-[11px] font-medium text-gray-500">
            Lihat jadual pegawai secara bulanan
        </p>
    </div>

    <div id="calendar" class="relative w-full"></div>
</div>
<div
    x-data="{
        open: false,
        pegawai: '',
        bahagian: '',
        aras: '',
        jenis: '',
        telefon: '',
        tarikh: '',
        show(data) {
            this.pegawai = data.pegawai;
            this.bahagian = data.bahagian;
            this.aras = data.aras;
            this.jenis = data.jenis;
            this.telefon = data.telefon;
            this.tarikh = data.tarikh;
            this.open = true;
        },
        close() {
            this.open = false;
        }
    }"
    x-init="
        window.addEventListener('open-pegawai-modal', event => {
            show(event.detail);
        });
    "
    x-show="open"
    x-cloak
    @keydown.escape.window="close()"
    class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
>
    <div
        class="absolute inset-0 bg-black/30 backdrop-blur-sm"
        @click="close()"
    ></div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-3"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-3"
       class="relative w-full max-w-md overflow-hidden rounded-[24px] border border-white/50 bg-white/30 backdrop-blur-2xl shadow-[0_25px_80px_rgba(31,38,135,0.18)] ring-1 ring-white/30 font-[Poppins]"
    >
        <div class=" px-6 py-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-md bg-white/10 flex items-center justify-center">
                        <x-heroicon-o-calendar-days class="w-5 h-5 text-gray-800" />
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800">
                            Pegawai Bertugas
                        </h3>
                        <p
                            class="text-[10px] text-purple-900 mt-0.5"
                            x-text="tarikh"
                        ></p>
                    </div>
                </div>

                <button
                    @click="close()"
                    class="w-8 h-8 rounded-md bg-white/10 hover:bg-white/20 flex items-center justify-center transition"
                >
                    <x-heroicon-o-x-mark class="w-4 h-4 text-gray-800" />
                </button>
            </div>
        </div>

        <div class="px-6 py-5 space-y-5">

                {{-- PEGAWAI --}}
                <div class="flex items-center gap-4">
                    <div class="shrink-0 text-purple-700">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            class="w-10 h-10">
                            <path fill-rule="evenodd"
                                d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p class="text-[10px] uppercase tracking-wide text-gray-800 font-medium">
                            Nama Pegawai
                        </p>

                        <p
                            class="mt-0.5 text-sm font-semibold text-gray-800 truncate"
                            x-text="pegawai"
                        ></p>
                    </div>
                </div>

                {{-- MAKLUMAT --}}
                <div class="grid grid-cols-2 gap-x-8 border-t border-gray-100 pt-4">

                    <div>
                        <p class="text-[10px] uppercase tracking-wide text-gray-800 font-medium">
                            Bahagian
                        </p>

                        <p
                            class="mt-1 text-xs font-semibold text-gray-700"
                            x-text="bahagian"
                        ></p>
                    </div>

                    <div>
                        <p class="text-[10px] uppercase tracking-wide text-gray-800 font-medium">
                            Aras
                        </p>

                        <p
                            class="mt-1 text-xs font-semibold text-gray-700"
                            x-text="aras"
                        ></p>
                    </div>

                </div>

                {{-- JENIS --}}
                <div class="flex items-center justify-between border-t border-gray-100 pt-4">

                    <div>
                        <p class="text-[10px] uppercase tracking-wide text-gray-800 font-medium">
                            Jenis Tugasan
                        </p>

                        <p
                            class="mt-1 text-xs font-semibold text-gray-700"
                            x-text="jenis"
                        ></p>
                    </div>

                    <span
                        class="text-[10px] font-semibold text-purple-700"
                        x-text="jenis"
                    ></span>

                </div>

                {{-- TELEFON --}}
                <div class="flex items-center gap-3 border-t border-gray-100 pt-4">

                    <x-heroicon-o-phone class="w-4 h-4 text-gray-400 shrink-0" />

                    <div>
                        <p class="text-[10px] uppercase tracking-wide text-gray-800 font-medium">
                            No. Telefon
                        </p>

                        <p
                            class="mt-0.5 text-xs font-semibold text-gray-800"
                            x-text="telefon"
                        ></p>
                    </div>

                </div>

            </div>

        <div class="px-6 pb-6">
            <button
                @click="close()"
                class="w-full py-3 bg-purple-900 shadow-lg hover:bg-purple-800 text-white text-xs font-semisemibold tracking-widest transition"
            >
                Tutup
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.21/index.global.min.js"></script>

<script>
function initCalendar() {
    const el = document.getElementById('calendar');

    if (!el || el.dataset.initialized === 'true') return;

    el.dataset.initialized = 'true';

    const calendar = new FullCalendar.Calendar(el, {
        initialView: 'dayGridMonth',
        locale: 'ms',
        firstDay: 1,
        height: 420,
        expandRows: true,
        contentHeight: 'auto',
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'today'
        },
        buttonText: {
            today: 'Hari Ini'
        },
        events: @json($jadualEvents),
        dayMaxEvents: 2,

        eventClick(info) {
            info.jsEvent.preventDefault();

            const data = info.event.extendedProps;
            const tarikh = info.event.start
                ? info.event.start.toLocaleDateString('ms-MY', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                })
                : '-';

            window.dispatchEvent(new CustomEvent('open-pegawai-modal', {
                detail: {
                    pegawai: data.pegawai,
                    bahagian: data.bahagian,
                    aras: data.aras,
                    jenis: data.jenis,
                    telefon: data.telefon,
                    tarikh: tarikh
                }
            }));
        }
    });

    calendar.render();

    setTimeout(() => calendar.updateSize(), 100);
    setTimeout(() => calendar.updateSize(), 500);

    window.addEventListener('resize', () => {
        calendar.updateSize();
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCalendar);
} else {
    initCalendar();
}
</script>

<style>
[x-cloak] {
    display: none !important;
}

#calendar {
    width: 100% !important;
    font-size: 10px;
}

#calendar .fc-toolbar {
    margin-bottom: 12px;
}

#calendar .fc-toolbar-title {
    font-size: 15px !important;
    font-weight: 700 !important;
    color: #581c87 !important;
}

#calendar .fc-button {
    background: #f3e8ff !important;
    border: none !important;
    color: #7c3aed !important;
    border-radius: 9999px !important;
    font-size: 9px !important;
    padding: 5px 9px !important;
    box-shadow: none !important;
}

#calendar .fc-button:hover {
    background: #e9d5ff !important;
}

#calendar .fc-button-active {
    background: #7c3aed !important;
    color: white !important;
}

#calendar .fc-scrollgrid {
    border: none !important;
}

#calendar td,
#calendar th {
    border-color: transparent !important;
}

#calendar .fc-col-header-cell {
    background: transparent !important;
    padding: 5px 0 !important;
}

#calendar .fc-col-header-cell-cushion {
    color: #7c3aed !important;
    font-size: 9px !important;
    font-weight: 700 !important;
    text-decoration: none !important;
}

#calendar .fc-daygrid-day {
    background: transparent !important;
    border: none !important;
    padding: 2px !important;
    min-height: 45px;
}

#calendar .fc-daygrid-day-number {
    display: flex !important;
    align-items: center;
    justify-content: center;
    width: 27px;
    height: 27px;
    margin: 3px 3px 2px auto;
    border-radius: 9999px;
    color: #64748b;
    font-size: 10px;
    font-weight: 600;
    text-decoration: none !important;
}

#calendar .fc-day-today {
    background: transparent !important;
}

#calendar .fc-day-today .fc-daygrid-day-number {
    background: #7c3aed !important;
    color: white !important;
}

#calendar .fc-day-other .fc-daygrid-day-number {
    opacity: .25;
}

#calendar .fc-daygrid-event {
    border: none !important;
    border-radius: 9999px !important;
    margin: 2px 3px !important;
    padding: 3px 6px !important;
    font-size: 8px !important;
    font-weight: 600 !important;
    cursor: pointer;
    transition: transform .15s ease, opacity .15s ease;
}

#calendar .fc-daygrid-event:hover {
    transform: translateY(-1px);
    opacity: .85;
}

#calendar .fc-event-title {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

#calendar .fc-more-link {
    color: #7c3aed !important;
    font-size: 8px !important;
    font-weight: 700;
    text-decoration: none !important;
}
</style>
