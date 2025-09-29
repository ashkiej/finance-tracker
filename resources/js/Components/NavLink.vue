<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    href: String,
    active: Boolean,
    sidebar: { type: Boolean, default: false },
});
</script>

<template>
    <Link
        :href="href"
        :class="[
            sidebar
                ? 'block w-full px-4 py-2 rounded-md text-lg font-medium transition-colors'
                : 'inline-flex items-center px-1 pt-1 border-b-2 text-lg font-medium',
            active
                ? sidebar
                    ? 'bg-indigo-600 text-white hover:bg-indigo-700'
                    : 'border-indigo-500 text-gray-900'
                : sidebar
                ? 'text-gray-700 hover:bg-gray-100 hover:text-gray-900'
                : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
        ]"
    >
        <slot />
    </Link>
</template>
