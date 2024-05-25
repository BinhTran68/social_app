<script setup>
import { ref, computed } from 'vue';
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    isProcessing: {
        default: false,
        type: Boolean
    },
    modelValue: {
        default: '',
        type: String
    }
});

const emit = defineEmits(['update:modelValue', 'onSubmit']);

const comment = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
});

const handleOnSubmit = () => {
    emit("onSubmit", comment.value);
};
</script>

<template>
    <form @submit.prevent="handleOnSubmit" class="flex items-center justify-start">
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
               placeholder="Add a comment ..." type="text">
        <div>
            <button v-if="!isProcessing" type="submit"
                    :class="['text-blue font-weight-bold']">
                Post
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
