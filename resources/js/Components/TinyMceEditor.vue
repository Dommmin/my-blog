<template>
    <Editor
        v-bind="content"
        :init="config"
        tinymceScriptSrc="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"
    />
</template>

<script setup>
import { useDark } from '@vueuse/core';
import Editor from '@tinymce/tinymce-vue';

const isDark = useDark();

const props = defineProps({
    content: Object,
});

const config = {
    height: 500,
    menubar: true,
    plugins: [
        'advlist',
        'autolink',
        'lists',
        'link',
        'image',
        'charmap',
        'preview',
        'anchor',
        'searchreplace',
        'visualblocks',
        'code',
        'fullscreen',
        'insertdatetime',
        'media',
        'table',
        'code',
        'help',
        'wordcount',
    ],
    toolbar:
        'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
    content_style:
        'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }',
    skin: isDark ? 'oxide-dark' : 'oxide',
    content_css: isDark ? 'dark' : 'default',
    images_upload_url: route('upload'),
    automatic_uploads: true,
    file_picker_types: 'image',
};
</script>
