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

</script>

<template>
    <v-carousel :show-arrows="isSingleSlide"
                progress
                hide-delimiters
                progress-color="#F3382E"
    >
        <template v-slot:prev="{props}">
            <v-btn class="opacity-50" size="30px" v-bind="props">
                <v-icon>
                    mdi-chevron-left
                </v-icon>
            </v-btn>
        </template>
        <template v-slot:next="{props}">
            <v-btn class="opacity-50" size="30px" v-bind="props">
                <v-icon>
                    mdi-chevron-right
                </v-icon>
            </v-btn>
        </template>
        <v-carousel-item
            v-for="(src) in media"
            :src="src.url"
            cover
        >
        </v-carousel-item>
    </v-carousel>
</template>

<style scoped>
.v-btn--icon  .v-btn--density-default {
    opacity: 0.2 !important;
}
</style>
