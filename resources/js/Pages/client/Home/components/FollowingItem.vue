<script setup>
defineProps({
    image: String,
    title: String,
})
</script>

<template>
    <div class="flex gap-3 items-center hover:bg-gray-200 w-full mb-3 overflow-hidden px-2 py-3">
        <img :src="image" class="w-[32px] rounded-full" alt="image-group">
        <div class="gap-2">
            <h3 class="font-black text-xl">{{title}}</h3>
        </div>
    </div>
</template>

<style scoped>

</style>
