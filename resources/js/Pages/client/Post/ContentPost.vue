<script setup>

import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";
import CarouselComponent from "@/Components/CarouselComponent.vue";

const lenghtDisplay = 120;

defineProps({
    body: '',
    media: Object
})

</script>

<template>
    <div>
        <Disclosure v-slot="{open}">
            <div v-if="!open" v-html="body.length > lenghtDisplay ?  body.substring(0,100)+ '...' : body"/>

            <div v-if="body.length > lenghtDisplay">
                <DisclosurePanel class="flex justify-end" v-if="open" static>
                    <div v-html="body"></div>
                </DisclosurePanel>
                <DisclosureButton class="text-blue-600 text-xs hover:underline">
                    {{ open ? 'Read Less' : 'Read More' }}
                </DisclosureButton>
            </div>
        </Disclosure>
        <div v-if="media" >
            <v-carousel>
                <v-carousel-item
                    v-for="src in media"
                    :src="src.url"
                    cover
                ></v-carousel-item>
            </v-carousel>

        </div>
    </div>
</template>

<style scoped>

</style>
