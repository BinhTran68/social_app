<script setup>
import {Head, Link} from '@inertiajs/vue3';
import GroupList from "@/Pages/client/Home/components/GroupList.vue";
import FollowingList from "@/Pages/client/Home/components/FollowingList.vue";
import CreatePost from "@/Pages/client/Post/CreatePost.vue";
import PostsList from "@/Pages/client/Post/PostsList.vue";
import {ref} from "vue";

const drawer = ref(true)
const rail = ref(true)

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
    <div class="grid md:grid-cols-12 gap-3">
        <div class="md:col-span-3 ">
            <div class="hidden md:block">
                <v-card>
                    <v-layout>
                        <v-navigation-drawer

                            v-model="drawer"
                            :rail="rail"
                            permanent
                            @click="rail = false"
                        >
                            <v-list-item
                                prepend-avatar="https://randomuser.me/api/portraits/men/85.jpg"
                                title="John Leider"
                                nav
                            >
                                <template v-slot:append>
                                    <v-btn
                                        icon="mdi-chevron-left"
                                        variant="text"
                                        @click.stop="rail = !rail"
                                    ></v-btn>
                                </template>
                            </v-list-item>

                            <v-divider></v-divider>

                            <v-list density="compact" class="" nav>
                                <v-list-item prepend-icon="mdi-home-city" title="Home" value="home"></v-list-item>
                                <v-list-item prepend-icon="mdi-account" title="My Account"
                                             value="account"></v-list-item>
                                <v-list-item prepend-icon="mdi-account-group-outline" title="Users"
                                             value="users"></v-list-item>
                                <v-list-item prepend-icon="mdi-email" title="Message" value="message"></v-list-item>
                            </v-list>
                        </v-navigation-drawer>
                    </v-layout>
                </v-card>
            </div>
        </div>
        <div class="md:col-span-3 md:order-3 py-6 flex overflow-hidden lg:fixed right-10 top-0">
            <FollowingList/>
        </div>
        <div class="md:col-span-6 md:order-2 flex flex-col gap-3 overflow-hidden ">
            <CreatePost/>
            <PostsList/>
        </div>
    </div>
</template>
