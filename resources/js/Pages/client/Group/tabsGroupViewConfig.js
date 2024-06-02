import { defineAsyncComponent } from 'vue';

export const tabs = [
    {
        key: 'about',
        label: 'About',
        url: '@/Pages/Profile/Tabs/AboutTab.vue',
        component: defineAsyncComponent(() => import('@/Pages/client/Group/Tabs/AboutTab.vue'))
    },
    {
        key: 'posts',
        label: 'Posts',
        url: '@/Pages/Profile/Tabs/PostsTab.vue',
        component: defineAsyncComponent(() => import('@/Pages/client/Group/Tabs/PostsTab.vue'))
    },
    {
        key: 'followers',
        label: 'Followers',
        url: '@/Pages/Profile/Tabs/FollowersTab.vue',
        component: defineAsyncComponent(() =>  import('@/Pages/client/Group/Tabs/FollowersTab.vue'))
    },
    {
        key: 'photos',
        label: 'Photos',
        url: '@/Pages/Profile/Tabs/PhotosTab.vue',
        component: defineAsyncComponent(() =>  import('@/Pages/client/Group/Tabs/PhotosTab.vue'))
    },
];
