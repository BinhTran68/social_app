<script setup>
import clsx from "clsx";
import {twMerge} from "tailwind-merge";

const  props = defineProps({
        type : "button",
        class : "",
        id : "",
        handleOnClick : () => {}

})

const  className =  clsx(twMerge('' +
    'rounded-md ' +
    'bg-indigo-600 px-3 py-2 text-sm ' +
    'font-semibold text-white shadow-sm ' +
    'hover:bg-indigo-500 focus-visible:outline ' +
    'focus-visible:outline-2 focus-visible:outline-offset-2 ' +
    'focus-visible:outline-indigo-600', props.class))

</script>

<template>
    <button
        :id="id"
        :on-click="handleOnClick"
        :type="type"
        :class="className">
        <slot />
    </button>
</template>

<style scoped>

</style>
