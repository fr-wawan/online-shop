<template>
  <Hero>
    <h1 class="text-5xl font-semibold">Product Details</h1>
    <p class="text-gray-400 mt-5 flex items-center justify-center">
      Home
      <img src="../../assets/images/greater-than.png" alt="" width="30" />
      <span class="text-white"> Product Details</span>
    </p>
  </Hero>

  <div
    class="text-center container mx-auto mt-20"
    v-if="Object.keys(product).length > 0"
  >
    <div class="md:flex justify-center gap-10">
      <div>
        <img width="500" class="border p-3" alt="" :src="product.image" />
      </div>
      <div class="md:w-5/12 mx-5 text-left">
        <h2 class="font-semibold text-2xl mb-5">{{ product.title }}</h2>
        <p
          class="font-bold text-xl mb-3 text-gray-500 border-b pb-3 border-b-gray-200"
        >
          ${{ product.price }}/KG
        </p>
        <p
          class="border-b pb-3 border-b-gray-200"
          v-html="product.description"
        ></p>
        <div class="flex items-center md:gap-5 mt-5">
          <Quantity
            v-model="quantity"
            @incrementQuantity="quantity++"
            @decrementQuantity="quantity--"
            :quantity="quantity"
          />

          <AddToCart :product="product" :quantity="quantity" />
        </div>
      </div>
    </div>
  </div>
  <div class="text-center container mx-auto mt-20" v-else>
    <ContentLoader />
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from "vue";
import { useStore } from "vuex";
import { useRoute } from "vue-router";
import { ContentLoader } from "vue-content-loader";

import Hero from "../../components/Hero.vue";
import Quantity from "../../components/Quantity.vue";
import AddToCart from "../../components/AddToCart.vue";

const store = useStore();
const route = useRoute();

onMounted(() => {
  store.dispatch("product/getDetailsProduct", route.params.slug);
});

const quantity = ref(1);

const product = computed(() => {
  return store.state.product.product;
});
</script>
