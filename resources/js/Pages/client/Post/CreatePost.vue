<script setup>

import {ref} from "vue";
import CreatePostModal from "@/Pages/client/Post/CreatePostModal.vue";
import {usePage} from "@inertiajs/vue3";

const isShowCreatePost = ref(false)
const handleShowCreatePost = () => {
    isShowCreatePost.value = !isShowCreatePost.value;
}

const authUser = usePage().props.auth.user


</script>
<template>
    <div class="">
        <div class="flex items-center gap-5 px-2 py-5 bg-white mb-2 rounded-md">
            <img class="rounded-full w-[38px] h-[38px]" :src="authUser.avatar_path" alt="avatar">
            <span @click="handleShowCreatePost"
                  class="bg-gray-100 px-3 py-2 rounded-2xl w-full cursor-pointer hover:bg-gray-200 ">
                    Write something to share with everyone ..
                </span>
        </div>
    </div>
    <CreatePostModal v-model="isShowCreatePost"/>
</template>

<style scoped>

</style>
