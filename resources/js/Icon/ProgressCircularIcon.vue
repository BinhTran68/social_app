<script setup>

defineProps({
    color: {
        type: String,
        default: '#3f51b5'
    },
    size : {
        type: String,
        default: '25'
    }
})
</script>

<template>
    <v-progress-circular
        :color="color"
        indeterminate
        :size="size"
    ></v-progress-circular>
</template>

<style scoped>

</style>
