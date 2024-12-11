<template>
    <span class="inline-block ml-2">
        <template v-if="active">
            <ChevronUpIcon v-if="direction === 'asc'" class="inline-block w-4 h-4 text-gray-500" />
            <ChevronDownIcon v-else class="inline-block w-4 h-4 text-gray-500" />
        </template>
    </span>
</template>

<script setup>
import { ChevronUpIcon, ChevronDownIcon } from '@heroicons/vue/24/outline';

defineProps({
    active: {
        type: Boolean,
        default: false,
    },
    direction: {
        type: String,
        default: 'desc',
        validator: (value) => ['asc', 'desc'].includes(value),
    },
});
</script>
