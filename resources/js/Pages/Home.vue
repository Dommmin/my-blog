<template>
    <AppLayout title="Blog">
        <div class="py-12  min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    <div
                        v-for="post in posts.data"
                        :key="post.id"
                        class="bg-slate-200 dark:bg-black/90 shadow-md rounded-lg overflow-hidden border border-slate-300 dark:border-gray-700"
                    >
                        <img
                            :src="post.image"
                            alt="Post image"
                            class="w-full h-48 object-cover"
                        />
                        <div class="p-6">
                            <h2
                                class="text-2xl font-semibold text-gray-800 dark:text-gray-200"
                            >
                                {{ post.title }}
                            </h2>
                            <p
                                class="text-gray-600 dark:text-gray-400 text-sm mt-2"
                            >
                                {{ post.created_at }}
                            </p>
                            <p class="text-gray-700 dark:text-gray-300 mt-4">
                                {{ post.excerpt }}
                            </p>
                            <Link
                                prefetch="mount"
                                :href="route('post.show', post.slug)"
                                class="text-blue-600 dark:text-blue-400 mt-4 inline-block hover:underline"
                                >Czytaj więcej</Link
                            >
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-8">
                    <Pagination :links="posts.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Link, router } from '@inertiajs/vue3';
import { onMounted, onUnmounted } from 'vue';

const props = defineProps({
    posts: Object,
});

const handleVisibilityChange = () => {
    if (document.visibilityState === 'visible') {
        router.reload({
            preserveUrl: true,
        })
    }
}

onMounted(() => {
    document.addEventListener('visibilitychange', handleVisibilityChange);
});

onUnmounted(() => {
    document.removeEventListener('visibilitychange', handleVisibilityChange);
});
</script>
