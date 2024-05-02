<script setup>

    import {ref} from "vue";
    const isSingleSlide = ref(true);
    const props =  defineProps({
        media : Array
    })
    isSingleSlide.value = props.media.length > 1


</script>

<template >
    <v-carousel :show-arrows="isSingleSlide"
                progress
                hide-delimiters
                progress-color="#F3382E"
    >
        <v-carousel-item
            v-for="src in media"
            :src="src.url"
            cover
        ></v-carousel-item>
    </v-carousel>
</template>

<style scoped>

</style>
