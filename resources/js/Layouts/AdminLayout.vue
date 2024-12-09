<template>
    <Head :title="title" />

    <FlashMessages />
    <div class="h-screen bg-slate-100 dark:bg-gradient-to-b dark:from-black/95 dark:to-black/80">
        <Header @toggle-sidebar="toggleSidebar" :is-sidebar-open="isSidebarOpen" />

        <div class="flex h-[calc(100vh-64px)]">
            <Sidebar :is-open="isSidebarOpen" @toggle="toggleSidebar" class="z-20" />

            <main class="flex-1 p-4 md:p-6 transition-all duration-300 ease-in-out overflow-auto md:ml-64 ml-0">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import Sidebar from './Partials/Sidebar.vue';
import Header from './Partials/Header.vue';
import FlashMessages from '@/Components/FlashMessages.vue';

const isSidebarOpen = ref(false);

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};

const props = defineProps({
    title: String,
});
</script>
