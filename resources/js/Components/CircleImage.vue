<script setup>
defineProps(
    {
        src: '',
        alt: ''
    }
)
</script>

<template>
    <div class="
    w-[43px ]
    min-w-[43px]
    max-w-[43px]
    h-[43px]
    border-[2px]
    border-indigo-400
    rounded-full
">
        <div class="
    w-full h-full
    border-[2px]
    border-gray-50
    rounded-full
">
            <img :src="src"
                 :alt="alt"
                 class="
             w-full h-full
         rounded-full
         border-3
         border-gray-100
         object-cover
         transition-all

        ">
        </div>
    </div>

</template>

<style scoped>

</style>
