<script setup>
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue';
import { computed, ref } from 'vue';
import { usePage } from "@inertiajs/vue3";
import Button from "@/Components/Button.vue";
import { BASE_URL, CLOUDINARY_UPLOAD_PRESET } from "@/Utils/Constant.js"
import CancelIcon from "@/Icon/CancelIcon.vue";
import CameraIcon from "@/Icon/CameraIcon.vue";
import CheckIcon from "@/Icon/CheckIcon.vue";
import axios from 'axios';
import WaitingSpinner from "@/Components/WaitingSpinner.vue";
import { toast } from "vue3-toastify";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import TabItem from "@/Pages/Profile/Partials/TabItem.vue";
import {tabs} from "@/Pages/client/Group/tabsGroupViewConfig.js";

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean
    },
    status: {
        type: Boolean
    },
    group: {
        type: Object
    }
})

const authUser = usePage().props.auth.group
const group = ref(props.group);
const isLoading = ref(false);

const isMyProfile = computed(() => (authUser && authUser.id === props.group.id))
const coverImageSrc = ref('');
let coverImageFile = null;

const onCoverChange = (event) => {
    coverImageFile = event.target.files[0]
    if (coverImageFile) {
        const reader = new FileReader()
        reader.onload = () => {
            coverImageSrc.value = reader.result
        }
        reader.readAsDataURL(coverImageFile)
    }
}

const clearCoverImage = () => {
    coverImageFile = null
    coverImageSrc.value = ''
}

const handleSubmitCoverImage = async () => {
    isLoading.value = true
    const formData = new FormData();
    formData.append('file', coverImageFile)
    formData.append('upload_preset', CLOUDINARY_UPLOAD_PRESET)
    const url = await uploadFileToCloud(formData, 'cover_images');
    if (url === null) {
        toast.error("Something went wrong went ")
        isLoading.value = false
        return
    }
    const data = {
        url: url,
        type: 'cover'
    }
    axios.post(`${BASE_URL}/profile/update-images`, data).then(({data}) => {
        group.value = data
        clearCoverImage()
        isLoading.value = false
        toast.success('Upload cover images successfully.');
    }).catch((e) => {
        clearCoverImage()
        isLoading.value = false
        showErrorToast(e)
    })
}

const avatarImageSrc = ref('');
let avatarImageFile = null;

const onAvatarChange = (event) => {
    avatarImageFile = event.target.files[0]
    if (avatarImageFile) {
        const reader = new FileReader()
        reader.onload = () => {
            avatarImageSrc.value = reader.result
        }
        reader.readAsDataURL(avatarImageFile)
    }
}

const clearAvatarImage = () => {
    avatarImageFile = null
    avatarImageSrc.value = ''
}

const handleSubmitChangeAvatar = async () => {
    isLoading.value = true
    const formData = new FormData();
    formData.append('file', avatarImageFile)
    formData.append('upload_preset', CLOUDINARY_UPLOAD_PRESET)
    const url = await uploadFileToCloud(formData, 'avatar-images');
    if (url === null) {
        toast.error("Something went wrong !")
        clearAvatarImage()
        isLoading.value = false
        return
    }
    const data = {
        url: url,
        type: 'avatar'
    }
    axios.post(`${BASE_URL}/profile/update-images`, data).then(({data}) => {
        group.value = data
        clearAvatarImage()
        isLoading.value = false
        toast.success('Upload cover images successfully.');
    }).catch((e) => {
        clearAvatarImage()
        isLoading.value = false
        showErrorToast(e)
    })
}
</script>

<template>
    <AuthenticatedLayout>
        <div v-if="isLoading">
            <WaitingSpinner/>
        </div>
        <div class="container max-w-[928px] h-full mx-auto ">
            <div class="relative bg-white">
                <img
                    :src="coverImageSrc || group.cover_url || '/img/default_cover_image.jpg'"
                    alt="cover photo"
                    class="object-cover  w-full h-[350px] "
                >
                <label v-if="!coverImageSrc" for="cover-image" class="
                absolute top-72 right-2 bg-gray-50 px-2 py-1
                rounded-md opacity-90 hover:bg-gray-200 cursor-pointer">
                   <span class="flex items-center justify-center gap-3">
                        <span>
                             <CameraIcon className="w-4 h-4"/>
                        </span>
                       <span>
                           Update Cover Photo
                       </span>
                   </span>
                </label>
                <input type="file" @change="onCoverChange" name="cover-image" id="cover-image" hidden="">

                <div v-if="coverImageSrc" class="flex flex-col gap-2 absolute top-64 right-2 ">
                    <button
                        @click="clearCoverImage"
                        class="
                         bg-gray-50 px-2 py-1
                        rounded-md opacity-90 hover:bg-gray-200 cursor-pointer">
                   <span class="flex items-center justify-center gap-3">
                        <span>
                            <CancelIcon className="w-5 h-5 text-red-500"/>
                        </span>
                       <span>
                           Cancel
                       </span>
                   </span>
                    </button>
                    <button
                        @click="handleSubmitCoverImage"
                        class="
                         bg-gray-50 px-2 py-1
                         rounded-md opacity-90 hover:bg-gray-200 cursor-pointer">
                   <span class="flex items-center justify-center gap-3">
                        <span>
                            <CheckIcon className="w-5 h-5 text-green-500"/>
                        </span>
                       <span>
                           Submit
                       </span>
                   </span>
                    </button>
                </div>

                <div class="flex py-5 relative">
                    <div v-if="avatarImageSrc" class="flex -top-6 z-10 left-24 flex-col gap-2 absolute ">
                        <button
                            @click="handleSubmitChangeAvatar"
                            class="
                         bg-gray-50 px-2 py-1
                         rounded-md opacity-90 hover:bg-gray-200 cursor-pointer">
                            <span class="flex items-center justify-center gap-3">
                                <span>
                            <CheckIcon className="w-5 h-5 text-green-500"/>
                                </span>
                             <span>
                           Submit
                            </span>
                            </span>
                        </button>
                        <button
                            @click="clearAvatarImage"
                            class="
                         bg-gray-50 px-2 py-1
                        rounded-md opacity-90 hover:bg-gray-200 cursor-pointer">
                   <span class="flex items-center justify-center gap-3">
                        <span>
                            <CancelIcon className="w-5 h-5 text-red-500"/>
                        </span>
                       <span>
                           Cancel
                       </span>
                   </span>
                        </button>

                    </div>
                    <label
                        v-if="!avatarImageSrc"
                        for="avatar-image"
                        class="top-12 left-48
                         absolute border-[2px] flex
                         items-center justify-center
                         w-9 h-9 bg-gray-100
                         rounded-full">
                        <CameraIcon className="w-6 h-6"/>
                    </label>
                    <input type="file"
                           @change="onAvatarChange"
                           name="avatar-image"
                           id="avatar-image" hidden="">
                    <div class="
                    border-[3px]
                    rounded-full
                    w-[183px]
                    h-[183px]
                    -mt-[100px]
                    ml-[48px]
                    ">
                        <img
                            :src="avatarImageSrc || group.thumbnail_path || '/img/default_avatar_image.png' "
                            alt="avatar photo"
                            class="
                        rounded-full
                        w-full
                        h-full
                        object-cover
                        "
                        >
                    </div>

                    <!--                  Overlay avatar -->
                    <div
                        v-if="avatarImageSrc"
                        class="
                            absolute
                            inset-0 bg-black
                            border-[3px]
                            rounded-full
                            w-[183px]
                            h-[183px]
                            -mt-[80px]
                            ml-[48px]
                            opacity-30">
                    </div>
                    <div class="flex justify-between items-center p-3">
                        <h1 class="font-bold text-lg">
                            {{ group.name }}
                        </h1>
                    </div>
                </div>

            </div>
            <div class="border-t">
                <TabGroup>
                    <TabList class="flex bg-white">
                        <template v-for="tab in tabs" :key="tab.key">
                            <Tab as="template"  v-slot="{ selected }">
                                <TabItem :selected="selected" :text="tab.label"/>
                            </Tab>
                        </template>
                    </TabList>
                    <TabPanels class="mt-2">
                        <template v-for="tab in tabs" :key="tab.key">
                            <TabPanel>
                                <component :is="tab.component" />
                            </TabPanel>
                        </template>
                    </TabPanels>
                </TabGroup>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
