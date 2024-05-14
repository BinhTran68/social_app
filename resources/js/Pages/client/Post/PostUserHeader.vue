<script setup>
import {formatDate} from "@/Utils/utils.js";
import CircleImage from "@/Components/CircleImage.vue";

defineProps({
    post : {
        type: {
            type: Object,
            required: true
        }
    }
})


</script>


<template>
    <div class="flex items-center gap-3">
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
</template>

<style scoped>

</style>
