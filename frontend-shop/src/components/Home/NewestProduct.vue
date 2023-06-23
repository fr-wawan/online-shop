<template>
  <div class="container mx-auto mt-20">
    <div class="mb-5 md:mx-16 xl:mx-auto">
      <div class="">
        <h1 class="text-2xl mb-2 font-semibold">Newest Products</h1>
      </div>
      <p class="border border-b-gray-200"></p>
    </div>
    <div class="flex flex-wrap gap-5" v-if="products.length > 0">
      <Card :product="product" v-for="product in products" :key="product.id" />
    </div>
    <div v-else class="flex flex-wrap gap-5">
      <div
        v-for="index in 4"
        :key="index"
        class="flex flex-col mb-10 bg-white p-5 text-center rounded shadow-md flex-grow-0 shrink-0 h-80 basis-[23rem] mx-auto"
      >
        <ContentLoader />
      </div>
    </div>
    <div class="text-center mt-4 mb-4" v-show="nextExists">
      <a
        @click="loadMore"
        class="bg-blue-500 text-white text-lg p-4 px-10 rounded cursor-pointer"
        >Load More</a
      >
    </div>
  </div>
</template>

<script setup>
import { ContentLoader } from "vue-content-loader";
import Card from "../../components/Card.vue";

import { onMounted, ref, reactive, computed } from "vue";
import { useStore } from "vuex";

const store = useStore();

onMounted(() => {
  store.dispatch("category/getCategory", "fruits-vegetables");
});

const products = computed(() => {
  return store.state.product.products;
});

const nextExists = computed(() => {
  return store.state.product.nextExists;
});

const counter = computed(() => {
  let total = store.state.product.counter + 3;
  return total;
});

const nextPage = computed(() => {
  return store.state.product.nextPage;
});

function loadMore() {
  store.dispatch("product/getLoadMore", nextPage.value);
}
</script>
