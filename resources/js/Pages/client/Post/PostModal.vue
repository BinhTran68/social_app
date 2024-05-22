<script setup>
import {computed, ref, watch} from 'vue'
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot,} from '@headlessui/vue'
import XmarkIcon from "@/Icon/XmarkIcon.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import VideoIcon from "@/Icon/VideoIcon.vue";
import ImageIcon from "@/Icon/ImageIcon.vue";
import Button from "@/Components/Button.vue";
import SmileIcon from "@/Icon/SmileIcon.vue";
import LocationMapIcon from "@/Icon/LocationMapIcon.vue";
import {isImage} from "@/Utils/utils.js";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import DetailsImagesPost from "@/Components/DetailsImagesPost.vue";
import {toast} from "vue3-toastify";
import InputError from "@/Components/InputError.vue";

// ckEditor config
const  editor = ClassicEditor
const editorConfig =  {
    toolbar: [  'undo', 'redo',
        'heading',
        'bold', 'italic',
        'link', 'blockQuote',
        'bulletedList', 'numberedList', 'outdent', 'indent']
}


const props = defineProps({
    modelValue: Boolean,
    postEdit : {
        type: Object
    },
    isEdit: {
        type: Boolean,
        default: false
    }
})

const authUser = usePage().props.auth.user
const postForm = useForm({
    id: null,
    body: '',
    attachments : [],
    deleted_file_ids : []
})

// State
const attachmentFiles = ref([])
const errorsRef = ref(null);

const handleOnSubmit =  () => {
    const validAttachments = attachmentFiles.value.filter(myFile => myFile.file);

    if (props.isEdit) {
        postForm.attachments = validAttachments.map((myFile) => {
            return myFile.file
        })
        postForm.post(route('post.update', props.postEdit), {
            onSuccess: () => {
                show.value = false
                toast.success("Update Post successfully.")
            },
            onError : (errors) => {
                toast.error("Somethings went wrong !")
            }
        })
    }else {
        postForm.attachments = attachmentFiles.value.map((myFile) => {
            return myFile.file
        })
        postForm.post(route('post.create'), {
            onSuccess: () => {
                postForm.reset()
                show.value = false
                resetValues()
                toast.success("Create Post successfully.")
            },
            onError: (errors) => {
                errorsRef.value = errors
            }
        })
    }
}
const emit = defineEmits(['update:modelValue'])

// computed by Vue3
// Generate values based on calculations that only recalculate when properties change
const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})


function closeModal() {
    show.value = false
    resetValues();
}

const resetValues = () => {
    errorsRef.value = null
    attachmentFiles.value = []

}

const onSelectImages = async (e) => {
    clearError('attachments')
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

const handleDeleteImage = (index) => {
    clearError('attachments')
    attachmentFiles.value = attachmentFiles.value.filter((_, i) => {
        if (_.id && i === index) {
            postForm.deleted_file_ids.push(_.id);
        }
        return i !== index;
    });
};

watch(() => props.postEdit, (newPostEdit) => {
    if (newPostEdit) {
        postForm.body = newPostEdit.body || ''
        postForm.id = props.postEdit.id
        attachmentFiles.value = newPostEdit.attachments || []
    } else {
        resetValues()
    }
}, { immediate: true })

const clearError = (field) => {
    if (errorsRef.value) {
        errorsRef.value[field] = null;
    }
};


</script>
<template>
    <!-- teleport ensure element child always located on body element   -->
    <teleport to="body">
        <TransitionRoot appear :show="show" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-50">
                <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-black/25" />
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div
                        class="flex min-h-full items-center justify-center p-4 text-center"
                    >
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                            class="max-w-xl"
                        >
                            <DialogPanel
                                class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-4 text-left align-middle shadow-xl transition-all"
                            >
                                <DialogTitle
                                    as="h3"
                                    class="
                                    text-lg
                                    font-medium
                                    leading-6
                                    text-gray-900
                                    flex items-center

                                    justify-between"
                                >
                                    <span v-if="!isEdit">
                                        Create Post
                                    </span>
                                    <span v-else>
                                        Edit Post
                                    </span>
                                    <span
                                        @click="closeModal"
                                        class="cursor-pointer hover:opacity-50" >
                                        <XmarkIcon :className="['w-5 ']"/>
                                    </span>
                                </DialogTitle>
                                <div class="mt-2 flex flex-col gap-4">
                                    <div class="mb-5 ">
                                        <div class="px-6 py-3 bg-white rounded-md relative">
                                            <hr>
                                            <div class="py-5 flex flex-col gap-5">
                                                <div class="flex flex-col gap-2">
                                                    <ckeditor
                                                        @input="clearError('body')"
                                                        :editor="editor"
                                                        v-model="postForm.body"
                                                        :config="editorConfig">
                                                    </ckeditor>
                                                    <InputError v-if="errorsRef && errorsRef.body"
                                                                :message="errorsRef.body || '' "
                                                    />
                                                </div>

                                                <div class="px-1 flex flex-col gap-2">
                                                    <DetailsImagesPost
                                                        @handle-delete-image="handleDeleteImage"
                                                        v-if="attachmentFiles.length > 0"
                                                        :media="attachmentFiles"
                                                    />
                                                    <InputError v-if="errorsRef && errorsRef.attachments"
                                                                :message="errorsRef.attachments || '' "
                                                    />
                                                </div>
                                                <div  class="border py-2 px-3 rounded-md flex items-center justify-between">
                                                    <h6 class="font-bold">Add to your post</h6>
                                                    <div class="flex items-center justify-center gap-3">
                                                        <label for="post-images" class="">
                                                            <ImageIcon class="w-8 h-8 text-green hover:bg-gray-200 rounded cursor-pointer"/>
                                                        </label>
                                                        <input
                                                            @click.stop type="file"
                                                            multiple id="post-images"
                                                            hidden
                                                            accept="image/*"
                                                            @change="onSelectImages"

                                                        >
                                                        <span>
                                  <VideoIcon class="w-8 h-8 text-purple-500 hover:bg-gray-200 rounded cursor-pointer"/>
                            </span>
                                                        <span>
                                <SmileIcon class="w-8 h-8 text-amber-500 hover:bg-gray-200 rounded cursor-pointer"/>
                            </span>
                                                        <span>
                                <LocationMapIcon class="w-8 h-8 text-red-500 hover:bg-gray-200 rounded cursor-pointer"/>
                            </span>
                                                    </div>
                                                </div>

                                            </div>
                                            <Button
                                                @click="handleOnSubmit"
                                                :class="['w-full']">
                                                Post
                                            </Button>
                                        </div>
                                    </div>
                                </div>

                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </teleport>

</template>

