<template>
    <div class="space-y-2">
        <div
            class="relative group rounded-lg border-2 transition-all duration-150 ease-in-out"
            :class="[
                dragover
                    ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20'
                    : 'border-dashed border-gray-300 dark:border-gray-600',
                error ? 'border-red-500' : '',
                imagePreview ? 'border-solid' : 'border-dashed',
            ]"
            @dragover.prevent="dragover = true"
            @dragleave.prevent="dragover = false"
            @drop="handleDrop"
        >
            <!-- Upload State -->
            <div
                v-if="!imagePreview"
                class="flex flex-col items-center justify-center p-8 text-center"
            >
                <div class="mb-4">
                    <div
                        class="mx-auto flex h-16 w-20 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800"
                    >
                        <ArrowUpTrayIcon
                            v-if="dragover"
                            class="h-16 w-20 text-primary-600 dark:text-primary-400"
                        />
                        <PhotoIcon
                            v-else
                            class="h-20 w-20 text-gray-600 dark:text-gray-400"
                        />
                    </div>
                </div>
                <div class="space-y-1">
                    <p
                        class="text-base font-medium text-gray-700 dark:text-gray-200"
                    >
                        {{
                            dragover
                                ? 'Drop your image here'
                                : 'Upload your image'
                        }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Drag and drop or click to select
                    </p>
                    <p class="text-xs text-gray-400 dark:text-gray-500">
                        PNG, JPG, GIF up to 2MB
                    </p>
                </div>
                <input
                    type="file"
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                    accept="image/*"
                    @change="handleFileInput"
                />
            </div>

            <!-- Preview State -->
            <div v-else class="relative">
                <img
                    :src="imagePreview"
                    class="w-full h-64 object-cover rounded-lg"
                    alt="Preview"
                />
                <div
                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-150 rounded-lg"
                >
                    <button
                        type="button"
                        @click="removeImage"
                        class="absolute top-2 right-2 p-1.5 rounded-full bg-white/80 text-gray-900 opacity-0 group-hover:opacity-100 hover:bg-white transition-all duration-150"
                    >
                        <XMarkIcon class="h-5 w-5" />
                    </button>
                </div>
            </div>
        </div>

        <p v-if="error" class="mt-1 text-sm text-red-600">{{ error }}</p>
    </div>
</template>

<script setup>
import { ref, watch, defineProps, defineEmits } from 'vue';
import {
    XMarkIcon,
    PhotoIcon,
    ArrowUpTrayIcon,
} from '@heroicons/vue/24/outline';

const props = defineProps({
    modelValue: {
        type: [File, null],
        required: true,
    },
    error: {
        type: String,
        default: '',
    },
});

// Define emit to update modelValue
const emit = defineEmits(['update:modelValue']);

// Data
const imagePreview = ref(null);
const dragover = ref(false);

// Method to preview the image
const previewImage = (file) => {
    if (!file) {
        imagePreview.value = null;
        return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
        imagePreview.value = e.target.result;
    };
    reader.readAsDataURL(file);
};

// Method to handle drop event
const handleDrop = (e) => {
    e.preventDefault();
    dragover.value = false;

    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        emit('update:modelValue', file);
        previewImage(file);
    }
};

const handleFileInput = (e) => {
    const file = e.target.files[0];
    if (file) {
        emit('update:modelValue', file);
        previewImage(file);
    }
};

const removeImage = () => {
    emit('update:modelValue', null);
    imagePreview.value = null;
};

watch(
    () => props.modelValue,
    (newVal) => {
        previewImage(newVal);
    }
);
</script>
