<script setup>
defineProps({
    selected: Boolean,
    text: String
})
</script>
<template>
      <span
          :class="[
              'px-3  text-center cursor-pointer py-3 min-w-20 bg-white',
              selected && 'border-b-2 text-blue focus:outline-none border-blue-500 '
            ]"
      >{{text}}
      </span>
</template>

<style scoped>
    .text-blue {
          color: rgb(59 130 246 / var(--tw-text-opacity));
     }
</style>
