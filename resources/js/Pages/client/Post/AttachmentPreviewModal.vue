<script setup>
import {computed} from 'vue'
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot,} from '@headlessui/vue'
import XmarkIcon from "@/Icon/XmarkIcon.vue";

const props = defineProps({
    modelValue: Boolean,
    attachment: {
        type: Object,
        required: true
    }
})


const emit = defineEmits(['update:modelValue'])
const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})

function closeModal() {
    show.value = false
}

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
                    <div class="fixed inset-0 bg-black/25"/>
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div
                        class="flex py-5 min-h-full items-center justify-center text-center"
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
                                class="
                                w-full
                                max-w-2xl
                                transform
                                overflow-hidden
                                rounded-2xl
                                bg-white text-left align-middle shadow-xl transition-all"
                            >
                                <div class="
                                flex
                                justify-center
                                items-center
                                gap-4 max-h-[98vh] object-cover relative">
                                                <v-img
                                                    class="bg-grey-lighten-2 "
                                                    :src="attachment.url"
                                                    cover
                                                    height="100%"
                                                >
                                                </v-img>
                                    <span
                                        @click="closeModal"
                                        class="
                                        cursor-pointer
                                        px-3
                                        absolute
                                        top-3
                                        text-black
                                        right-1
                                        hover:opacity-80">
                                        <XmarkIcon :className="['w-5 ']"/>
                                    </span>
                                </div>

                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </teleport>

</template>

