<script setup>

import {onMounted, ref} from "vue";
import Button from "@/Components/Button.vue";
import FriendGridList from "@/Pages/client/Friendship/FriendGridList.vue";
import {usePage} from "@inertiajs/vue3";

const authUser = usePage().props.auth.user;
const  userSuggestRef = ref([]);

onMounted(() => {
    axios.get(route('friend.suggest', authUser))
        .then((res) => {
            userSuggestRef.value = res.data
        }).catch((e) => {
        console.log(e)
        })
})
</script>

<template>
    <div class="px-5 py-6">
        <h1 class="font-weight-bold text-2xl py-3">
            Suggestions
        </h1>
        <div class="py-2">
            <FriendGridList :users="userSuggestRef" />
        </div>
    </div>

</template>

<style scoped>

</style>
