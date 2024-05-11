<script setup>

import {ref} from "vue";
import ImageIcon from "@/Icon/ImageIcon.vue";
import VideoIcon from "@/Icon/VideoIcon.vue";
import SmileIcon from "@/Icon/SmileIcon.vue";
import LocationMapIcon from "@/Icon/LocationMapIcon.vue";

const isShowCreatePost = ref(true)

</script>

<template>
    <div>
        <div class="">
            <div class="flex items-center gap-5 px-2 py-5 bg-white mb-2 rounded-md">
                <img class="rounded-full w-[38px] h-[38px]" src="https://picsum.photos/200/300" alt="avatar">
                <span class="bg-gray-100 px-3 py-2 rounded-2xl w-full cursor-pointer hover:bg-gray-200 ">
                    Write something to share with everyone ..
                </span>
            </div>
        </div>
        <div v-if="isShowCreatePost" class="">
            <div class="px-6 py-3 bg-white rounded-md">
                <h6 class="font-bold text-center py-3">Create Post</h6>
                <hr>
                <div class="py-5">
                    <textarea class="w-full border rounded-md  p-2" placeholder="What's on your mind ?">

                    </textarea>
                    <div class="border py-2 px-3 rounded-md flex items-center justify-between">
                            <h6 class="font-bold">Add to your post</h6>
                        <div class="flex items-center justify-center gap-3">
                            <ImageIcon class="w-8 h-8 text-green"/>
                            <VideoIcon class="w-8 h-8 text-purple-500"/>
                            <SmileIcon class="w-8 h-8 text-amber-500"/>
                            <LocationMapIcon class="w-8 h-8 text-red-500"/>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
</template>

<style scoped>

</style>
