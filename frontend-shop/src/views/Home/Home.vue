<template>
  <div class="">
    <div class="">
      <Hero />
    </div>
    <PopularProduct v-motion-slide-bottom />

    <NewestProduct v-motion-slide-bottom />
  </div>
</template>

<script setup>
import Hero from "../../components/Home/HeroIndex.vue";
import PopularProduct from "../../components/Home/PopularProduct.vue";
import NewestProduct from "../../components/Home/NewestProduct.vue";

import { onMounted, ref, reactive, computed } from "vue";
import { useStore } from "vuex";

const store = useStore();

onMounted(() => {
  store.dispatch("product/getProduct");
  store.dispatch("product/getPopularProduct");
});
</script>
