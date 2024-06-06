<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SettingIcon from "@/Icon/SettingIcon.vue";
import {tabs} from "@/Pages/client/Friendship/Tabs/friendMenuTabs.js";
import {computed, onMounted, ref} from "vue";

const activeTab = ref('');
const activeComponent = computed(() => {
    const activeTabData = tabs.find(tab => tab.key === activeTab.value);
    return activeTabData ? activeTabData.component : null;
});

onMounted(() => {
    const currentUrl = window.location.href;
    const parts = currentUrl.split('/');
    const tab = parts[parts.length - 1];
    const checkTab = tabs.find((t) => t.key === tab)
    if (checkTab) {
        activeTab.value = tab
    }else {
        activeTab.value = 'friend-requests'
    }

})
const setActiveTab = (tabKey) => {
    activeTab.value = tabKey;
};
</script>

<template>
<AuthenticatedLayout>
    <div class="grid md:grid-cols-12 w-full" >
        <div class="md:col-span-3 bg-white h-screen relative ">
            <div class="sticky w-full px-2 py-2">
                <div class="flex items-center justify-between py-4">
                    <span class="font-semibold text-3xl">Friends</span>
                    <span>
                             <SettingIcon class-name="w-10"/>
                    </span>
                </div>
                <div>
                    <div class="py-3 px-5 cursor-pointer rounded-md "
                         v-for="tab in tabs"
                         @click="setActiveTab(tab.key)"
                         :key="tab.key"
                         :class="{'bg-gray-200 text-indigo': activeTab === tab.key}">
                        <div class="flex items-center gap-4">
                               <span>
                            icon
                        </span>
                            <span class="font-weight-bold text-2xl">
                            {{ tab.label }}
                        </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="md:col-span-9">
            <component :is="activeComponent"></component>
        </div>
    </div>
</AuthenticatedLayout>
</template>

<style scoped>

</style>
