<script setup>
import CircleImage from "@/Components/CircleImage.vue";
import ContentPost from "@/Pages/client/Post/ContentPost.vue";
import ActionPost from "@/Pages/client/Post/ActionPost.vue";
const heatIcon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}\n' +
    '                      stroke="currentColor" className="w-6 h-6">\n' +
    '    <path strokeLinecap="round" strokeLinejoin="round"\n' +
    '          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>\n' +
    '</svg>'

const comemntIcon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"\n' +
    '                     stroke="currentColor" class="w-6 h-6">\n' +
    '                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/>\n' +
    '                </svg>'

const  shareIcon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">\n' +
    '  <path strokeLinecap="round" strokeLinejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />\n' +
    '</svg>\n'

defineProps({
    post: Object
})
</script>

<template>
    <div class="bg-white flex flex-col gap-4 py-3 rounded-md">
        <div class="flex items-center px-5 gap-3">
            <CircleImage :src="post.user.avatar" alt=""/>
            <div class="flex flex-col  ">
                <h4 class="font-bold">
                    <span class="hover:underline cursor-pointer">
                          {{ post.user.name }}
                    </span>
                    <template v-if="post.group">
                        >
                        <span>
                          {{ post.group.name }}
                    </span>
                    </template>
                </h4>
                <small class="text-gray-500">{{ post.created_at }}</small>
            </div>
        </div>
        <div class="flex flex-col gap-3">
            <ContentPost :body="post.body" :media="post.media"/>
            <div class="flex items-center mx-5 justify-start gap-2 ">
                <ActionPost :icon="heatIcon"/>
                <ActionPost :icon="comemntIcon"/>
                <ActionPost :icon="shareIcon"/>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
