<template>
  <div>
    <Hero>
      <h1 class="text-5xl font-semibold">My Order</h1>
      <p class="text-gray-400 mt-5 flex items-center justify-center">
        Home
        <img src="../../assets/images/greater-than.png" alt="" width="30" />
        <span class="text-white">Details Order</span>
      </p>
    </Hero>

    <div class="xl:flex mt-20 xl:w-7/12 gap-5 mx-auto">
      <DashboardSidebar />

      <div>
        <UserDetails />
        <OrderedItems />
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRoute } from "vue-router";
import { ref, reactive, onMounted, computed } from "vue";
import { useStore } from "vuex";

import Hero from "../../components/Hero.vue";
import DashboardSidebar from "../../components/Dashboard/DashboardSidebar.vue";
import UserDetails from "../../components/order/UserDetails.vue";
import OrderedItems from "./OrderedItems.vue";

const store = useStore();
const route = useRoute();

onMounted(() => {
  store.dispatch("order/detailsProduct", route.params.invoice);
});

const order = computed(() => {
  return store.state.order.order;
});
</script>
