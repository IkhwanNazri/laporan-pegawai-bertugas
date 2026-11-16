<script setup>
import { Link } from '@inertiajs/vue3'
defineProps({ links: { type: Array, default: () => [] } })
</script>

<template>
    <div v-if="links.length > 3" class="flex flex-wrap gap-1 mt-4">
        <template v-for="(link, i) in links" :key="i">
            <Link v-if="link.url" :href="link.url" v-html="link.label" preserve-scroll
                :class="['px-3 py-2 text-sm rounded-lg border', link.active ? 'bg-purple-900 text-white border-purple-900' : 'border-gray-200 text-gray-700 hover:bg-gray-50']" />
            <span v-else v-html="link.label" class="px-3 py-2 text-sm rounded-lg border border-gray-200 text-gray-400" />
        </template>
    </div>
</template>
