<script setup>
import CircleImage from "@/Components/CircleImage.vue";
import ContentPost from "@/Pages/client/Post/ContentPost.vue";
import ActionPost from "@/Pages/client/Post/ActionPost.vue";
import HeartIcon from "@/Icon/HeartIcon.vue";
import CommentIcon from "@/Icon/CommentIcon.vue";
import ShareIcon from "@/Icon/ShareIcon.vue";
import HeartBG from "@/Icon/HeartBG.vue";
import {formatDate} from "../../../Utils/utils.js";

defineProps({
    post: Object
})
</script>

<template>
    <div class="bg-white flex flex-col gap-4 py-3 rounded-md">
        <div class="flex items-center px-5 gap-3">
            <CircleImage :src="post.user.avatar_url" alt=""/>
            <div class="flex flex-col">
                <h4 class="font-bold">
                    <span class="hover:underline cursor-pointer">
                          {{ post.user.name }}
                    </span>
                    <template v-if="post.group">
                        <span>
                          {{ post.group.name }}
                    </span>
                    </template>
                </h4>
                <small class="text-gray-500">{{ formatDate(post.created_at) }}</small>
            </div>
        </div>
        <div class="flex flex-col gap-3">
            <ContentPost :body="post.body" :media="post.media"/>
            <div class="flex items-center mx-5 justify-start gap-5 ">
                <HeartIcon  className="w-8 " />
                <CommentIcon />
                <ShareIcon />
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
