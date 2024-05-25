<script setup>
import ContentPost from "@/Pages/client/Post/ContentPost.vue";
import HeartIcon from "@/Icon/HeartIcon.vue";
import CommentIcon from "@/Icon/CommentIcon.vue";
import ShareIcon from "@/Icon/ShareIcon.vue";
import {Menu, MenuButton, MenuItems, MenuItem, Disclosure, DisclosurePanel, DisclosureButton} from '@headlessui/vue'
import EllipsisVerticalIcon from "@/Icon/Ellipsis-VerticalIcon.vue";
import {computed, onMounted, ref, watch} from "vue";
import PostUserHeader from "@/Pages/client/Post/PostUserHeader.vue";
import {router, usePage} from "@inertiajs/vue3";
import PostModal from "@/Pages/client/Post/PostModal.vue";
import InputFieldWithButton from "@/Components/InputFieldWithButton.vue";
import CircleImage from "@/Components/CircleImage.vue";
import {formatDate} from "../../../Utils/utils.js";


const props = defineProps({
    post: Object
})
const post_owner = props.post.user
const authUser = usePage().props.auth.user


const comment = ref('');
const showEditModal = ref(false)
const isProcessing = ref(false);
const postEdit = ref(null);
const isLike = ref(false);
const isMyPost = computed(() => (authUser && authUser.id === post_owner.id))
const deletePost = () => {
    if (window.confirm('Are you sure you want to delete this post ?')) {
        router.delete(route('post.destroy', props.post), {
            preserveScroll: true
        })
    }
}

const handleClickReact = () => {
    if (props.post.current_user_has_reaction) {
        props.post.current_user_has_reaction = false
        props.post.num_of_reactions =  props.post.num_of_reactions-1
    }else  {
        props.post.current_user_has_reaction = true
        props.post.num_of_reactions =  props.post.num_of_reactions + 1
    }
    axios.post(route('post.reaction', props.post), {
        reaction: 'like'
    }).then((res) => {
        props.post.num_of_reactions = res.data.num_of_reactions
    }).catch(e => {

    })
}

watch(showEditModal, () => {
    if (showEditModal.value) {
        postEdit.value = props.post
    }else {
        postEdit.value = null
    }
})

const  handleOnSubmitComment = (value) => {

    axios.post(route('post.comment', props.post), {
        'comment' : value
    }).then((res) => {
        props.post.comments.push(res.data);
    }).catch(e => {

    }).finally(() => {
        isProcessing.value  = false
        comment.value = ''
    })
}


</script>

<template>
    <div class="bg-white flex flex-col gap-4 py-3 rounded-md">
        <div class="flex items-center justify-between px-5 gap-3">
            <PostUserHeader :post="post"/>
            <div>
                <Menu as="div" class="relative inline-block text-left z-50">
                    <div class="">
                        <MenuButton
                            class="hover:bg-gray-300 py-1 px-1 transition rounded-full flex items-center justify-center">
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
                                <MenuItem v-slot="{ active }">
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
                                <MenuItem v-slot="{ active }">
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
        <Disclosure v-slot="{ open }">
        <div class="flex flex-col gap-3">
            <ContentPost class="" :body="post.body" :media="post.attachments"/>
            <div class="flex items-center px-5 justify-start gap-5 ">
                <span @click="handleClickReact"
                      class="cursor-pointer flex items-center gap-2 hover:opacity-60">
                      <HeartIcon :fill="post.current_user_has_reaction ? 'red' : 'none'" className="w-8"/>
                     {{post.num_of_reactions}} likes
                </span>

                <DisclosureButton
                >
                   <span
                       @click="ontoggleCommentSection"
                       class="flex items-center gap-3 cursor-pointer hover:opacity-60">
                     <CommentIcon :className="'w-6 h-6'"/> {{ post.num_of_comments || 0}} comments
                </span>
                </DisclosureButton>
            </div>
            <div class="px-5">
                    <DisclosurePanel  class="pb-2 pt-4 text-sm text-gray-500 flex flex-col gap-3">
                            <div v-for="cmt of post.comments" class="flex justify-start gap-3">
                                <div class="mt-2">
                                    <CircleImage :src="cmt.user.avatar_url"
                                                 :alt="cmt.user.name"  />
                                </div>
                                <div class="">
                                    <div class="flex flex-col bg-gray-200 py-2 px-3 rounded-md gap-2">
                                        <span class="font-bold text-gray-700">{{ cmt.user.name }}</span>
                                        <span class="text-black">{{ cmt.comment }}</span>
                                    </div>
                                    <small class="text-sm flex gap-3">
                                        <span>
                                             {{ formatDate(cmt.updated_at) }}
                                        </span>
                                          <span class="text-indigo">
                                             Like
                                        </span>
                                          <span class="text-indigo">
                                             Reply
                                        </span>
                                    </small>
                                </div>
                            </div>
                    </DisclosurePanel>
                <InputFieldWithButton
                    :isProcessing="isProcessing"
                    v-model="comment"
                    @onSubmit="handleOnSubmitComment"
                />
            </div>
        </div>
        </Disclosure>
    </div>
    <PostModal
        v-if="postEdit"
        :postEdit="postEdit"
        :isEdit="true"
        v-model="showEditModal"
    />

</template>

<style scoped>

</style>
