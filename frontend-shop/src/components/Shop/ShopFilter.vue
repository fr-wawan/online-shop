<template>
  <div class="mt-20 w-3/12 mx-5">
    <h2 class="text-xl uppercase font-semibold">Explore</h2>
    <div class="border border-b"></div>
    <div class="mt-5">
      <div
        class="flex items-center mb-5 gap-5 pb-2 border-b border-b-gray-200"
        v-for="category in categories"
      >
        <label for="">{{ category.name }}</label>
        <input
          type="checkbox"
          :name="category.id"
          :id="category.id"
          class="border-gray-300 rounded h-5 w-5"
          v-model="selectedCategories"
          :value="category.id"
          @change="fetchCategory"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useStore } from "vuex";

const store = useStore();

onMounted(() => {
  fetchCategory();
});

const selectedCategories = ref([]);
function fetchCategory() {
  if (selectedCategories.value.length > 0) {
    store.dispatch(
      "paginationProduct/getProductsByFilter",
      selectedCategories.value
    );
  } else {
    store.dispatch("paginationProduct/getProducts");
  }
}

const categories = computed(() => {
  return store.state.category.categories;
});
</script>
