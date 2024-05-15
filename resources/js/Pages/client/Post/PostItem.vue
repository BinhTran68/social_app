<script setup>
import CircleImage from "@/Components/CircleImage.vue";
import ContentPost from "@/Pages/client/Post/ContentPost.vue";
import HeartIcon from "@/Icon/HeartIcon.vue";
import CommentIcon from "@/Icon/CommentIcon.vue";
import ShareIcon from "@/Icon/ShareIcon.vue";
import {formatDate} from "@/Utils/utils.js";

import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import EllipsisVerticalIcon from "@/Icon/Ellipsis-VerticalIcon.vue";
import {computed, onMounted, ref} from "vue";
import PostUserHeader from "@/Pages/client/Post/PostUserHeader.vue";
import PostModal from "@/Pages/client/Post/PostEditModal.vue";
import {router, usePage} from "@inertiajs/vue3";

const  props = defineProps({
    post: Object
})
const post_owner = props.post.user
const authUser = usePage().props.auth.user
const showEditModal =  ref(false)


const isMyPost = computed(() => (authUser && authUser.id === post_owner.id))

const deletePost = () => {
    if (window.confirm('Are you sure you want to delete this post ?')) {
        router.delete(route('post.destroy', props.post), {
            preserveScroll: true
        })
    }
}

</script>

<template>
    <div class="bg-white flex flex-col gap-4 py-3 rounded-md">
        <div class="flex items-center justify-between px-5 gap-3">
            <PostUserHeader :post="post"/>
            <div>
                <Menu as="div" class="relative inline-block text-left">
                    <div class="">
                        <MenuButton class="hover:bg-gray-300 py-1 px-1 transition rounded-full flex items-center justify-center">
                            <EllipsisVerticalIcon className="w-5 h-5 text-gray-700"/>
                        </MenuButton>
                    </div>

                    <transition
                        enter-active-class="transition duration-100 ease-out"
                        enter-from-class="transform scale-95 opacity-0"
                        enter-to-class="transform scale-100 opacity-100"
                        leave-active-class="transition duration-75 ease-in"
                        leave-from-class="transform scale-100 opacity-100"
                        leave-to-class="transform scale-95 opacity-0"
                    >
                        <MenuItems
                            class="absolute right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                        >
                            <div class="px-1 py-1">
                                <MenuItem  v-slot="{ active }">
                                    <button
                                        @click="showEditModal = true"
                                        :class="[
                                 active ? 'bg-indigo-500 text-white' : 'text-gray-900',
                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                    ]"
                                    >
                                        Edit
                                    </button>
                                </MenuItem>
                                <MenuItem   v-slot="{ active }">
                                    <button
                                        :class="[
                                 active ? 'bg-indigo-500 text-white' : 'text-red-700',
                                'group flex w-full items-center rounded-md px-2 py-2 text-sm ',
                                    ]"
                                        @click="deletePost"
                                    >
                                        Delete
                                    </button>
                                </MenuItem>
                            </div>
                        </MenuItems>
                    </transition>
                </Menu>
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
    <PostModal :post="post" v-model="showEditModal"/>
</template>

<style scoped>

</style>
