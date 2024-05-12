<script setup>
import {ref, watch} from "vue";
const input = ref("");
const textareaRef = ref(null);
const onInputChange = (e) => {
    input.value = e.target.value;
    textareaRef.value.style.height = "auto";
    textareaRef.value.style.height = textareaRef.value.scrollHeight + 'px';
}

</script>

<template>

    <textarea
        class="
        border
        py-2
        border-gray-300
        dark:border-gray-700
        dark:bg-gray-900
        dark:text-gray-300
        focus:border-indigo-500
        dark:focus:border-indigo-600
        focus:ring-indigo-500
        dark:focus:ring-indigo-600
        rounded-md
        w-full
        shadow-sm
        resize-y
        overflow-y-hidden
        "
        v-model="input"
        ref="textareaRef"
        @input="onInputChange"
        placeholder="What's on your mind ?"
    ></textarea>
</template>

<style scoped>
</style>
