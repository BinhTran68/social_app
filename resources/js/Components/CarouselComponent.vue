<script setup>
import { ref } from 'vue';


const props = defineProps({
    media: Array
});
const currentImage = ref(0);
const isSingleSlide = ref(false);
props.media.length > 1 ? isSingleSlide.value = true : isSingleSlide.value = false

const nextSlide = () => {
    currentImage.value = (currentImage.value + 1) % props.media.length;
};

const prevSlide = () => {
    currentImage.value = (currentImage.value - 1 + props.media.length) % props.media.length;
};
</script>

<template>

    <div class="relative max-w-[650px] h-auto select-none ">
        <div class="flex overflow-hidden h-auto  rounded-md">
            <div v-for="(image, index) in media" :key="index" :class="`slide ${index === currentImage ? 'active' : ''} ` ">
                <img :src="image.url" alt="Image" class="w-full" />
            </div>
        </div>
        <span v-if="isSingleSlide" v-for="(image, index) in media" >
               <v-btn append-icon="$vuetify">
                    Button
            </v-btn>
        </span>
        <button v-if="isSingleSlide" @click="prevSlide" class="prev rounded-full w-10">❮</button>
        <button v-if="isSingleSlide" @click="nextSlide" class="next rounded-full w-10">❯</button>
    </div>
</template>


<style scoped>
.slide {
    display: none;
}

.slide.active {
    display: block;
}



.prev,
.next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    cursor: pointer;
    padding: 10px;
    font-size: 16px;
    z-index: 1;
}

.prev {
    left: 0;
}

.next {
    right: 0;
}
</style>
