import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/friend-requests',
        name: 'FriendRequests',
        component: () => import('@/Pages/client/Friendship/Tabs/FriendRequest.vue'),
    },
    {
        path: '/suggestions',
        name: 'Suggestions',
        component: () => import('@/Pages/client/Friendship/Tabs/Suggestions.vue'),
    },
    {
        path: '/all-friends',
        name: 'AllFriends',
        component: () => import('@/Pages/client/Friendship/Tabs/AllFriends.vue'),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
