<script setup>

import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";
import AttachmentCrouselPost from "@/Pages/client/Post/AttachmentCrouselPost.vue";

const lenghtDisplay = 120;
defineProps({
    body: '',
    media: Object
})

</script>

<template>
    <div class="">
        <div class="">
            <div v-if="media.length > 0" class="max-w-[500px]  mt-3 mx-auto flex flex-col pb-3 gap-2">
                <AttachmentCrouselPost :media="media"/>
            </div>

            <div class="px-5">
                <Disclosure v-slot="{open}">
                    <div  v-if="!open" v-html="body && body.length > lenghtDisplay ?  body.substring(0,100)+ '...' : body"/>
                    <div v-if="body && body.length > lenghtDisplay">
                        <DisclosurePanel class="flex justify-end" v-if="open" static>
                            <div class="py-2" v-html="body"></div>
                        </DisclosurePanel>
                        <DisclosureButton class=" text-xs hover:underline ">
                        <span class="text-blue-600">
                            {{ open ? 'Read Less' : 'Read More' }}
                        </span>
                        </DisclosureButton>
                    </div>
                </Disclosure>
            </div>
        </div>

    </div>
</template>

<style scoped>
  a {
      color: #2563eb;
  }
</style>
