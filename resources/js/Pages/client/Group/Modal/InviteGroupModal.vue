<script setup>
import {computed, ref} from 'vue'
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot,} from '@headlessui/vue'
import XmarkIcon from "@/Icon/XmarkIcon.vue";
import {useForm} from "@inertiajs/vue3";
import Button from "@/Components/Button.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputTextarea from "@/Components/InputTextarea.vue";
import Select from "@/Icon/Select.vue";
import Checkbox from "@/Components/Checkbox.vue";
import {toast} from "vue3-toastify";
import TextInput from "@/Components/TextInput.vue";
import CircleImage from "@/Components/CircleImage.vue";
import InputFieldWithButton from "@/Components/InputFieldWithButton.vue";


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
const form = useForm({
    name: '',
    about : '',
    auto_approval : true,
    privacy : 'public'

})

const emit = defineEmits(['update:modelValue', 'created'])

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})


function closeModal() {
    show.value = false
}

const handleOnSubmit =  () => {
    axios.post(route('group.create'), form)
        .then(res => {
            toast.success('Create Group successfully')
            closeModal()
            emit('created', res.data)
        })
        .catch(e => {
            console.log(e)
        })
}


const options = ref([
    { value: 'private', label: 'Private' },
    { value: 'public', label: 'Public' },
]);
</script>

<!-- When open modal call api lấy ra danh sách flowed -->
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
                                class="w-full max-w-3xl transform overflow-hidden rounded-2xl bg-white p-4 text-left align-middle shadow-xl transition-all"
                            >
                                <DialogTitle
                                    as="h3"
                                    class="
                                    text-xl
                                    font-medium
                                    leading-6
                                    text-gray-900
                                    flex items-center
                                    justify-between"
                                >
                                    <span>
                                        Invite friends to this group
                                    </span>
                                    <span
                                        @click="closeModal"
                                        class="cursor-pointer hover:opacity-50 p-2 bg-gray-300 rounded-full" >
                                        <XmarkIcon :className="['w-5 ']"/>
                                    </span>
                                </DialogTitle>
<!--                               CONTENT  -->
                                <div class="grid md:grid-cols-12 py-5">
                                    <div class="md:col-span-8 p-3">
                                        <div>
                                            <InputFieldWithButton submit-text="Search" />
                                        </div>
                                        <h5 class="py-2">Suggested</h5>
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="flex items-center gap-3">
                                                 <CircleImage/>
                                                An Trâần
                                            </span>
                                            <Checkbox checked=""/>
                                        </div>
                                    </div>
                                    <div class="md:col-span-4 p-3 bg-gray-200 rounded-md" >
                                        <span>0 friends selected</span>
                                    </div>

                                </div>


                                <div class="flex justify-end gap-6">
                                    <Button
                                        @click="closeModal"
                                        :class="['bg-white text-gray-700 border px-6']">
                                        Cancel
                                    </Button>
                                    <Button
                                        @click="handleOnSubmit"
                                        :class="['']">
                                        Send invites
                                    </Button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </teleport>

</template>

