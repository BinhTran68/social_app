<script setup>

    import {usePage} from "@inertiajs/vue3";

    defineProps({
        mustVerifyEmail : {
          type: Boolean
        },


    })

    const user = usePage().props.auth.user

</script>

<template>
    <div>
        {{user}}
    </div>

</template>

<style scoped>

</style>
