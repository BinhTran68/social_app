<script setup>
import TextInput from "@/Components/TextInput.vue";
import {ref} from "vue";
import GroupItem from "@/Pages/client/Group/GroupItem.vue";


defineProps({
    groups: Array
})

</script>
<template>
    <div class="col-span-3  ">
        <div class="py-8">
            <div v-if="false">
                You are not joined to any groups
            </div>
            <div v-else>
                <GroupItem v-for="group in groups"
                           :image="group.thumbnail_path"
                           :title="group.name"
                           :description="group.about"
                />
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
