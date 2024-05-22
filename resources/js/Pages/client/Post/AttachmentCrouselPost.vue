<script setup>


import {ref, watchEffect, defineProps, watch} from "vue";
import AttachmentPreviewModal from "@/Pages/client/Post/AttachmentPreviewModal.vue";
import PostModal from "@/Pages/client/Post/PostModal.vue";

const showPreviewModal =  ref(false)
const attachmentPreview = ref(null)
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

const openDetailAttachments = (file) => {
    attachmentPreview.value = file
    showPreviewModal.value = true

}

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
            class="cursor-pointer"
            v-for="(file) in media"
            :src="file.url"
            cover
            @click="openDetailAttachments(file)"
        >
        </v-carousel-item>
    </v-carousel>

    <AttachmentPreviewModal
        v-if="attachmentPreview"
        :attachment="attachmentPreview"
        v-model="showPreviewModal" />
</template>



<style scoped>
.v-btn--icon  .v-btn--density-default {
    opacity: 0.2 !important;
}
</style>
