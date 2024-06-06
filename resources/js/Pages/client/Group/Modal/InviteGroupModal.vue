<script setup>
import {computed, ref} from 'vue'
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot,} from '@headlessui/vue'
import XmarkIcon from "@/Icon/XmarkIcon.vue";
import {useForm} from "@inertiajs/vue3";
import Button from "@/Components/Button.vue";
import Checkbox from "@/Components/Checkbox.vue";
import {toast} from "vue3-toastify";
import CircleImage from "@/Components/CircleImage.vue";
import InputFieldWithButton from "@/Components/InputFieldWithButton.vue";
import {id} from "vuetify/locale";


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


const searchValue = ref('');
const isProcessing = ref(false);
const usersRef = ref([])
const userInvitesRef = ref([]);

const emit = defineEmits(['update:modelValue', 'created'])
const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})


function closeModal() {
    show.value = false
}

const handleOnSubmit = ({ content }) => {
    isProcessing.value = true
    axios.get(route('user.find_keyword', [{keyword: content, page: null}]))
        .then(res => {
            const  data = res.data
            usersRef.value = data
        })
        .catch(e => {
            console.log(e)
        }).finally(() => {
        isProcessing.value = false
        })
}

const handleOnSendInvites = () => {
    // Call api send invites
}

const handleOnChecked = (user) => {
    const userPrev = userInvitesRef.value.find((u) => u.id === user.id);
    if (userPrev) {
        userInvitesRef.value = userInvitesRef.value.filter((u) => u.id !== user.id )
    }else {
        userInvitesRef.value.push(user);
    }
}

const handleOnRemoveInvite = (id) => {
    userInvitesRef.value = userInvitesRef.value.filter((u) => u.id !== id )
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
                                class="w-full max-w-4xl transform overflow-hidden rounded-2xl bg-white p-4 text-left align-middle shadow-xl transition-all"
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
                                        class="cursor-pointer  hover:opacity-50 p-2 bg-gray-300 rounded-full" >
                                        <XmarkIcon :className="['w-5 ']"/>
                                    </span>
                                </DialogTitle>
<!--                               CONTENT  -->
                                <div class="grid md:grid-cols-12 h-96 py-5">
                                    <div class="md:col-span-8 p-3">
                                        <div>
                                            <InputFieldWithButton
                                                :is-processing="isProcessing"
                                                @onSubmit="handleOnSubmit"
                                                v-model="searchValue"
                                                :placeholder="'Search person by name,user-name'" submit-text="Search" />
                                        </div>
                                        <h5 class="py-2 font-weight-bold">Suggested</h5>
                                        <span v-if="isProcessing">
                                            Pending ...
                                        </span>
                                        <span v-if="!isProcessing && usersRef.length <= 0">
                                            Can't find person for suggested
                                        </span>
                                        <div v-for="user in usersRef" class="flex py-2 items-center justify-between gap-2">
                                            <span class="flex items-center gap-3">
                                                 <CircleImage :src="user.avatar_url"/>
                                                <span>{{ user.name }}</span>
                                            </span>
                                            <span>
                                                 <Checkbox
                                                     @update:checked="handleOnChecked(user)"
                                                     :checked="userInvitesRef.includes(user)"
                                                 />
                                            </span>

                                        </div>
                                    </div>
                                    <div class="md:col-span-4 p-3 bg-gray-200 rounded-md" >
                                        <span>0 friends selected</span>
                                        <div v-for="user in userInvitesRef" class="flex py-2 items-center justify-between gap-2">
                                            <span class="flex items-center gap-3">
                                                 <CircleImage :src="user.avatar_url"/>
                                                <span>{{ user.name }}</span>
                                            </span>
                                            <span class="cursor-pointer" @click="handleOnRemoveInvite(user.id)" >
                                                   <XmarkIcon class-name="w-4"/>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-6">
                                    <Button
                                        @click="closeModal"
                                        :class="['bg-white text-gray-700 border px-6']">
                                        Cancel
                                    </Button>
                                    <Button
                                        @click="handleOnSendInvites"
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

