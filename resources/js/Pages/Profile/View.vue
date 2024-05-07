<script setup>
import {usePage} from "@inertiajs/vue3";
import {TabGroup, TabList, Tab, TabPanels, TabPanel} from '@headlessui/vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TabItem from "@/Pages/Profile/Partials/TabItem.vue";
import Edit from "@/Pages/Profile/Edit.vue";
import {computed, ref} from "vue";
import Button from "@/Components/Button.vue";
import {BASE_URL, CLOUDINARY_NAME, CLOUDINARY_UPLOAD_PRESET} from "@/Utils/Constant.js"
import CancelIcon from "@/Icon/CancelIcon.vue";
import CameraIcon from "@/Icon/CameraIcon.vue";
import CheckIcon from "@/Icon/CheckIcon.vue";
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import axios from 'axios';
import {da} from "vuetify/locale";

const authUser = usePage().props.auth.user
const coverImageSrc = ref('');

const urlUploadCoverImagesCloudinary = `https://api.cloudinary.com/v1_1/${CLOUDINARY_NAME}/image/upload?folder=cover_images`
const urlUploadAvatarImagesCloudinary = `https://api.cloudinary.com/v1_1/${CLOUDINARY_NAME}/image/upload?folder=avatar_images`

let coverImageFile = null;


const props = defineProps({
    mustVerifyEmail: {
        type: Boolean
    },
    status: {
        type: Boolean
    },
    user: {
        type: Object
    }
})
const isMyProfile = computed(() => (authUser && authUser.id === props.user.id))

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

const handleCancelSettingCoverImage = () => {
    coverImageFile = null
    coverImageSrc.value = ''
}


const handleSubmitCoverImage = () => {
    // Call api save image to cloud
    const  formData = new FormData();
    formData.append('file', coverImageFile)
    formData.append('upload_preset', CLOUDINARY_UPLOAD_PRESET)
    axios.post(urlUploadCoverImagesCloudinary,
        formData).then((response) => {
        const urlImg = response.data.secure_url
        const data =  {
            url : urlImg,
            type : 'cover'
        }
        axios.post(`${BASE_URL}/profile/update-images`, data).then((res) => {
            console.log(res)
        }).catch((e) => {
            console.log(e)
        })
    }).catch((error) => {
        console.log(error)
    })



    // Call api save image to databse
    console.log(1)
}


</script>


<style scoped>

</style>

<template>
    <AuthenticatedLayout>
        <div class="container max-w-[928px] h-full mx-auto ">
            <div class="relative bg-white">
                <img
                    :src="coverImageSrc || user.cover_url || '/img/default_cover_image.jpg'"
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

                <div v-if="coverImageSrc" class="flex flex-col gap-2 absolute top-64 right-2 " >
                    <button
                        @click="handleCancelSettingCoverImage"
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

                <div class="flex py-5">
                    <img
                        src="https://i0.wp.com/nftartwithlauren.com/wp-content/uploads/2023/11/laurenmcdonaghpereiraphoto_A_field_of_blooming_sunflowers_und_40d30d23-9ecd-489f-a2b9-5a8f7293af9a_0.png?fit=1024%2C574&ssl=1"
                        alt="cover photo"
                        class="
                        w-[173px]
                        h-[173px]
                        object-cover
                        rounded-full ml-[48px] -mt-[100px]"
                    >
                    <div class="flex justify-between items-center p-3">
                        <h1 class="font-bold text-lg">
                            {{ user.name }}
                        </h1>
                    </div>
                </div>

                <div>

                </div>
            </div>
            <div class="border-t">
                <TabGroup>
                    <TabList class="flex bg-white">
                        <Tab
                            as="template"
                            key="About"
                            v-slot="{ selected }"
                        >
                            <TabItem :selected="selected" text="About"/>
                        </Tab>
                        <Tab
                            as="template"
                            key="Posts"
                            v-slot="{ selected }"
                        >
                            <TabItem :selected="selected" text="Posts"/>
                        </Tab>

                        <Tab
                            as="template"
                            key="Followers"
                            v-slot="{ selected }"
                        >
                            <TabItem :selected="selected" text="Followers"/>
                        </Tab>
                        <Tab
                            as="template"
                            key="Followings"
                            v-slot="{ selected }"
                        >
                            <TabItem :selected="selected" text="Followings"/>
                        </Tab>
                        <Tab
                            as="template"
                            key="Photos"
                            v-slot="{ selected }"
                        >
                            <TabItem :selected="selected" text="Photos"/>
                        </Tab>
                    </TabList>

                    <TabPanels class="mt-2">
                        <TabPanel
                            key="Photos"
                            :class="[
                             ]"
                        >
                            <Edit
                                v-if="isMyProfile"
                                :must-verify-email="mustVerifyEmail"
                                :status="status"
                            />
                        </TabPanel>
                        <TabPanel
                            key="Flower"
                            :class="[
            'rounded-xl bg-white p-3',
            'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
          ]"
                        >
                            Flower
                        </TabPanel>
                    </TabPanels>
                </TabGroup>
            </div>
        </div>
    </AuthenticatedLayout>

</template>



