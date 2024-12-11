<template>
    <AdminLayout title="Posts">
        <div class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-black/90">
            <!-- Table header with actions -->
            <div class="flex flex-col gap-4 p-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-2">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Posts</h2>
                    <span
                        class="rounded-full bg-gray-100 px-2.5 py-0.5 text-sm font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300"
                    >
                        {{ posts.total }}
                    </span>
                </div>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                    <!-- Search -->
                    <div class="relative w-full sm:w-64">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <MagnifyingGlassIcon class="h-5 w-5 text-gray-500 dark:text-gray-400" />
                        </div>
                        <input
                            v-model="form.search"
                            @input="debouncedSearch"
                            type="search"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 pl-10 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                            placeholder="Search posts..."
                        />
                    </div>

                    <!-- Add new post button -->
                    <Link
                        :href="route('admin.posts.create')"
                        class="btn btn-outline btn-secondary dark:btn-primary btn-sm"
                    >
                        <PlusIcon class="mr-2 h-4 w-4" />
                        Add Post
                    </Link>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-cyan-800 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3 cursor-pointer hover:bg-gray-100" @click="sort('title')">
                                Title
                                <SortIndicator :active="filters.sort === 'title'" :direction="filters.direction" />
                            </th>
                            <th scope="col" class="px-4 py-3">Published</th>
                            <th
                                scope="col"
                                class="px-2 py-3 cursor-pointer hover:bg-gray-100"
                                @click="sort('created_at')"
                            >
                                Created
                                <SortIndicator :active="filters.sort === 'created_at'" :direction="filters.direction" />
                            </th>
                            <th scope="col" class="px-4 py-3">Author</th>
                            <th scope="col" class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="post in posts.data"
                            :key="post.id"
                            class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                        >
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <!-- Post thumbnail -->
                                    <div class="mr-3 h-10 w-10 flex-shrink-0">
                                        <img
                                            :src="post.image"
                                            class="h-10 w-10 rounded-lg object-cover"
                                            :alt="post.title"
                                        />
                                    </div>
                                    <!-- Post title and excerpt -->
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-900 dark:text-white">
                                            {{ post.title }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium"
                                    :class="{
                                        'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300':
                                            post.status === 'published',
                                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300':
                                            post.status === 'draft',
                                    }"
                                >
                                    <input
                                        @change="handlePublish(post.slug)"
                                        type="checkbox"
                                        class="toggle toggle-success"
                                        :checked="post.published"
                                    />
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ post.created_at }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <img
                                        :src="post.user.profile_photo_url"
                                        class="mr-2 h-6 w-6 rounded-full"
                                        :alt="post.user.name"
                                    />
                                    <span>{{ post.user.name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <Link
                                        :href="route('post.show', post.slug)"
                                        class="btn btn-xs btn-outline btn-success"
                                    >
                                        <EyeIcon class="h-5 w-5" />
                                    </Link>
                                    <Link
                                        :href="route('admin.posts.edit', post.slug)"
                                        class="btn btn-xs btn-outline btn-info"
                                    >
                                        <PencilSquareIcon class="h-5 w-5" />
                                    </Link>
                                    <button @click="handleDelete(post.slug)" class="btn btn-xs btn-outline btn-error">
                                        <TrashIcon class="h-5 w-5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center px-4 py-3">
                <Pagination :links="posts.links" />
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import { PlusIcon, MagnifyingGlassIcon, PencilSquareIcon, EyeIcon, TrashIcon } from '@heroicons/vue/24/outline';

import SortIndicator from '@/Components/SortIndicator.vue';

// Custom sort indicator component
const props = defineProps({
    posts: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        default: () => ({
            search: '',
            sort: 'created_at',
            direction: 'desc',
        }),
    },
});

const form = useForm({
    search: props.filters.search,
});

// Debounce function
const debounce = (func, delay) => {
    let timeoutId;
    return (...args) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func(...args), delay);
    };
};

// Sorting method
const sort = (column) => {
    const direction = props.filters.sort === column && props.filters.direction === 'desc' ? 'asc' : 'desc';

    router.get(
        route('admin.posts.index'),
        {
            sort: column,
            direction: direction,
            search: form.search,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
};

// Debounced search method
const debouncedSearch = debounce(() => {
    router.get(
        route('admin.posts.index'),
        {
            search: form.search,
            sort: props.filters.sort,
            direction: props.filters.direction,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
}, 300);

const handlePublish = (slug) => {
    router.patch(
        route('admin.posts.update', slug),
        {
            published: !props.posts.data.find((post) => post.slug === slug).published,
        },
        {
            preserveScroll: true,
            preserveState: false,
        }
    );
};

const handleDelete = (slug) => {
    router.delete(route('admin.posts.destroy', slug), {
        preserveScroll: true,
        preserveState: false,
    });
};
</script>
