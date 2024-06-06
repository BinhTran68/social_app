import { defineAsyncComponent } from 'vue';

export const tabs = [
    {
        key: 'friend-requests',
        label: 'Friend Requests',
        url: '/fiends/friend-requests',
        icon: '' ,
        component: defineAsyncComponent(() => import('@/Pages/client/Friendship/Tabs/FriendRequest.vue'))
    },
    {
        key: 'suggestions',
        label: 'Suggestions',
        url: '/fiends/suggestions',
        component: defineAsyncComponent(() => import('@/Pages/client/Friendship/Tabs/Suggestions.vue'))
    },
    {
        key: 'all-friends',
        label: 'All Friends',
        url: '/fiends/all-friends',
        component: defineAsyncComponent(() => import('@/Pages/client/Friendship/Tabs/AllFriends.vue'))
    },
];
