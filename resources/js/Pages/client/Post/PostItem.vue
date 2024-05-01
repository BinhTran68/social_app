<script setup>
import CircleImage from "@/Components/CircleImage.vue";
import ContentPost from "@/Pages/client/Post/ContentPost.vue";

defineProps({
    post: Object
})
</script>

<template>
    <div class="bg-white px-5 py-3 rounded-md">
        <div class="flex items-center gap-3">
            <CircleImage :src="post.user.avatar" alt=""/>
            <div class="flex flex-col ">
                <h4 class="font-bold">
                    <span class="hover:underline cursor-pointer">
                          {{ post.user.name }}
                    </span>
                    <template v-if="post.group">
                        >
                        <span>
                          {{ post.group.name }}
                    </span>
                    </template>
                </h4>
                <small class="text-gray-500">{{ post.created_at }}</small>
            </div>
        </div>
        <div>
            <ContentPost :body="post.body" :media="post.media"/>
        </div>
    </div>
</template>

<style scoped>

</style>
