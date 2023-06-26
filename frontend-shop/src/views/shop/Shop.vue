<template>
  <Hero>
    <h1 class="text-5xl font-semibold">All Products</h1>
    <p class="text-gray-400 mt-5 flex items-center justify-center">
      Home
      <img src="../../assets/images/greater-than.png" alt="" width="30" />
      <span class="text-white"> Shop</span>
    </p>
  </Hero>

  <div class="flex flex-col-reverse md:flex-row container mx-auto gap-2">
    <div class="container mx-auto mt-20">
      <div class="mb-5 mx-auto w-10/12 md:w-[97%]">
        <div class="">
          <h1 class="text-2xl mb-2 font-semibold">All Products</h1>
        </div>
        <p class="border border-b-gray-200"></p>
      </div>
      <div class="flex flex-wrap gap-5" v-if="products.length > 0">
        <Card
          :product="product"
          v-for="product in products"
          :key="product.id"
          v-motion-slide-bottom
        />
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
      <Pagination
        :current-page="currentPage"
        :total-pages="totalPages"
        :go-to-page="goToPage"
      />
    </div>
    <ShopFilter />
  </div>
</template>

<script setup>
import { ContentLoader } from "vue-content-loader";
import Card from "../../components/Card.vue";
import Pagination from "../../components/Pagination.vue";
import ShopFilter from "../../components/Shop/ShopFilter.vue";
import Hero from "../../components/Hero.vue";

import { onMounted, ref, reactive, computed } from "vue";
import { useStore } from "vuex";

const store = useStore();

onMounted(() => {
  store.dispatch("category/getCategory");
  store.dispatch("paginationProduct/getProducts");
});

const products = computed(() => {
  return store.state.paginationProduct.products;
});

const currentPage = computed(() => store.state.paginationProduct.currentPage);
const totalPages = computed(() => store.state.paginationProduct.totalPages);

function goToPage(page) {
  store.dispatch("paginationProduct/getProducts", page);
}
</script>
