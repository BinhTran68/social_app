<script setup>

import {ref} from "vue";

const comment = ref('');

const emit = defineEmits(['onSubmit', 'Event2'])
const handleOnSubmit = () => {
    emit("onSubmit", comment.value)
}


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
            <button type="submit"
                    :class="['text-blue font-weight-bold']">
                Post</button>
        </div>

    </form>
</template>

<style scoped>
</style>
