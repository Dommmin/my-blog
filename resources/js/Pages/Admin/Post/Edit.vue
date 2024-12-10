<template>
    <AdminLayout title="Edit Post">
        <div class="mx-auto max-w-4xl">
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <!-- Form Header -->
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Edit Post</h2>
                    <div class="flex items-center gap-2">
                        <Link
                            :href="route('admin.posts.index')"
                            class="btn btn-outline btn-sm"
                        >
                            Cancel
                        </Link>
                        <button
                            type="button"
                            @click="submit"
                            :disabled="form.processing"
                            class="btn btn-outline btn-secondary dark:btn-primary btn-sm"
                        >
                            <span v-if="form.processing">Saving...</span>
                            <span v-else>Update Post</span>
                        </button>
                    </div>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Image</label>
                        <div v-if="!form.image" class="mb-4">
                            <img :src="props.post.image" class="w-full h-64 object-cover rounded-lg" alt="Preview" />
                        </div>
                        <ImageUpload v-model="form.image" :error="form.errors.image" />
                    </div>

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200"
                            >Title</label
                        >
                        <input
                            type="text"
                            id="title"
                            v-model="form.title"
                            :class="{ 'border-red-500': form.errors.title }"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                            placeholder="Enter post title"
                        />
                        <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">
                            {{ form.errors.title }}
                        </p>
                    </div>

                    <!-- Excerpt -->
                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-200"
                            >Excerpt</label
                        >
                        <textarea
                            id="excerpt"
                            v-model="form.excerpt"
                            rows="3"
                            :class="{ 'border-red-500': form.errors.excerpt }"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                            placeholder="Enter post excerpt"
                        ></textarea>
                        <p v-if="form.errors.excerpt" class="mt-1 text-sm text-red-600">
                            {{ form.errors.excerpt }}
                        </p>
                    </div>

                    <!-- Body - TinyMCE Editor -->
                    <div>
                        <label for="body" class="block text-sm font-medium text-gray-700 dark:text-gray-200"
                            >Content</label
                        >
                        <TinyMceEditor v-model="form.body" />
                        <p v-if="form.errors.body" class="mt-1 text-sm text-red-600">
                            {{ form.errors.body }}
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup lang="ts">
import ImageUpload from '@/Components/ImageUpload.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import TinyMceEditor from '@/Components/TinyMceEditor.vue';

const props = defineProps({ post: Object });

const form = useForm({
    title: props.post.title,
    excerpt: props.post.excerpt,
    body: props.post.body,
    image: null as File | null | undefined,
    _method: 'PUT',
});

const submit = () => {
    form.post(route('admin.posts.update', props.post.slug), {
        preserveScroll: true,
    });
};
</script>
