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
                            class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
                        >
                            Cancel
                        </Link>
                        <button
                            type="button"
                            @click="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-50 dark:bg-primary-700 dark:hover:bg-primary-800"
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
                            <img
                                :src="props.post.image"
                                class="w-full h-64 object-cover rounded-lg"
                                alt="Preview"
                            />
                        </div>
                        <ImageUpload v-model="form.image" :error="form.errors.image" />
                    </div>

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Title</label>
                        <input
                            type="text"
                            id="title"
                            v-model="form.title"
                            :class="{ 'border-red-500': form.errors.title }"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                            placeholder="Enter post title"
                        />
                        <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</p>
                    </div>

                    <!-- Excerpt -->
                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Excerpt</label>
                        <textarea
                            id="excerpt"
                            v-model="form.excerpt"
                            rows="3"
                            :class="{ 'border-red-500': form.errors.excerpt }"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                            placeholder="Enter post excerpt"
                        ></textarea>
                        <p v-if="form.errors.excerpt" class="mt-1 text-sm text-red-600">{{ form.errors.excerpt }}</p>
                    </div>

                    <!-- Body - TinyMCE Editor -->
                    <div>
                        <label for="body" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Content</label>
                        <div :class="{ 'border-red-500': form.errors.body }" class="mt-1">
                            <Editor v-model="form.body"
                                    :init="tinyMceConfig"
                                    tinymceScriptSrc="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"
                            />
                        </div>
                        <p v-if="form.errors.body" class="mt-1 text-sm text-red-600">{{ form.errors.body }}</p>
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
import Editor from '@tinymce/tinymce-vue';
import { useDark } from '@vueuse/core';

const isDark = useDark();
const props = defineProps({ post: Object });

const form = useForm({
    title: props.post.title,
    excerpt: props.post.excerpt,
    body: props.post.body,
    image: null as File | null | undefined,
    _method: 'PUT',
});

const submit = () => {
    form.post(route('admin.posts.update', props.post.slug), { preserveScroll: true });
};

const tinyMceConfig = {
    height: 500,
    menubar: true,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen', 'insertdatetime', 'media',
        'table', 'code', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }',
    skin: isDark ? 'oxide-dark' : 'oxide',
    content_css: isDark ? 'dark' : 'default',
    images_upload_url: route('upload'),
    automatic_uploads: true,
    file_picker_types: 'image',
    document_base_url: 'http://localhost/'
};
</script>
