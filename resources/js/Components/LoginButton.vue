<template>
    <button
        name="login"
        id="login"
        class="flex h-11 w-11 items-center justify-center rounded-md border border-neutral-200 text-black transition-colors dark:border-neutral-700 dark:text-white"
    >
        <Link
            :href="route('login')"
            class="flex h-11 w-11 items-center justify-center rounded-md border text-white transition-colors dark:border-neutral-700 dark:text-white"
        >
            <LogInIcon class="h-5 w-5" />
        </Link>
    </button>
</template>

<script setup>
import { LogInIcon } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
</script>
