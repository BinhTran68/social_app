import { defineAsyncComponent } from 'vue';

export const tabs = [
    {
        key: 'discussion',
        label: 'Discussion',
        url: '/discussion',
        component: defineAsyncComponent(() => import('@/Pages/client/Group/Tabs/DiscussionGroup.vue'))
    },
    {
        key: 'members',
        label: 'Members',
        url: '@/Pages/Profile/Tabs/PostsTab.vue',
        component: defineAsyncComponent(() => import('@/Pages/client/Group/Tabs/Members.vue'))
    },
    {
        key: 'media',
        label: 'Media',
        url: '@/Pages/Profile/Tabs/FollowersTab.vue',
        component: defineAsyncComponent(() =>  import('@/Pages/client/Group/Tabs/Media.vue'))
    },
    {
        key: 'photos',
        label: 'Photos',
        url: '@/Pages/Profile/Tabs/PhotosTab.vue',
        component: defineAsyncComponent(() =>  import('@/Pages/client/Group/Tabs/PhotosTab.vue'))
    },
];
