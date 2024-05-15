<script setup>
import {computed, ref} from 'vue'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'
import InputTextarea from "@/Components/InputTextarea.vue";
import PostUserHeader from "@/Pages/client/Post/PostUserHeader.vue";
import XmarkIcon from "@/Icon/XmarkIcon.vue";
import {router, useForm} from "@inertiajs/vue3";


const  props = defineProps({
    post: {
        type: Object,
        required: true
    },
    modelValue: Boolean

})

const emit = defineEmits(['update:modelValue'])

// computed by Vue3
// Generate values based on calculations that only recalculate when properties change
const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})
function closeModal() {
    show.value = false
}

function submit() {
    const  form = useForm({
        id : props.post.id,
        body : props.post.body
    })
    form.put(route('post.update', props.post), {
        onSuccess: () => {
            show.value = false
        }
    })
}

</script>
<template>
<!-- teleport ensure element child always located on body element   -->
    <teleport to="body">
        <TransitionRoot appear :show="show" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-10">
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
                        >
                            <DialogPanel
                                class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                            >
                                <DialogTitle
                                    as="h3"
                                    class="text-lg font-medium leading-6 text-gray-900 flex items-center justify-between"
                                >
                                    <span >
                                        Update Post
                                    </span>
                                    <span
                                        @click="closeModal"
                                        class="cursor-pointer hover:opacity-50" >
                                        <XmarkIcon :className="['w-5 ']"/>
                                    </span>
                                </DialogTitle>
                                <div class="mt-2 flex flex-col gap-4">
                                    <PostUserHeader :post="post"/>
                                    <InputTextarea v-model="post.body"/>
                                </div>

                                <div class="mt-4">
                                    <button
                                        type="button"
                                        class="
                                        inline-flex
                                        justify-center
                                        rounded-md border
                                        border-transparent
                                        w-full
                                        bg-indigo-500
                                         px-4 py-2
                                        text-sm font-medium
                                        text-blue-900 hover:bg-indigo-600 focus:outline-none
                                        focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                        @click="submit"
                                    >
                                        Submit
                                    </button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </teleport>

</template>

