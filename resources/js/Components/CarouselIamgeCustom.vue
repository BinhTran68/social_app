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
    <v-carousel :show-arrows="isSingleSlide && 'hover'"
                progress
                hide-delimiters
                progress-color="#F3382E"
    >
        <v-carousel-item
            v-for="(src) in media"
            :src="src.url"
            cover
        >
        </v-carousel-item>
    </v-carousel>
</template>

<style scoped>

</style>
