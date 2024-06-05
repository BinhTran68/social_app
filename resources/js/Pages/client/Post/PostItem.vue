<script setup>
import { ref, computed, watch } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import axios from 'axios';
import {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems
} from '@headlessui/vue';
import { formatDate } from "@/Utils/utils.js";
import { BASE_URL } from "@/Utils/Constant.js";
import ContentPost from "@/Pages/client/Post/ContentPost.vue";
import HeartIcon from "@/Icon/HeartIcon.vue";
import CommentIcon from "@/Icon/CommentIcon.vue";
import EllipsisVerticalIcon from "@/Icon/Ellipsis-VerticalIcon.vue";
import PostUserHeader from "@/Pages/client/Post/PostUserHeader.vue";
import PostModal from "@/Pages/client/Post/PostModal.vue";
import InputFieldWithButton from "@/Components/InputFieldWithButton.vue";
import CircleImage from "@/Components/CircleImage.vue";
import EllipsisIcon from "@/Icon/EllipsisIcon.vue";
import ProgressCircularIcon from "@/Icon/ProgressCircularIcon.vue";

const props = defineProps({
    post: Object
});
const post_owner = props.post.user;
const authUser = usePage().props.auth.user;

const commentRef = ref('');
const replyCommentContent = ref('');
const showEditModal = ref(false);
const isProcessing = ref(false);
const postEdit = ref(null);
const replyComment = ref({
    parentId: null,
    replyUser: null,
    subCmtId: null
});

const commentEdit = ref({
    id: null,
    comment: ''
});

const isMyPost = computed(() => (authUser && authUser.id === post_owner.id));

watch(showEditModal, () => {
    postEdit.value = showEditModal.value ? props.post : null;
});

const deletePost = () => {
    if (confirm('Are you sure you want to delete this post ?')) {
        router.delete(route('post.destroy', props.post), { preserveScroll: true });
    }
};

const handleClickReact = () => {
    toggleReactionState(props.post);
    axios.post(route('post.reaction', props.post), { reaction: 'like' })
        .then(res => {
            props.post.num_of_reactions = res.data.num_of_reactions;
        })
        .catch(() => {
            toggleReactionState(props.post); // Revert state on failure
        });
};

const toggleReactionState = (post) => {
    post.current_user_has_reaction = !post.current_user_has_reaction;
    post.num_of_reactions += post.current_user_has_reaction ? 1 : -1;
};

const handleOnSubmitComment = async ({ content, parentCmtId }) => {
    isProcessing.value = true;
    try {
        const res = await axios.post(route('post.comment', props.post), { comment: content, parent_id: parentCmtId });
        if (parentCmtId) {
            updateParentComment(res.data, parentCmtId);
        } else {
            props.post.comments.push(res.data);
        }
        resetCommentForm();
    } catch (error) {
        console.error(error);
    } finally {
        isProcessing.value = false;
    }
};

const handleOnSubmitEditComment = async ({ content, parentCmtId }) => {
    isProcessing.value = true;
    try {
        const res = await axios.put(`${BASE_URL}/posts/${commentEdit.value.id}/comments`, { comment: commentEdit.value.comment });
        updateComment(res.data, parentCmtId);
        handleCancelEditComment();
    } catch (error) {
        console.error(error);
    } finally {
        isProcessing.value = false;
    }
};

const handleDeleteComment = async (id, parentId) => {
    if (confirm('Are you sure you want to delete this comment ?')) {
        try {
            await axios.delete(route('post.comment.destroy', id));
            removeComment(id, parentId);
        } catch (error) {
            console.error(error);
        }
    }
};

const handleViewMoreComments = async () => {
    isProcessing.value = true;
    try {
        const res = await axios.get(route('post.view_more_comment', props.post), { params: { page: props.post.current_page_comment + 1 } });
        props.post.current_page_comment++;
        props.post.comments = mergeAndSortComments(props.post.comments, res.data.data);
    } catch (error) {
        console.error(error);
    } finally {
        isProcessing.value = false;
    }
};

const handleOnEditComment = (id, comment) => {
    commentEdit.value = { id, comment };
};

const handleCancelEditComment = () => {
    commentEdit.value = { id: null, comment: '' };
};

const handleReactionComment = async (id, parentId) => {
    toggleCommentReactionState(id, parentId);
    try {
        const response = await axios.put(route('post.comment.reaction', id), { reaction: 'like' });
        updateCommentReactionCount(id, parentId, response.data.num_of_reaction_comments);
    } catch (error) {
        console.log(error)
        toggleCommentReactionState(id, parentId); // Revert state on failure
    }
};

const replyToComment = (parentId, user) => {
    replyComment.value = { parentId, replyUser: user };
};

const handleCancelReplyComment = () => {
    replyComment.value = { parentId: null, replyUser: null };
};

// Helper Functions
const updateParentComment = (newComment, parentCmtId) => {
    const parentComment = props.post.comments.find(cmt => cmt.id === parentCmtId);
    parentComment.sub_comments.push(newComment);
    props.post.comments = props.post.comments.map(cmt => (cmt.id === parentCmtId ? parentComment : cmt));
};

const updateComment = (updatedComment, parentCmtId) => {
    if (!parentCmtId) {
        props.post.comments = props.post.comments.map(comment => (comment.id === updatedComment.id ? updatedComment : comment));
    } else {
        props.post.comments = props.post.comments.map(comment => {
            if (comment.id === parentCmtId) {
                comment.sub_comments = comment.sub_comments.map(subCmt => (subCmt.id === updatedComment.id ? updatedComment : subCmt));
            }
            return comment;
        });
    }
};

const removeComment = (id, parentId) => {
    if (parentId) {
        const parentComment = props.post.comments.find(cmt => cmt.id === parentId);
        parentComment.sub_comments = parentComment.sub_comments.filter(subCmt => subCmt.id !== id);
        props.post.comments = props.post.comments.map(cmt => (cmt.id === parentId ? parentComment : cmt));
    } else {
        props.post.comments = props.post.comments.filter(comment => comment.id !== id);
    }
};

const mergeAndSortComments = (existingComments, newComments) => {
    return [...existingComments, ...newComments].sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
};

const toggleCommentReactionState = (id, parentId) => {
    console.log(id, parentId)
    let comment;
    if (parentId) {
        const parentComment = props.post.comments.find(cmt => cmt.id === parentId);
        comment = parentComment.sub_comments.find(subCmt => subCmt.id === id);
        console.log(comment);
    } else {
        comment = props.post.comments.find(cmt => cmt.id === id);
    }
    comment.current_user_has_reaction_comment = !comment.current_user_has_reaction_comment;
    comment.num_of_reaction_comments += comment.current_user_has_reaction_comment ? 1 : -1;
};

const updateCommentReactionCount = (id, parentId, newCount) => {
    if (parentId) {
        props.post.comments = props.post.comments.map(comment => {
            if (comment.id === parentId) {
                comment.sub_comments = comment.sub_comments.map(subCmt =>
                    (subCmt.id === id ? { ...subCmt, num_of_reaction_comments: newCount } : subCmt));
            }
            return comment;
        });
    } else {
        props.post.comments = props.post.comments.map(comment => (comment.id === id ? { ...comment, num_of_reaction_comments: newCount } : comment));
    }
};

const resetCommentForm = () => {
    commentRef.value = '';
    replyCommentContent.value = '';
    replyComment.value = { parentId: null, replyUser: null };
};

// Report
const handleOnReportThisPost = () => {
    alert('report')
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
                                <MenuItem v-if="isMyPost" v-slot="{ active }">
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
                                <MenuItem v-if="isMyPost" v-slot="{ active }">
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
                                <MenuItem v-if="!isMyPost" v-slot="{ active }">
                                    <button
                                        :class="[
                                 active ? 'bg-indigo-500 text-white' : 'text-red-700',
                                'group flex w-full items-center rounded-md px-2 py-2 text-sm ',
                                    ]"
                                        @click="handleOnReportThisPost"
                                    >
                                        Report
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
                      class="cursor-pointer flex items-center gap-2 ">
                    <span class="w-8 h-8">
                           <HeartIcon :fill="post.current_user_has_reaction ? 'red' : 'none'"
                                      className="w-7 hover:w-8"/>
                    </span>
                     <span>
                     {{ post.num_of_reactions }} likes
                    </span>
                </span>
                    <DisclosureButton
                    >
                   <span
                       @click="ontoggleCommentSection"
                       class="flex items-center gap-3 cursor-pointer hover:opacity-60">
                     <CommentIcon :className="'w-6 h-6'"/> {{ post.num_of_comments || 0 }} comments
                </span>
                    </DisclosureButton>
                </div>
                <div class="px-5">
                    <DisclosurePanel class="pb-2 pt-4 text-sm text-gray-500 flex flex-col gap-3">
                        <div class="flex items-center  justify-between">
                            <span v-if="isProcessing">
                                <ProgressCircularIcon/>
                            </span>
                            <span v-show="!isProcessing" @click="handleViewMoreComments"
                                  v-if="post.num_of_parent_comments > post.comments.length"
                                  class="text-indigo font-weight-bold cursor-pointer hover:opacity-60">
                             View more comment
                        </span>
                            <DisclosureButton class="font-weight-bold text-indigo cursor-pointer hover:opacity-60">
                                Hide comments
                            </DisclosureButton>
                        </div>
                        <div v-for="(cmt) of post.comments" class="flex justify-start gap-3">
                            <div class="mt-2">
                                <CircleImage :src="cmt.user.avatar_url"
                                             :alt="cmt.user.name"/>
                            </div>
                            <div v-if="cmt.id!==commentEdit.id" class="w-100">
                                <div class="flex flex-col bg-gray-200 py-2 px-3 rounded-lg ">
                                    <span class="font-bold text-gray-700">{{ cmt.user.name }}</span>
                                    <span class="text-black">{{ cmt.comment }}</span>
                                </div>
                                <div>
                                </div>
                                <span class="text-sm flex gap-3">
                                        <span>
                                             {{ formatDate(cmt.updated_at) }}
                                        </span>
                                    <span class="flex items-center  justify-start gap-1 ">
                                            <span @click="handleReactionComment(cmt.id, undefined)"
                                                  class="cursor-pointer w-5">
                                                <HeartIcon
                                                    :fill="cmt.current_user_has_reaction_comment ? 'red' : 'none'"
                                                    className="w-4 hover:w-5"/>
                                            </span>
                                            <span>
                                                {{ cmt.num_of_reaction_comments }}
                                                 likes
                                            </span>
                                        </span>
                                         <span @click="replyToComment(cmt.id, cmt.user)"
                                               class="text-indigo cursor-pointer">
                                             Reply
                                        </span>
                                </span>
                                <div class="flex items-center  justify-between">
                                    <span
                                        v-if="cmt.num_of_sub_comments > 0 && cmt.num_of_sub_comments > cmt.sub_comments.length"
                                        class="text-indigo-500 font-weight-bold cursor-pointer">
                                        View more replies
                                    </span>
                                    <span v-if="cmt.num_of_sub_comments > 0" class="text-indigo-500 font-weight-bold ">
                                        Total {{ cmt.num_of_sub_comments }} replies
                                    </span>
                                </div>
                                <div v-for="subCmt in cmt.sub_comments" class="flex w-full justify-start gap-2">
                                    <div class="mt-2">
                                        <CircleImage :src="subCmt.user.avatar_url"
                                                     :alt="subCmt.user.name"
                                        />
                                    </div>
                                    <div v-if="subCmt.id!==commentEdit.id" class="w-100">
                                        <div class="flex flex-col bg-gray-200 py-2 px-3 rounded-lg ">
                                            <span class="font-bold text-gray-700">{{ subCmt.user.name }}</span>
                                            <span class="text-black">{{ subCmt.comment }}</span>
                                        </div>
                                        <span class="text-sm flex gap-3">
                                        <span>
                                             {{ formatDate(subCmt.updated_at) }}
                                        </span>
                                    <span class="flex items-center  justify-start gap-1 ">
                                            <span @click="handleReactionComment(subCmt.id, cmt.id)"
                                                  class="cursor-pointer w-5">
                                                <HeartIcon
                                                    :fill="subCmt.current_user_has_reaction_comment ? 'red' : 'none'"
                                                    className="w-4 hover:w-5"/>
                                            </span>
                                            <span>
                                                {{ subCmt.num_of_reaction_comments }}
                                                 likes
                                            </span>
                                        </span>
                                         <span @click="replyToComment(cmt.id, subCmt.user)"
                                               class="text-indigo cursor-pointer">
                                             Reply
                                        </span>
                                        </span>
                                    </div>
                                    <div>
                                        <Menu as="div" class="relative inline-block text-left ">
                                            <div v-if="subCmt.id !== commentEdit.id" class="">
                                                <MenuButton
                                                    class="hover:bg-gray-300 z-10 py-1 px-1 transition rounded-full flex items-center justify-center">
                                                    <EllipsisIcon class-name="w-4"/>
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
                                                    class="
                                                    absolute right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100
                                                    z-50
                                                    rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                                                >
                                                    <div class="px-1 py-1">
                                                        <MenuItem v-if="cmt.id" v-slot="{ active }">
                                                            <button
                                                                @click="handleOnEditComment(subCmt.id, subCmt.comment)"
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
                                'group flex w-full items-center bg rounded-md px-2 py-2 text-sm ',
                                    ]"
                                                                @click="handleDeleteComment(subCmt.id, cmt.id)"
                                                            >
                                                                Delete
                                                            </button>
                                                        </MenuItem>
                                                    </div>
                                                </MenuItems>
                                            </transition>
                                        </Menu>
                                    </div>
                                          <span class="w-full py-2 flex flex-col gap-1" v-if="subCmt.id === commentEdit.id">
                                          <InputFieldWithButton
                                              :parent-cmt-id="cmt.id"
                                              :is-processing="isProcessing"
                                              v-model="commentEdit.comment"
                                              @onSubmit="handleOnSubmitEditComment"
                                          />
                                    <span
                                        @click="handleCancelEditComment"
                                    >
                                        Press Esc to
                                        <span class="text-indigo-500 cursor-pointer hover:underline">
                                            Cancel
                                        </span>
                                    </span>
                                    </span>
                                </div>
                                <div v-if="cmt.id === replyComment.parentId">
                                    <InputFieldWithButton
                                        :tagToUser="replyComment.replyUser"
                                        :isProcessing="isProcessing"
                                        v-model="replyCommentContent"
                                        :parent-cmt-id="cmt.id"
                                        @onSubmit="handleOnSubmitComment"
                                    />
                                    <span @click="handleCancelReplyComment"
                                          class="font-weight-bold text-indigo-500 cursor-pointer">
                                        Cancel
                                    </span>
                                </div>
                            </div>
                            <span class="w-full py-2 flex  flex-col gap-1" v-if="cmt.id === commentEdit.id">
                                          <InputFieldWithButton
                                              :is-processing="isProcessing"
                                              v-model="commentEdit.comment"
                                              @onSubmit="handleOnSubmitEditComment"
                                          />
                                    <span
                                        @click="handleCancelEditComment"
                                    >
                                        Press Esc to
                                        <span class="text-indigo-500 cursor-pointer hover:underline">
                                            Cancel
                                        </span>
                                    </span>
                                    </span>
                            <Menu as="div" class="relative inline-block text-left z-50">
                                <div v-if="cmt.id !== commentEdit.id" class="">
                                    <MenuButton
                                        class="hover:bg-gray-300 py-1 px-1 transition rounded-full flex items-center justify-center">
                                        <EllipsisIcon class-name="w-4"/>
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
                                                    @click="handleOnEditComment(cmt.id, cmt.comment)"
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
                                                    @click="handleDeleteComment(cmt.id, null)"
                                                >
                                                    Delete
                                                </button>
                                            </MenuItem>
                                        </div>
                                    </MenuItems>
                                </transition>
                            </Menu>
                        </div>
                    </DisclosurePanel>
                    <InputFieldWithButton
                        :isProcessing="isProcessing"
                        v-model="commentRef"
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
