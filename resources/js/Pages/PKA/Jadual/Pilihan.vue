<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '../../../Layouts/AppLayout.vue'

// Class ditulis penuh supaya Tailwind boleh scan
const cards = [
    {
        href: '/pka/jadual/harian',
        title: 'Jadual Harian',
        lead: 'Tetapkan tugasan harian',
        desc: 'secara spesifik mengikut tarikh, bahagian, aras dan pegawai bertugas untuk kawalan keselamatan.',
        icon: 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5',
        card: 'border-purple-100 hover:border-purple-300 hover:shadow-purple-200/50 hover:-rotate-1',
        bg: 'from-purple-50/80 to-purple-100/30',
        ring: 'border-purple-300',
        badge: 'from-purple-900 to-purple-800 border-purple-200',
        text: 'text-purple-950',
        line: 'via-purple-400',
        dot: 'bg-purple-600',
    },
    {
        href: '/pka/jadual/mingguan',
        title: 'Jadual Mingguan',
        lead: 'Penjadualan secara bertempoh',
        desc: 'untuk giliran mingguan, memudahkan pemantauan berkala dan susunan jadual jangka panjang.',
        icon: 'M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122',
        card: 'border-emerald-100 hover:border-emerald-300 hover:shadow-emerald-200/50 hover:rotate-1',
        bg: 'from-emerald-50/80 to-emerald-100/30',
        ring: 'border-emerald-300',
        badge: 'from-emerald-800 to-emerald-700 border-emerald-200',
        text: 'text-emerald-950',
        line: 'via-emerald-400',
        dot: 'bg-emerald-600',
    },
]
</script>

<template>
    <AppLayout title="Jadual Sistem Pegawai Bertugas">
        <div class="flex flex-col md:flex-row items-center justify-center gap-8 pt-6 pb-12">
            <Link v-for="c in cards" :key="c.href" :href="c.href"
                class="group transform transition-all duration-500 hover:scale-105">
                <div :class="['relative overflow-hidden rounded-3xl border bg-white shadow-xl hover:shadow-2xl duration-700 w-[340px] sm:w-[360px]', c.card]">
                    <div :class="['absolute inset-0 bg-gradient-to-tr opacity-60 group-hover:opacity-100 transition-opacity duration-500', c.bg]" />

                    <div class="relative z-10 p-8 flex flex-col items-center text-center">
                        <div class="relative mb-6">
                            <div :class="['absolute inset-0 rounded-full border-2 animate-ping', c.ring]" />
                            <div :class="['p-6 rounded-full border bg-gradient-to-br text-white shadow-lg group-hover:rotate-12 group-hover:scale-110 transition-all duration-500', c.badge]">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" :d="c.icon" />
                                </svg>
                            </div>
                        </div>

                        <p :class="['mb-3 text-2xl font-black tracking-wider uppercase', c.text]">{{ c.title }}</p>
                        <p class="text-slate-700 text-sm font-semibold">{{ c.lead }}</p>
                        <p class="text-slate-500 text-xs leading-relaxed max-w-[240px]">{{ c.desc }}</p>

                        <div :class="['mt-6 w-1/3 h-0.5 bg-gradient-to-r from-transparent to-transparent rounded-full group-hover:w-1/2 transition-all duration-500', c.line]" />

                        <div class="flex space-x-2 mt-4 opacity-70 group-hover:opacity-100">
                            <div v-for="n in 3" :key="n" :class="['w-2 h-2 rounded-full animate-bounce', c.dot]"
                                :style="{ animationDelay: `${(n - 1) * 0.1}s` }" />
                        </div>
                    </div>
                </div>
            </Link>
        </div>
    </AppLayout>
</template>
