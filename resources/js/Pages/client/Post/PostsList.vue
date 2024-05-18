<script setup>
   import PostItem from "@/Pages/client/Post/PostItem.vue";

   const props = defineProps({
       posts : {
           type : Array
       }
   })
</script>

<template>
    <div class="flex flex-col gap-3">
        <PostItem v-for="post of props.posts" :post="post"/>
    </div>
</template>

<style scoped>

</style>
