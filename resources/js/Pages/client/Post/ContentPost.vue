<script setup>

import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";
import CarouselIamgeCustom from "@/Components/CarouselIamgeCustom.vue";

const lenghtDisplay = 120;


defineProps({
    body: '',
    media: Object
})

</script>

<template>
    <div class="">
        <div class="px-8 ">
            <Disclosure  v-slot="{open}">
                <div v-if="!open" v-html="body && body.length > lenghtDisplay ?  body.substring(0,100)+ '...' : body"/>
                <div v-if="body && body.length > lenghtDisplay">
                    <DisclosurePanel class="flex justify-end" v-if="open" static>
                        <div v-html="body"></div>
                    </DisclosurePanel>
                    <DisclosureButton class=" text-xs hover:underline ">
                        <span class="text-blue-600">
                            {{ open ? 'Read Less' : 'Read More' }}
                        </span>
                    </DisclosureButton>
                </div>
            </Disclosure>
        </div>
        <div v-if="media" class="max-w-[500px] mt-3 mx-auto flex flex-col gap-2">
            <CarouselIamgeCustom :media="media"/>
        </div>
    </div>
</template>

<style scoped>
  a {
      color: #2563eb;
  }
</style>
