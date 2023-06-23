<template>
  <div class="container mx-auto mt-20">
    <div class="mb-5 md:mx-16 mx-auto xl:mx-auto">
      <div class="">
        <h1 class="text-2xl mb-2 font-semibold">Top Rated Products</h1>
      </div>
      <p class="border border-b-gray-200"></p>
    </div>
    <div class="flex flex-wrap gap-5" v-if="products.length > 0">
      <Card :product="product" v-for="product in products" :key="product.id" />
    </div>
    <div class="flex flex-wrap gap-5" v-else>
      <div
        v-for="index in 4"
        :key="index"
        class="flex flex-col mb-10 bg-white p-5 text-center rounded shadow-md flex-grow-0 shrink-0 h-80 basis-[23rem] mx-auto"
      >
        <ContentLoader />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ContentLoader } from "vue-content-loader";
import Card from "../../components/Card.vue";

import { onMounted, ref, reactive, computed } from "vue";
import { useStore } from "vuex";

const store = useStore();

const products = computed(() => {
  return store.state.product.popularProducts;
});
</script>
