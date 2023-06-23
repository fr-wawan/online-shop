<template>
  <div class="text-center flex justify-center gap-5">
    <button v-if="currentPage > 1" @click="goToPage(currentPage - 1)">
      Previous
    </button>
    <button
      v-for="page in totalPages"
      :key="page"
      @click="goToPage(page)"
      :class="{
        'bg-blue-500 rounded text-white px-4 p-2': page === currentPage,
      }"
    >
      {{ page }}
    </button>
    <button v-if="currentPage < totalPages" @click="goToPage(currentPage + 1)">
      Next
    </button>
  </div>
</template>

<script setup>
const props = defineProps({
  currentPage: {
    type: Number,
    required: true,
  },
  totalPages: {
    type: Number,
    required: true,
  },
  goToPage: {
    type: Function,
    required: true,
  },
});
</script>
