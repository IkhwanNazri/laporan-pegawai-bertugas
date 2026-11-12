<script setup>
import { ref } from 'vue'

const props = defineProps({
    active: {
        type: Boolean,
        default: false,
    },

    label: {
        type: String,
        required: true,
    },

    shortLabel: {
        type: String,
        default: null,
    },

    open: {
        type: Boolean,
        default: true,
    },
})

const dropdownOpen = ref(false)
</script>

<template>

    <div class="w-full">

        <button type="button" @click="dropdownOpen = !dropdownOpen" :class="[
            open
                ? 'flex-row px-4 py-3 rounded-full'
                : 'flex-col w-20 h-20 p-2 rounded-full justify-center text-center',

            active
                ? 'bg-purple-900 text-white shadow-lg'
                : 'bg-white/40 text-purple-800 hover:text-white hover:shadow-inner hover:shadow-black/90'
        ]" class="relative overflow-hidden group flex items-center w-full transition-colors duration-300">

            <span
                class="absolute left-0 top-0 h-full w-0 bg-purple-800 transition-all duration-300 ease-out group-hover:w-full shadow-inner shadow-black/90"></span>

            <div class="relative z-10 flex items-center w-full" :class="!open && 'flex-col justify-center'">

                <div :class="open
                    ? 'w-6 h-6'
                    : 'w-8 h-8 mx-auto mb-1'"
                    class="flex justify-center items-center transition-transform duration-200 group-hover:scale-110">
                    <slot name="icon" />
                </div>

                <span v-show="open" class="mx-3 font-medium text-sm whitespace-nowrap flex-1 text-left">
                    {{ label }}
                </span>

                <span v-show="!open" class="text-[10px] font-medium w-full block leading-tight">
                    {{ shortLabel ?? label }}
                </span>

                <svg v-show="open" class="w-4 h-4 transition-transform duration-200"
                    :class="dropdownOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                </svg>

            </div>

        </button>


        <div v-show="dropdownOpen && open" class="mt-2 space-y-1">
            <slot />
        </div>

    </div>

</template>
