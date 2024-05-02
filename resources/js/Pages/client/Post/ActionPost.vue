<script setup>
const props = defineProps({
    icon : String
})
</script>

<template>
    <span v-html="icon" class="flex w-8 h-8 gap-1 items-center justify-center  rounded-lg">
    </span>
</template>

<style scoped>

</style>
