<template>
  <div class="">
    <div class="">
      <Hero />
    </div>
    <input
      name="search"
      placeholder="Search Product..."
      v-model="search"
      @keyup="searchQuery"
      class="block border border-gray-300 my-20 rounded md:w-full container mx-auto p-2.5 placeholder:text-sm placeholder:p-1 placeholder:text-gray-400"
    />

    <div v-if="!search">
      <ListProduct :products="popularProduct">Top Rated Products</ListProduct>

      <ListProduct :products="products">Newest Products</ListProduct>

      <div class="text-center mt-4 mb-4" v-show="nextExists">
        <a
          @click="loadMore"
          class="bg-blue-500 text-white text-lg p-4 px-10 rounded cursor-pointer"
          >Load More</a
        >
      </div>
    </div>
    <div v-else>
      <div v-if="products.length > 0">
        <ListProduct :products="products">Newest Products</ListProduct>
        <div class="text-center mt-4 mb-4" v-show="nextExists">
          <a
            @click="loadMore"
            class="bg-blue-500 text-white text-lg p-4 px-10 rounded cursor-pointer"
            >Load More</a
          >
        </div>
      </div>
      <div v-else class="text-center">
        <h1 class="font-semibold text-xl">Product Not Found</h1>
      </div>
    </div>
  </div>
</template>

<script setup>
import Hero from "../../components/Home/HeroIndex.vue";
import ListProduct from "../../components/Home/ListProduct.vue";

import Input from "../../components/Input.vue";

import { onMounted, ref, reactive, computed } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const store = useStore();
const router = useRouter();

onMounted(() => {
  store.dispatch("product/getProduct");
  store.dispatch("product/getPopularProduct");
});

const popularProduct = computed(() => {
  return store.state.product.popularProducts;
});
const products = computed(() => {
  return store.state.product.products;
});

const nextExists = computed(() => {
  return store.state.product.nextExists;
});

const nextPage = computed(() => {
  return store.state.product.nextPage;
});

function loadMore() {
  store.dispatch("product/getLoadMore", {
    nextPage: nextPage.value,
    searchQuery: search.value,
  });
}

const search = ref("");

const query = async (search) => {
  try {
    await new Promise((resolve) => setTimeout(resolve, 100));
    const response = await store.dispatch(
      "product/searchProduct",
      search.value
    );
  } catch (error) {
    console.error(error);
  }
};

let timeOutId;

async function searchQuery() {
  clearTimeout(timeOutId);

  await new Promise((resolve) => {
    timeOutId = setTimeout(resolve, 300);
  });

  await query(search);
}
</script>
