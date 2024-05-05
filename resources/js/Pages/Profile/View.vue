<script setup>
import {usePage} from "@inertiajs/vue3";
import {TabGroup, TabList, Tab, TabPanels, TabPanel} from '@headlessui/vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TabItem from "@/Pages/Profile/Partials/TabItem.vue";
import Edit from "@/Pages/Profile/Edit.vue";
import {computed, ref} from "vue";
import Button from "@/Components/Button.vue";

const authUser = usePage().props.auth.user
const coverImageSrc = ref('');


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

function onCoverChange(e) {
    const  file = e.target.file[0]
    if (file) {
        const reader = new FileReader()
        reader.onload = () => {
            coverImageSrc.value = reader.result
        }
        reader.readAsDataURL(file)
    }
}


</script>


<style scoped>

</style>

<template>
    <AuthenticatedLayout>
        <pre>{{user}}</pre>
        <div class="container max-w-[928px] h-full mx-auto ">
            <div class="relative bg-white">
                <img
                    src="https://i0.wp.com/nftartwithlauren.com/wp-content/uploads/2023/11/laurenmcdonaghpereiraphoto_A_field_of_blooming_sunflowers_und_40d30d23-9ecd-489f-a2b9-5a8f7293af9a_0.png?fit=1024%2C574&ssl=1"
                    alt="cover photo"
                    class="object-cover  w-full h-[350px] "
                >
                <label for="cover-image" class="
                absolute top-72 right-2 bg-gray-50 px-2 py-1
                rounded-md opacity-90 hover:bg-gray-200 cursor-pointer">
                   <span class="flex items-center justify-center gap-3">
                        <span >
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                             </svg>
                        </span>
                       <span>
                           Update Cover Photo
                       </span>
                   </span>
                </label>
                <input type="file" @change="onCoverChange" name="cover-image" id="cover-image" hidden="">
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



