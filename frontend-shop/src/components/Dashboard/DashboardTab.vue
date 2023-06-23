<template>
  <div class="bg-white shadow-md rounded-md">
    <router-link
      :to="{ name: props.link }"
      active-class="bg-blue-500 font-semibold text-white shadow-md rounded"
      class="p-4 px-12 hover:bg-blue-500 hover:text-white hover:shadow-md hover:rounded transition-all duration-300 ease-in-out flex text-gray-500 text-lg gap-2 mb-5 items-center justify-center"
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
