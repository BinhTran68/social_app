<script setup>
import TextInput from "@/Components/TextInput.vue";
import {ref} from "vue";
import FollowingItem from "@/Pages/client/Home/components/FollowingItem.vue";





const searchKeyword = ref('');

</script>

<template>
    <div class="col-span-3 bg-gray-50 rounded-md border h-[500px] overflow-hidden flex-col flex ">
        <div class="px-10">
            <h2 class="mb-2 text-2xl font-bold px-4">My follower</h2>
            <TextInput :model-value="searchKeyword" placeholder="Type to search"  />
        </div>
        <div class="py-8 flex-1 mt-2  overflow-auto">
            <div v-if="false">
                You are not joined to any groups
            </div>
            <div v-else>
                <FollowingItem image="https://picsum.photos/100"
                           title="Laravel develop"
                />
                <FollowingItem image="https://picsum.photos/100"
                           title="VuejS develop"
                /><FollowingItem image="https://picsum.photos/100"
                           title="Laravel develop"
                />
                <FollowingItem image="https://picsum.photos/100"
                           title="VuejS develop"
                /><FollowingItem image="https://picsum.photos/100"
                           title="Laravel develop"
                />
                <FollowingItem image="https://picsum.photos/100"
                           title="VuejS develop"
                /><FollowingItem image="https://picsum.photos/100"
                           title="Laravel develop"
                />
                <FollowingItem image="https://picsum.photos/100"
                           title="VuejS develop"
                /><FollowingItem image="https://picsum.photos/100"
                           title="Laravel develop"
                />
                <FollowingItem image="https://picsum.photos/100"
                           title="VuejS develop"
                /><FollowingItem image="https://picsum.photos/100"
                           title="Laravel develop"
                />
                <FollowingItem image="https://picsum.photos/100"
                           title="VuejS develop"
                />
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
