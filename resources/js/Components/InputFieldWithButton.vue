<script setup>
import { ref, computed } from 'vue';
import { defineProps, defineEmits } from 'vue';
import {usePage} from "@inertiajs/vue3";

const authUser = usePage().props.auth.user

const props = defineProps({
    isProcessing: {
        default: false,
        type: Boolean
    },
    modelValue: {
        default: '',
        type: String
    },
    placeholder : {
        default: null,
        type: String
    },
    submitText : {
        default: 'Post',
        type: String
    },
    required : {
        default: true,
        type: Boolean
    },
    tagToUser : {
        default : null
    },
    parentCmtId: {
        default: null,
    }
});

const computedPlaceholder = computed(() => {
    if (props.placeholder) {
        return props.placeholder
    } else {
        return `Comment as ${authUser.name}`
    }
})


const emit = defineEmits(['update:modelValue', 'onSubmit']);

const comment = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
});

const handleOnSubmit = () => {
    emit("onSubmit", { content: comment.value, parentCmtId: props.parentCmtId});
};
</script>

<template>
    <form @submit.prevent="handleOnSubmit" class="flex items-center gap-2 w-100 justify-start">
        <button v-if="tagToUser" type="submit"
                :class="['text-indigo font-weight-bold text-no-wrap']">
            {{ tagToUser.name }}
        </button>
        <input class="border-b border-r
        focus:outline-none
        focus:border-b-2
        px-2
        focus:border-r-2
        focus:border-indigo-500
        focus:shadow-none
        focus:ring-0
        w-full"
               v-model="comment"
               :placeholder="computedPlaceholder"
               type="text"
                :required="required"
        >
        <div>
            <button v-if="!isProcessing" type="submit"
                    :class="['text-blue font-weight-bold']">
                {{ submitText }}
            </button>
            <span v-if="isProcessing">
               <v-progress-circular
                   color="blue"
                   indeterminate
                   size="25"
               ></v-progress-circular>
            </span>
        </div>
    </form>
</template>

<style scoped>
</style>
