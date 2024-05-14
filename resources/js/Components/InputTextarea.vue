<script setup>
import { ref, watch, onMounted } from "vue";

const props = defineProps({
    modelValue: String
});

const emit = defineEmits(['update:modelValue']);
const input = ref(props.modelValue);
const textareaRef = ref(null);

watch(() => props.modelValue, (newVal) => {
    input.value = newVal;
});

const adjustHeight = () => {
    if (textareaRef.value) {
        textareaRef.value.style.height = "auto";
        textareaRef.value.style.height = textareaRef.value.scrollHeight + 'px';
    }
};

const onInputChange = (e) => {
    input.value = e.target.value;
    emit('update:modelValue', input.value);
    adjustHeight();
};

// Adjust height when the component is mounted
onMounted(() => {
    adjustHeight();
});

</script>

<template>
  <textarea
      class="
      border
      py-2
      border-gray-300
      dark:border-gray-700
      dark:bg-gray-900
      dark:text-gray-300
      focus:border-indigo-500
      dark:focus:border-indigo-600
      focus:ring-indigo-500
      dark:focus:ring-indigo-600
      rounded-md
      w-full
      shadow-sm
      overflow-y-hidden
    "
      v-model="input"
      ref="textareaRef"
      @input="onInputChange"
      placeholder="What's on your mind ?"
  ></textarea>
</template>

<style scoped>
</style>
