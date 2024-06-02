<script setup>
import { defineAsyncComponent, ref } from "vue";

const GroupList = defineAsyncComponent(() => import("@/Pages/client/Group/GroupList.vue"));
const TextInput = defineAsyncComponent(() => import("@/Components/TextInput.vue"));
const Button = defineAsyncComponent(() => import("@/Components/Button.vue"));
const SettingIcon = defineAsyncComponent(() => import("@/Icon/SettingIcon.vue"));
const PlusIcon = defineAsyncComponent(() => import("@/Icon/PlusIcon.vue"));
const GroupModal = defineAsyncComponent(() => import("@/Pages/client/Group/GroupModal.vue"));

const showCreateGroups = ref(false);
const searchGroups = ref('');
</script>

<template>
    <div class="py-3 px-3" >
        <div class="flex items-center justify-between">
            <h2 class="mb-2 text-2xl font-bold px-4">Groups</h2>
            <span class="">
                <SettingIcon class-name="w-8 h-8"/>
            </span>
        </div>
        <div class="py-3">
            <div class="py-1 px-1 hover:bg-gray-100 cursor-pointer">
                <h2 class="mb-2 text-xl font-bold px-4">Your Groups</h2>
            </div>
            <div class="py-1 px-1 hover:bg-gray-100 cursor-pointer">
                <h2 class="mb-2 text-xl font-bold px-4">Suggested for you</h2>
            </div>
            <div class="py-1 px-1 hover:bg-gray-100 cursor-pointer">
                <h2 class="mb-2 text-xl font-bold px-4">Your Groups</h2>
            </div>
            <div class="w-full py-2">

                <Button @click="showCreateGroups = true" :class="['w-full text-gray-50 bg-indigo-500 hover:bg-indigo-400']">
                    <span class="flex items-center  justify-center gap-1">
                         <PlusIcon class-name="w-5"/>
                         Create new group
                    </span>
                </Button>
            </div>
        </div>
        <div class="px-1 ">
            <TextInput class="bg-gray-50 w-full py-0" :model-value="searchGroups" placeholder="Type to search"/>
        </div>
        <GroupList/>
    </div>
    <GroupModal v-if="showCreateGroups" v-model="showCreateGroups" />
</template>

<style scoped>
</style>
