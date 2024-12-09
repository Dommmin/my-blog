<template>
    <AppLayout :title="post.title">
        <div class="py-12 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="text-gray-900 dark:text-gray-100 bg-slate-200/80 dark:bg-black/50 rounded-lg shadow-md p-6 border dark:border-gray-700"
                >
                    <div v-html="formattedBody" />
                    <!--                    <button-->
                    <!--                        @click="toggleContent"-->
                    <!--                        class="mt-4 text-blue-600 hover:text-blue-800 focus:outline-none dark:text-blue-400 dark:hover:text-blue-500"-->
                    <!--                    >-->
                    <!--                        {{ showFullContent ? 'Collapse' : 'Read More' }}-->
                    <!--                    </button>-->
                    <div class="mt-8">
                        <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Comments</h2>
                        <div v-if="!comments.data.length">No comments ...</div>
                        <div
                            v-else
                            v-for="comment in comments.data"
                            :key="comment.id"
                            class="bg-slate-100 dark:bg-black/90 rounded-lg p-4 mb-4 relative shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] dark:ring-gray-700/50"
                        >
                            <div class="flex items-center mb-2">
                                <img
                                    :src="comment.user.profile_photo_url"
                                    :alt="comment.user.username"
                                    class="w-8 h-8 rounded-full mr-2"
                                />
                                <div>
                                    <h3 class="font-medium text-gray-900 dark:text-white">
                                        {{ comment.user.name }}
                                    </h3>
                                </div>
                                <div
                                    v-if="$page.props.auth.user?.id === comment.user.id"
                                    class="absolute top-4 right-4 flex space-x-2"
                                >
                                    <button
                                        @click="startEditing(comment)"
                                        class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 focus:outline-none"
                                    >
                                        <i class="w-5 h-5">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="20"
                                                height="20"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3Z" />
                                            </svg>
                                        </i>
                                    </button>
                                    <button
                                        @click="deleteComment(comment.id)"
                                        class="text-gray-600 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 focus:outline-none"
                                    >
                                        <i class="w-5 h-5">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="20"
                                                height="20"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path d="M3 6h18" />
                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                            </svg>
                                        </i>
                                    </button>
                                </div>
                            </div>
                            <div v-if="!isEditing(comment.id)">
                                <p class="text-gray-700 dark:text-gray-300">
                                    {{ comment.content }}
                                </p>
                            </div>
                            <div v-else>
                                <textarea
                                    v-model="editForm.content"
                                    class="w-full bg-white dark:bg-gray-600 rounded-lg p-2 mb-2 text-gray-700 dark:text-gray-300"
                                    rows="3"
                                ></textarea>
                                <InputError :message="editForm.errors.content" class="mt-2" />
                                <div class="flex space-x-2">
                                    <button
                                        @click="updateComment(comment.id)"
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50 dark:bg-blue-400 dark:hover:bg-blue-500"
                                    >
                                        Save
                                    </button>
                                    <button
                                        @click="cancelEditing"
                                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-1 px-3 rounded focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-gray-300"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center mt-8">
                            <Pagination :links="comments.links" />
                        </div>
                        <div v-if="$page.props.auth.user" class="mt-8">
                            <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Add Comment</h2>
                            <div class="flex items-start">
                                <div class="flex-1">
                                    <textarea
                                        v-model="form.content"
                                        class="w-full bg-gray-100 dark:bg-gray-700 rounded-lg p-2 mb-2 text-gray-700 dark:text-gray-300"
                                        placeholder="Write your comment..."
                                    ></textarea>
                                    <InputError :message="form.errors.content" class="mt-2" />
                                    <button
                                        @click="addComment"
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50 dark:bg-blue-400 dark:hover:bg-blue-500"
                                    >
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import InputError from '@/Components/InputError.vue';
import { router, useForm } from '@inertiajs/vue3';

interface Comment {
    id: number;
    content: string;
    user: {
        id: number;
        username: string;
        name: string;
        profile_photo_url: string;
    };
}

interface Post {
    id: string;
    title: string;
    slug: string;
    body: string;
    image: string;
    created_at: string;
}

interface Comments {
    data: Comment[];
    links: object;
}

const props = defineProps<{
    post: Post;
    comments: Comments;
}>();

const showFullContent = ref(false);
const editingCommentId = ref<number | null>(null);

const form = useForm({
    content: '',
});

const editForm = useForm({
    content: '',
});

const isEditing = (commentId: number): boolean => {
    return editingCommentId.value === commentId;
};

const startEditing = (comment: Comment) => {
    editingCommentId.value = comment.id;
    editForm.content = comment.content;
};

const cancelEditing = () => {
    editingCommentId.value = null;
    editForm.reset();
};

const updateComment = (id: number) => {
    editForm.put(route('comments.update', id), {
        preserveScroll: true,
        preserveState: false,
        onSuccess: () => {
            editingCommentId.value = null;
            editForm.reset();
        },
    });
};

const deleteComment = (id: number) => {
    if (confirm('Are you sure you want to delete this comment?')) {
        router.delete(route('comments.destroy', id), {
            preserveScroll: true,
        });
    }
};

const addComment = () => {
    if (!form.content.trim()) {
        return;
    }

    form.post(route('comments.store', props.post.slug), {
        preserveScroll: true,
        preserveState: false,
        onSuccess: () => {
            form.reset('content');
            window.scroll({
                top: 0,
                behavior: 'smooth',
            });
        },
    });
};

const toggleContent = () => {
    showFullContent.value = !showFullContent.value;
};

const formattedBody = computed(() => {
    return props.post.body.replace(/<pre>(.*?)<\/pre>/g, '<pre class="block overflow-x-auto">$1</pre>');
});

// const previewContent = computed(() => {
//     return props.post.body.slice(0, 300) + '...';
// });

const handleVisibilityChange = () => {
    if (document.visibilityState === 'visible') {
        router.reload({
            only: ['comments'],
            preserveUrl: true,
        });
    }
};

onMounted(() => {
    document.addEventListener('visibilitychange', handleVisibilityChange);
});

onUnmounted(() => {
    document.removeEventListener('visibilitychange', handleVisibilityChange);
});
</script>
