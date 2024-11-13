<template>
    <header
        class="sticky top-0 z-30 h-16 border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800"
    >
        <div class="flex h-full items-center justify-between px-4">
            <div class="flex items-center gap-4">
                <button
                    class="rounded-lg p-1 text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 md:hidden dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    @click="$emit('toggleSidebar')"
                >
                    <Bars3Icon class="h-6 w-6" />
                </button>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                    Blog
                </h2>
            </div>

            <div class="flex items-center gap-4">
                <div class="relative">
                    <button
                        class="flex text-sm rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                    >
                        <img
                            class="h-8 w-8 rounded-full border border-gray-300 dark:border-gray-600"
                            src="https://via.placeholder.com/40"
                            alt="User avatar"
                        />
                    </button>
                </div>
            </div>
        </div>
    </header>
</template>

<script setup>
import { Bars3Icon } from '@heroicons/vue/24/solid';

defineEmits(['toggleSidebar']);
</script>
