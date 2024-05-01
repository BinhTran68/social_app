<script setup>
import TextInput from "@/Components/TextInput.vue";
import {ref} from "vue";
import GroupItem from "@/Pages/client/Home/components/GroupItem.vue";



const searchKeyword = ref('');

</script>

<template>
    <div class="col-span-3 bg-gray-50 py-6 ">
        <div class="px-5">
            <h2 class="mb-2 text-2xl font-bold px-4">My group</h2>
            <TextInput :model-value="searchKeyword" placeholder="Type to search"  />
        </div>
        <div class="py-8">
            <div v-if="false">
                You are not joined to any groups
            </div>
            <div v-else>
                <GroupItem image="https://picsum.photos/100"
                           title="Laravel develop"
                           description="@123 Tôi là trần bninhf kfkfkfkkfkfkffffffffffffffffffffff"
                />
                <GroupItem image="https://picsum.photos/100"
                           title="VuejS develop"
                           description="@123"
                />
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
