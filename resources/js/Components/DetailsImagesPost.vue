<script setup>


import {ref, watchEffect, defineProps, watch} from "vue";
import XmarkIcon from "@/Icon/XmarkIcon.vue";


const isSingleSlide = ref(true);
const props = defineProps({
    media: {
        type : Array
    },
    isEdit: {
        type: Boolean,
        default: false
    },
    isCreate:  {
        type: Boolean,
        default: true
    }
})


watchEffect(() => {
    isSingleSlide.value = props.media.length > 1;
});

watch(() => props.media, (newValue, oldValue) => {
    console.log('Media changed:', newValue);
});

const emit = defineEmits(["handle-delete-image"]);

const emitDeleteEvent = (index) => {
    emit("handle-delete-image", index);
};

</script>

<template>
    <v-row>
        <v-col
            v-for="(image, index) in media"
            :key="index"
            class="d-flex child-flex"
            cols="6"
        >
            <v-img
                :lazy-src="image.url"
                :src="image.url"
                aspect-ratio="1"
                class="bg-grey-lighten-2"
                cover
            >
                 <span @click="emitDeleteEvent(index)">
                    <XmarkIcon :className="['' +
                     'w-6 h-6 p-1 mt-2 float-end me-2 ' +
                     'bg-gray-50 rounded-full opacity-80 ' +
                     'hover:opacity-100 cursor-pointer' +
                     '']"/>
                </span>
            </v-img>
        </v-col>
    </v-row>

</template>

<style scoped>

</style>
