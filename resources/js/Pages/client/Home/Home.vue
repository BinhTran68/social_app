<script setup>
import {Head, Link} from '@inertiajs/vue3';
import CreatePost from "@/Pages/client/Post/CreatePost.vue";
import PostsList from "@/Pages/client/Post/PostsList.vue";
import {ref} from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const drawer = ref(true)
const rail = ref(true)

defineProps({
    posts :  Object
});


function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Socical Media Website"/>
    <AuthenticatedLayout>
                <CreatePost/>
                <PostsList :posts="posts.data"/>
    </AuthenticatedLayout>
</template>
