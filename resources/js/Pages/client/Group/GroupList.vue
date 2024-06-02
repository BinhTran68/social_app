<script setup>
import TextInput from "@/Components/TextInput.vue";
import {ref} from "vue";
import GroupItem from "@/Pages/client/Group/GroupItem.vue";




const searchKeyword = ref('');

</script>

<template>
    <div class="col-span-3  ">
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
