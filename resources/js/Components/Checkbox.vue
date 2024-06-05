<script setup>
import { computed } from 'vue';
import {useForm} from "@inertiajs/vue3";



const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: Boolean,
        default: false
    },
    value: {
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>

<template>
    <input
        type="checkbox"
        :value="value"
        v-model="proxyChecked"
        class="
        rounded
        border
        cursor-pointer
        border-gray-800
        p-2
        dark:bg-gray-900
        dark:border-gray-700
        text-indigo-600
        shadow-sm"
    />
</template>
