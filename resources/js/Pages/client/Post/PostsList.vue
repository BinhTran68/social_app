<script setup>
import PostItem from "@/Pages/client/Post/PostItem.vue";
import { onMounted, ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";

const  page = usePage();

const props = defineProps({
    posts: {
        type: Array
    }
});

const loadMoreIntersectRef = ref(null);
const currentPageRef = ref(2);

const  allPost = ref({
    data : page.props.posts.data,
    next : page.props.posts.links.next
})

const loadMore = () => {
    axios.get(allPost.value.next)
        .then(res => {
            allPost.value.data = [...allPost.value.data, ...res.data.data]
            allPost.value.next = res.data.links.next
        })
};
onMounted(() => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                loadMore();
            }
        });
    }, {
        rootMargin: '-250px 0px 0px 0px'
    });

    observer.observe(loadMoreIntersectRef.value);
});
</script>

<template>
    <div class="flex flex-col gap-3">
        <PostItem v-for="post in allPost.data" :key="post.id" :post="post" />
        <div ref="loadMoreIntersectRef"></div>
    </div>
</template>

<style scoped>
</style>
