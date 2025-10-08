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
                    ? 'bg-sidebar-primary hover:bg-sidebar-primary/90'
                    : 'border-primary text-foreground'
                : sidebar
                ? 'text-sidebar-foreground hover:bg-sidebar-accent hover:text-sidebar-accent-foreground'
                : 'border-transparent text-muted-foreground hover:border-border hover:text-foreground',
        ]"
    >
        <slot />
    </Link>
</template>
