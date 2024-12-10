<template>
    <Link
        :href="route('home')"
        class="flex items-center justify-center w-10 h-10 rounded-[10px] bg-gray-200 hover:bg-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-700 dark:text-gray-300">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
        </svg>
    </Link>
</template>
<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>
