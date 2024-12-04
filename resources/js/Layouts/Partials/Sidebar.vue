<template>
    <div>
        <!-- Mobile backdrop -->
        <div
            v-if="isOpen"
            class="fixed inset-0 z-10 bg-gray-900/50 md:hidden"
            @click="$emit('toggle')"
        />

        <!-- Sidebar -->
        <aside
            class="fixed z-20 transition-all duration-300 ease-in-out top-16"
            :class="[
                isOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0',
                'w-64 h-[calc(100vh-64px)]',
            ]"
        >
            <div
                class="flex h-full flex-col overflow-y-auto border-r border-gray-200 bg-white px-3 py-4 dark:border-gray-700 dark:bg-black/40"
            >
                <!-- Navigation -->
                <nav class="flex-1 space-y-1">
                    <div v-for="(item, index) in menu" :key="index">
                        <SideNavLink
                            :href="item.name"
                            :active="item.current"
                            class="group flex items-center rounded-lg p-2 text-base font-normal"
                        >
                            <component
                                :is="item.icon"
                                class="h-6 w-6 flex-shrink-0 transition duration-75"
                                :class="[
                                    item.current
                                        ? 'text-primary-600 dark:text-primary-500'
                                        : 'text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white',
                                ]"
                            />
                            <span
                                class="ml-3"
                                :class="[
                                    item.current
                                        ? 'text-primary-600 dark:text-primary-500'
                                        : 'text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white',
                                ]"
                            >
                                {{ item.title }}
                            </span>
                        </SideNavLink>
                    </div>
                </nav>

                <!-- Bottom section -->
                <div class="pt-2">
                    <button
                        @click="logout"
                        class="group flex w-full items-center rounded-lg p-2 text-base font-normal text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                    >
                        <PowerIcon
                            class="h-6 w-6 flex-shrink-0 text-error transition duration-75 group-hover:text-error/80"
                        />
                        <span class="ml-3">Logout</span>
                    </button>
                </div>
            </div>
        </aside>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { PowerIcon, CubeIcon, PuzzlePieceIcon } from '@heroicons/vue/24/solid';
import SideNavLink from './SideNavLink.vue';
import { router } from '@inertiajs/vue3';

defineProps({
    isOpen: {
        type: Boolean,
        required: true,
    },
});

defineEmits(['toggle']);

const logout = () => {
    router.post(route('logout'));
};

const menu = computed(() => [
    {
        title: 'Dashboard',
        icon: CubeIcon,
        name: route('admin.home'),
        current: route().current('admin.home'),
    },
    {
        title: 'Posts',
        icon: PuzzlePieceIcon,
        name: route('admin.posts.index'),
        current: route().current('admin.posts.*'),
    },
]);
</script>
