<template>
    <button
        name="login"
        id="login"
        class="flex h-11 w-11 items-center justify-center rounded-md border border-neutral-200 text-black transition-colors dark:border-neutral-700 dark:text-white"
    >
        <NavLink
            :href="route('login')"
            class="relative flex h-11 w-11 items-center justify-center rounded-md border border-neutral-200 text-black transition-colors dark:border-neutral-700 dark:text-white"
        >
            <LogInIcon class="h-5 w-5" />
        </NavLink>
    </button>
</template>

<script setup>
import { LogInIcon } from 'lucide-vue-next';
import NavLink from './NavLink.vue';
</script>
