<script setup>
import {TabGroup, TabList, Tab, TabPanels, TabPanel} from '@headlessui/vue';
import {computed, defineAsyncComponent, ref} from 'vue';
import {router, usePage} from "@inertiajs/vue3";
import Button from "@/Components/Button.vue";
import {BASE_URL, CLOUDINARY_UPLOAD_PRESET} from "@/Utils/Constant.js"
import CancelIcon from "@/Icon/CancelIcon.vue";
import CameraIcon from "@/Icon/CameraIcon.vue";
import CheckIcon from "@/Icon/CheckIcon.vue";
import axios from 'axios';
import WaitingSpinner from "@/Components/WaitingSpinner.vue";
import {toast} from "vue3-toastify";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import TabItem from "@/Pages/Profile/Partials/TabItem.vue";
import {tabs} from "@/Pages/client/Group/tabsGroupViewConfig.js";
import PlusIcon from "@/Icon/PlusIcon.vue";
const InviteGroupModal = defineAsyncComponent(() =>  import("@/Pages/client/Group/Modal/InviteGroupModal.vue"));

const props = defineProps({
    group: {
        type: Object
    }
})
const group = ref(props.group.data);
const authUser = usePage().props.auth.user


const isLoading = ref(false);
const isMyGroup = computed(() => (authUser && authUser.id === group.value.user_id))
const showInviteToGroups = ref(false)

const coverImageSrc = ref('');
let coverImageFile = null

const avatarImageSrc = ref('');
let avatarImageFile = null;


const handleSubmitCoverImage = async () => {
    isLoading.value = true
    const formData = new FormData();
    formData.append('file', coverImageFile)
    formData.append('type', 'cover')
    fetchApiSaveImages(formData)
}

const handleSubmitChangeAvatar = async () => {
    isLoading.value = true
    const formData = new FormData();
    formData.append('file', avatarImageFile)
    formData.append('type', 'avatar')
    fetchApiSaveImages(formData);
}

const fetchApiSaveImages = (formData) => {
    axios.post(route('group.update_image', group.value.id), formData).then((res) => {
        if (formData.get('type') === 'cover') {
            group.value.cover_path = res.data.cover_path
        } else {
            group.value.thumbnail_path = res.data.thumbnail_path
        }
        toast.success('Upload cover images successfully.');
    }).catch((e) => {
        showErrorToast(e)
    }).finally(() => {
        isLoading.value = false
        clearCoverImage()
        clearAvatarImage()
    })
}

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

const showErrorToast = (error) => {
    toast.error(error.response?.data?.message || 'Something went wrong!');
};

</script>

<!--
Open Modal Invite friend to tis group

1. Select my flowed
2. find by user-name
3. Send mail join in to group


-->

<template>
    <AuthenticatedLayout>
        <div v-if="isLoading">
            <WaitingSpinner/>
        </div>
        <div class="container max-w-[928px] h-full mx-auto ">
            <div class="relative bg-white">
                <img
                    :src="coverImageSrc || group.cover_path || '/img/default_cover_image.jpg'"
                    alt="cover photo"
                    class="object-cover  w-full h-[350px] "
                >
                <label v-if="isMyGroup && !coverImageSrc" for="cover-image" class="
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
                        v-if="isMyGroup && !avatarImageSrc"
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
                    <div class="flex justify-between items-center gap-8 p-3">
                       <div>
                           <small class="font-semibold">Public group <small>500k members</small></small>
                           <h1 class="font-bold text-lg">
                               {{ group.name }}
                           </h1>
                       </div>

                        <div>
                            <div>
                                <Button class="flex"
                                        @click="showInviteToGroups = true"
                                >
                                    <span class="flex items-center gap-1">
                                         <PlusIcon :class="['w-4 h-4']"/>
                                           <span>
                                            Invite
                                         </span>
                                    </span>
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="border-t">
                <TabGroup>
                    <TabList class="flex bg-white">
                        <template v-for="tab in tabs" :key="tab.key">
                            <Tab as="template" v-slot="{ selected }">
                                <TabItem :selected="selected" :text="tab.label"/>
                            </Tab>
                        </template>
                    </TabList>
                    <TabPanels class="mt-2">
                        <template v-for="tab in tabs" :key="tab.key">
                            <TabPanel>
                                <component :is="tab.component"/>
                            </TabPanel>
                        </template>
                    </TabPanels>
                </TabGroup>
            </div>
        </div>
        <InviteGroupModal
            v-if="showInviteToGroups"
            v-model="showInviteToGroups" />
    </AuthenticatedLayout>
</template>
