<script setup>
import {computed, ref} from 'vue'
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot,} from '@headlessui/vue'
import XmarkIcon from "@/Icon/XmarkIcon.vue";
import {router, useForm, usePage} from "@inertiajs/vue3";
import Button from "@/Components/Button.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputTextarea from "@/Components/InputTextarea.vue";
import Select from "@/Icon/Select.vue";
import Checkbox from "@/Components/Checkbox.vue";
import {toast} from "vue3-toastify";


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

const emit = defineEmits(['update:modelValue'])
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
        })
        .catch()
}


const options = ref([
    { value: 'private', label: 'Private' },
    { value: 'public', label: 'Public' },
]);
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
                                <pre>
                                    {{ form }}
                                </pre>
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
                                        New Group
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
<!--                               CONTENT  -->
                                <div class="py-5">
                                    <InputLabel>
                                       <span class="text-md-body-1 py-2">
                                            Group name
                                       </span>
                                        <InputTextarea  v-model="form.name"/>
                                    </InputLabel>
                                    <div class="flex items-center gap-2">
                                        <Checkbox name="remeber" v-model:checked="form.auto_approval"/>
                                        Enable auto approval
                                    </div>
                                    <div class="py-2">
                                        <Select v-model="form.privacy" :options="options"/>
                                    </div>
                                    <InputLabel>
                                       <span>
                                            About for group
                                       </span>
                                        <InputTextarea  v-model="form.about"/>
                                    </InputLabel>
                                </div>
                                <Button
                                    @click="handleOnSubmit"
                                    :class="['w-full']">
                                    Create Group
                                </Button>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </teleport>

</template>

