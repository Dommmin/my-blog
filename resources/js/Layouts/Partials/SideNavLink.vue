<template>
    <Link
        :href="href"
        :class="[
            'transition-colors duration-200 ease-in-out',
            active
                ? 'text-gray-900 bg-gray-200 dark:bg-black/90 dark:text-gray-100'
                : 'hover:bg-gray-100 dark:hover:bg-black/70 text-gray-600 dark:text-gray-400',
            className,
        ]"
        prefetch
    >
        <slot />
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
        default: false,
    },
    className: {
        type: String,
        default: '',
    },
});
</script>
