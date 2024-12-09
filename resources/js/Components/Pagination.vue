<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, key) in links">
                <div
                    v-if="link.url === null"
                    :key="key"
                    class="mb-1 mr-1 px-4 py-3 text-gray-600 dark:text-gray-300 text-sm leading-4 border rounded bg-gray-200 dark:bg-gray-800 border-gray-400 dark:border-gray-600"
                    v-html="link.label"
                />
                <Link
                    v-else
                    :key="`link-${key}`"
                    class="mb-1 mr-1 px-4 py-3 text-sm leading-4 border rounded transition duration-200"
                    :class="{
                        'bg-indigo-100 text-indigo-600 dark:bg-indigo-700 dark:text-white': link.active,
                        'text-gray-700 bg-white hover:bg-gray-100 border-gray-300 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-gray-600': !link.active,
                    }"
                    :href="link.url"
                    v-html="link.label"
                    prefetch="hover"
                    preserve-scroll
                />
            </template>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    links: {
        type: Object,
        required: true,
    },
});
</script>
