<script setup>
    defineProps({
        image: String,
        title: String,
        description : String
    })
</script>

<template>
    <div class="flex gap-3 items-center hover:bg-gray-200 w-full mb-3 px-2 py-3">
        <img :src="image" class="w-[32px] h-[32px] rounded-full" alt="image-group">
        <div class=" gap-2">
            <h3 class="font-black text-xl">{{title}}</h3>
            <div class="text-xs text-gray-500">{{ description }}</div>
        </div>
    </div>
</template>

<style scoped>

</style>
