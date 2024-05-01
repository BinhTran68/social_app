<script setup>
    defineProps(
        {
            src : '',
            alt : ''
        }
    )
</script>

<template>
    <img :src="src" :alt="alt" class="w-[32px] rounded-full  border-2 transition-all hover:border-blue-500">
</template>

<style scoped>

</style>
