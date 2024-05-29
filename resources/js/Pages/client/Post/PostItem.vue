<script setup>
import ContentPost from "@/Pages/client/Post/ContentPost.vue";
import HeartIcon from "@/Icon/HeartIcon.vue";
import CommentIcon from "@/Icon/CommentIcon.vue";
import {Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import EllipsisVerticalIcon from "@/Icon/Ellipsis-VerticalIcon.vue";
import {computed, ref, watch} from "vue";
import PostUserHeader from "@/Pages/client/Post/PostUserHeader.vue";
import {router, usePage} from "@inertiajs/vue3";
import PostModal from "@/Pages/client/Post/PostModal.vue";
import InputFieldWithButton from "@/Components/InputFieldWithButton.vue";
import CircleImage from "@/Components/CircleImage.vue";
import {formatDate} from "@/Utils/utils.js";
import EllipsisIcon from "@/Icon/EllipsisIcon.vue";
import ProgressCircularIcon from "@/Icon/ProgressCircularIcon.vue";
import {BASE_URL} from "@/Utils/Constant.js";


const props = defineProps({
    post: Object
})
const post_owner = props.post.user
const authUser = usePage().props.auth.user

const commentRef = ref('');
const replyCommentContent = ref('');
const showEditModal = ref(false)
const isProcessing = ref(false);
const postEdit = ref(null);
const replyComment = ref({
    parentId: null,
    replyUser: null,
    subCmtId : null
});
const replySubComment = ref({
    parentId: null,
    subCommentId: null,
    replyUser: null
});

const isLike = ref(false);

const commentEdit = ref({
    id: null,
    comment: ''
})


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
        props.post.num_of_reactions = props.post.num_of_reactions - 1
    } else {
        props.post.current_user_has_reaction = true
        props.post.num_of_reactions = props.post.num_of_reactions + 1
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
    } else {
        postEdit.value = null
    }
})

const handleOnSubmitComment = ({content, parentCmtId}) => {
    axios.post(route('post.comment', props.post), {
        'comment': content,
        'parent_id': parentCmtId
    }).then((res) => {
        props.post.comments.push(res.data);
        if (parentCmtId) {
            const parentComment = props.post.comments.find((cmt) => cmt.id === parentCmtId)
            parentComment.sub_comments.push(res.data);
            props.post.comments = props.post.comments.map((cmt) => {
                if (cmt.id === parentCmtId) {
                    return parentComment
                }else {
                    return cmt
                }
            })
        }
    }).catch(e => {

    }).finally(() => {
        isProcessing.value = false
        commentRef.value = ''
        replyCommentContent.value = ''
            replyComment.value.parentId = null
        replyComment.value.replyUser = null
    })
}

const handleOnSubmitEditComment = () => {
    axios.put(`${BASE_URL}/posts/${commentEdit.value.id}/comments`, {
        'comment': commentEdit.value.comment
    }).then((res) => {
        props.post.comments = props.post.comments.map((comment) => {
            if (comment.id === res.data.id) {
                return res.data
            }
            return comment
        })
        handleCancelEditComment()
    }).finally(() => {
        isProcessing.value = false
        commentRef.value = ''
        replyCommentContent.value = ''
    })
}

const handleDeleteComment = (id) => {
    if (window.confirm('Are you sure you want to delete this comment ?')) {
        axios.delete(route('post.comment.destroy', id))
            .then((res) => {
                props.post.comments = props.post.comments.filter((comment) => comment.id !== id)
            }).catch((e) => {

        })
    }
}

const handleViewMoreComments = () => {
    isProcessing.value = true
    axios.get(route('post.view_more_comment', props.post), {
        params: {
            page: props.post.current_page_comment + 1,
        },
    }).then((res) => {
        props.post.current_page_comment++
        const prevComments = [...props.post.comments, ...res.data.data]
        prevComments.sort((a, b) => {
            const dateA = new Date(a.created_at);
            const dateB = new Date(b.created_at);
            if (dateA < dateB) {
                return -1;
            }
            if (dateA > dateB) {
                return 1;
            }
            return 0;
        })
        props.post.comments = prevComments
    }).catch(() => {

    }).finally(() => {
        isProcessing.value = false
    })
}

const handleOnEditComment = (id, comment) => {
    commentEdit.value = {
        id: id,
        comment: comment
    }
}

const handleCancelEditComment = () => {
    commentEdit.value.id = null;
    commentEdit.value.comment = '';
}

const handleReactionComment = (id, parentId) => {
    let comment, subComment;

    if (parentId) {
        comment = props.post.comments.find((cmt) => cmt.id === parentId);
        subComment = comment.sub_comments.find((cmt) => cmt.id === id);
        if (subComment.current_user_has_reaction_comment) {
            subComment.current_user_has_reaction_comment = false;
            subComment.num_of_reaction_comments -= 1;
        } else {
            subComment.current_user_has_reaction_comment = true;
            subComment.num_of_reaction_comments += 1;
        }
    } else {
        comment = props.post.comments.find((cmt) => cmt.id === id);
        if (comment.current_user_has_reaction_comment) {
            comment.current_user_has_reaction_comment = false;
            comment.num_of_reaction_comments -= 1;
        } else {
            comment.current_user_has_reaction_comment = true;
            comment.num_of_reaction_comments += 1;
        }
    }

    axios.post(route('post.comment_reaction', id), {
        'reaction': 'like'
    }).then((response) => {
        if (!parentId) {
            props.post.comments = props.post.comments.map((cmt) => {
                if (cmt.id === id) {
                    return {
                        ...cmt,
                        num_of_reaction_comments: response.data.num_of_reaction_comments,
                    };
                }
                return cmt;
            });
        } else {
            props.post.comments = props.post.comments.map((cmt) => {
                if (cmt.id === parentId) {
                    return {
                        ...cmt,
                        sub_comments: cmt.sub_comments.map((sCmt) => {
                            if (sCmt.id === id) {
                                return {
                                    ...sCmt,
                                    num_of_reaction_comments: response.data.num_of_reaction_comments,
                                };
                            }
                            return sCmt;
                        })
                    };
                }
                return cmt;
            });
        }
    }).catch(() => {
        if (parentId) {
            if (subComment.current_user_has_reaction_comment) {
                subComment.current_user_has_reaction_comment = false;
                subComment.num_of_reaction_comments -= 1;
            } else {
                subComment.current_user_has_reaction_comment = true;
                subComment.num_of_reaction_comments += 1;
            }
        } else {
            if (comment.current_user_has_reaction_comment) {
                comment.current_user_has_reaction_comment = false;
                comment.num_of_reaction_comments -= 1;
            } else {
                comment.current_user_has_reaction_comment = true;
                comment.num_of_reaction_comments += 1;
            }
        }
    })
};


const replyToComment = (parentId, user) => {
        replyComment.value.parentId = parentId
        replyComment.value.replyUser = user
}

const handleCancelReplyComment = () => {
    replyComment.value.parentId = null
    replyComment.value.replyUser = null
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
                                  v-if="post.num_of_comments > post.comments.length"
                                  class="font-weight-bold text-gray-700 cursor-pointer hover:opacity-60">
                             View more comment
                        </span>
                            <DisclosureButton class="font-weight-bold text-gray-700 cursor-pointer hover:opacity-60">
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
                                    <span v-if="cmt.num_of_sub_comments > 0"
                                          class="text-indigo-500 font-weight-bold cursor-pointer">
                                            View more replies
                                    </span>
                                    <span class="text-indigo-500 font-weight-bold ">
                                        Total {{ cmt.num_of_sub_comments }} replies
                                    </span>
                                </div>
                                <div v-for="subCmt in cmt.sub_comments" class="flex  justify-start gap-2">
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
                                        <div>
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
                                        <div class="flex items-center justify-start gap-2">

                                        </div>
                                    </div>
                                </div>
                                <div v-if="cmt.id === replyComment.parentId">
                                    <InputFieldWithButton
                                        :tagToUser="replyComment.replyUser"
                                        :isProcessing="isProcessing"
                                        v-model="replyCommentContent"
                                        :parent-cmt-id="cmt.id"
                                        @onSubmit="handleOnSubmitComment"
                                    />
                                    <span @click="handleCancelReplyComment" class="font-weight-bold text-indigo-500 cursor-pointer">
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
                                                    @click="handleDeleteComment(cmt.id)"
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
