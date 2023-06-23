<template>
  <div class="">
    <router-link
      :to="{ name: link }"
      class="text-gray-500 rounded shadow transition-all duration-300 ease-in-out hover:bg-blue-500 p-5 hover:text-white font-medium hover:rounded text-xl px-16"
      active-class="bg-blue-500 text-white shadow-md rounded"
    >
      <slot />
    </router-link>
  </div>
</template>

<script setup>
const props = defineProps({
  link: String,
});
</script>
