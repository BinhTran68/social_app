<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message">
        <small class="text-sm text-red-600 dark:text-red-400">
            {{ message }}
        </small>
    </div>
</template>
