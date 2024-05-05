<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

defineProps({
    placeholder: ''
})

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
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
        shadow-sm "
        v-model="model"
        ref="input"
        :placeholder="placeholder"
    />
</template>
