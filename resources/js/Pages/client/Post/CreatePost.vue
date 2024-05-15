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
import {isImage} from "@/Utils/utils.js";
import CarouselIamgeCustom from "@/Components/CarouselIamgeCustom.vue";
import CreatePostModal from "@/Pages/client/Post/CreatePostModal.vue";

const isShowCreatePost = ref(false)

const attachmentFiles = ref([])

const newPostForm = useForm({
    body: ''
})

const handleOnCreatePost = () => {
    newPostForm.post(route('post.create'), {
        onSuccess: () => {
            newPostForm.reset()
        },
        onError: (e) => {
            console.log(e.body)
        }
    })
}

const handleShowCreatePost = () => {
    isShowCreatePost.value = !isShowCreatePost.value;
}

const handleExitCreatePost = () => {
    isShowCreatePost.value = false
    attachmentFiles.value = []
}

const onSelectImages = async (e) => {
    const files = e.target.files
    for (const file of files) {
        if (isImage(file)) {
            const myFile = {
                file,
                url: await readFile(file)
            }
            attachmentFiles.value.push(myFile)
        }
    }
}

const readFile = (file) => {
    return new Promise((res, req) => {
        const reader = new FileReader();
        reader.onload = () => {
            res(reader.result)
        }
        reader.onerror = req
        reader.readAsDataURL(file)
    })
}

</script>
<template>
    <div class="">
        <div class="flex items-center gap-5 px-2 py-5 bg-white mb-2 rounded-md">
            <img class="rounded-full w-[38px] h-[38px]" src="https://picsum.photos/200/300" alt="avatar">
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
