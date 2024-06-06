<script setup>

import Button from "@/Components/Button.vue";

const props = defineProps({
    users : {
        type: Array,
        default: []
    }
})


</script>

<template>
    <span v-if="users.length <= 0">
                Can't find person Suggestion for you
            </span>
    <div class="grid grid-cols-12 gap-4">
        <div v-for="user in props.users" class="md:col-span-4 col-span-6  lg:col-span-2 flex flex-column gap-2 pb-3 bg-white rounded-md  ">
            <img class="w-30 h-60 rounded-md object-cover" :src="user.avatar_url" :alt="user.name"/>
            <span class="font-weight-bold text-xl px-3">
                        {{ user.name }}
                    </span>
            <div class="flex flex-column gap-3 px-3">
                <Button>Confirm</Button>
                <Button class="bg-white text-gray-700 border">Delete</Button>
            </div>
        </div>
</div>
</template>

<style scoped>

</style>
