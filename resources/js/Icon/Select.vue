<template>
    <div class="relative inline-block w-full">
        <select
            v-model="selected"
            @change="emitChange"
            class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
        >
            <option class="h-2" v-for="option in options" :key="option.value" :value="option.value">
                {{ option.label }}
            </option>
        </select>
    </div>
</template>

<script>
import { ref, watch, onMounted } from 'vue';

export default {
    name: 'Select',
    props: {
        options: {
            type: Array,
            required: true,
        },
        modelValue: {
            type: [String, Number],
            default: null,
        },
    },
    emits: ['update:modelValue'],
    setup(props, {emit}) {
        const selected = ref(props.modelValue);

        const emitChange = () => {
            emit('update:modelValue', selected.value);
        };

        watch(() => props.modelValue, (newValue) => {
            selected.value = newValue;
        });

        onMounted(() => {
            if (selected.value === null && props.options.length > 0) {
                selected.value = props.options[0].value;
                emitChange();
            }
        });

        return {
            selected,
            emitChange,
        };
    },
};
</script>

<style scoped>
/* Các CSS tùy chỉnh nếu cần */
</style>
