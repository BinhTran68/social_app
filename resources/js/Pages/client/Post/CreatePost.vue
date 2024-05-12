<script setup>

import {ref} from "vue";
import ImageIcon from "@/Icon/ImageIcon.vue";
import VideoIcon from "@/Icon/VideoIcon.vue";
import SmileIcon from "@/Icon/SmileIcon.vue";
import LocationMapIcon from "@/Icon/LocationMapIcon.vue";
import InputTextarea from "@/Components/InputTextarea.vue";
import Button from "@/Components/Button.vue";
import CancelIcon from "@/Icon/CancelIcon.vue";
import {router, useForm} from "@inertiajs/vue3";
import {BASE_URL} from "@/Utils/Constant.js";

const isShowCreatePost = ref(false)


const newPostForm = useForm({
    body : ''
})

const handleOnCreatePost = () => {
   newPostForm.post(route('post.create'), {
       onSuccess : () => {
           newPostForm.reset()
       },
       onError : (e) => {
           console.log(e.body)
       }
   })
}



const handleShowCreatePost = () => {
    isShowCreatePost.value = !isShowCreatePost.value;
}

const handleExitCreatePost = () => {
    isShowCreatePost.value = false
}

</script>

<template>
        <div class="">
            <div class="flex items-center gap-5 px-2 py-5 bg-white mb-2 rounded-md">
                <img class="rounded-full w-[38px] h-[38px]" src="https://picsum.photos/200/300" alt="avatar">
                <span @click="handleShowCreatePost" class="bg-gray-100 px-3 py-2 rounded-2xl w-full cursor-pointer hover:bg-gray-200 ">
                    Write something to share with everyone ..
                </span>
            </div>
        </div>
        <div v-if="isShowCreatePost" class="">
            <div class="px-6 py-3 bg-white rounded-md relative">
                <h6 class="font-bold text-center py-3">Create Post</h6>
                <div @click="handleExitCreatePost" class="absolute top-2 right-3">
                    <CancelIcon  class="w-6 h-6 text-gray-500 hover:text-gray-600 cursor-pointer"/>
                </div>
                <hr>
                <div class="py-5">
                    <InputTextarea v-model="newPostForm.body" />
                    <div class="border py-2 px-3 rounded-md flex items-center justify-between">
                            <h6 class="font-bold">Add to your post</h6>
                        <div class="flex items-center justify-center gap-3">
                            <span class="">
                                 <ImageIcon class="w-8 h-8 text-green hover:bg-gray-200 rounded cursor-pointer"/>
                            </span>
                            <span>
                                  <VideoIcon class="w-8 h-8 text-purple-500 hover:bg-gray-200 rounded cursor-pointer"/>
                            </span>
                            <span>
                                <SmileIcon class="w-8 h-8 text-amber-500 hover:bg-gray-200 rounded cursor-pointer"/>
                            </span>
                            <span>
                                <LocationMapIcon class="w-8 h-8 text-red-500 hover:bg-gray-200 rounded cursor-pointer"/>
                            </span>
                        </div>
                    </div>
                </div>
                <Button
                    @click="handleOnCreatePost"
                    :class="['w-full']">
                    Post
                </Button>
            </div>
        </div>
</template>

<style scoped>

</style>
