<script setup>
import {Head, Link} from '@inertiajs/vue3';
import GroupList from "@/Pages/client/Home/components/GroupList.vue";
import FollowingList from "@/Pages/client/Home/components/FollowingList.vue";
import CreatePost from "@/Pages/client/Post/CreatePost.vue";
import PostsList from "@/Pages/client/Post/PostsList.vue";





defineProps({});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Socical Media Website"/>
    <div class="grid grid-cols-12 gap-3">
        <GroupList/>
        <div class="col-span-6 flex flex-col gap-3">
            <CreatePost/>
            <PostsList/>
        </div>
        <div class="col-span-3 py-6 px-3">
            <FollowingList/>
        </div>
    </div>
</template>
