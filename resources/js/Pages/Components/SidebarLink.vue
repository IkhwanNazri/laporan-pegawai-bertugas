<script setup>
defineProps({
    href: {
        type: String,
        required: true,
    },
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
</script>

<template>
    <a :href="href" :class="[
        open
            ? 'flex-row px-4 py-3 rounded-full'
            : 'flex-col w-20 h-20 p-2 rounded-full justify-center text-center',

        active
            ? 'bg-purple-900 text-white shadow-lg'
            : 'bg-white/40 text-purple-800 hover:text-white hover:shadow-inner hover:shadow-black/90'
    ]" class="relative overflow-hidden group flex items-center transition-colors duration-300">

        <span
            class="absolute left-0 top-0 h-full w-0 bg-purple-800 transition-all duration-300 ease-out group-hover:w-full shadow-inner shadow-black/90"></span>

        <div class="relative z-10 flex items-center w-full" :class="!open && 'flex-col justify-center'">

            <div :class="open
                ? 'w-6 h-6'
                : 'w-8 h-8 mx-auto mb-1'"
                class="flex justify-center items-center transition-transform duration-200 group-hover:scale-110">
                <slot />
            </div>

            <span v-show="open" class="mx-3 font-medium text-sm whitespace-nowrap">
                {{ label }}
            </span>

            <span v-show="!open" class="text-[10px] font-medium w-full block leading-tight">
                {{ shortLabel ?? label }}
            </span>

        </div>

    </a>
</template>
