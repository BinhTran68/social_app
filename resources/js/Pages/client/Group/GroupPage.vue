<script setup>
import {Head, Link} from '@inertiajs/vue3';
import CreatePost from "@/Pages/client/Post/CreatePost.vue";
import PostsList from "@/Pages/client/Post/PostsList.vue";
import {ref} from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import GroupMain from "@/Pages/client/Group/GroupMain.vue";

const drawer = ref(true)
const rail = ref(true)

defineProps({
    posts :  Object,
    groups : Array
});


function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Zalo Groups"/>
    <AuthenticatedLayout>
        <div class="grid lg:grid-cols-12  gap-3 relative py-5  ">
            <div class="lg:col-span-4 md:order-1">
                <div class="fixed hidden lg:block min-w-96  bg-white rounded-lg flex-1">
                    <GroupMain :groups="groups" />
                </div>
            </div>
            <div class="lg:col-span-8 px-15 md:order-2 flex flex-col w-full gap-3 overflow-hidden ">
                <CreatePost/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
