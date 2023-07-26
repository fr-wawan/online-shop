<template>
  <div class="w-10/12 mx-auto">
    <div class="border rounded p-5">
      <h1 class="text-xl font-semibold">Order Summary</h1>
      <div v-for="cart in carts" :key="cart.id">
        <div class="flex flex-col md:flex-row justify-between mt-5 items-center mb-5">
          <img :src="cart.product.image" class="rounded-lg w-20" alt="" />
          <div>
            <h3 class="text-lg font-semibold">{{ cart.product.title }}</h3>
            <p>Quantity : {{ cart.quantity }}</p>
          </div>
          <p class="text font-semibold text-gray-500">
            {{ formatPrice(cart.quantity * cart.product.price) }}
          </p>
        </div>
      </div>
    </div>
    <div class="border mt-10 flex justify-between p-7 text-lg font-semibold rounded">
      <h3>Total :</h3>
      <h3>{{ formatPrice(total) }}</h3>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from "vue";
import { useStore } from "vuex";
const store = useStore();

onMounted(() => {
  store.dispatch("cart/getCart");
});

const carts = computed(() => {
  return store.state.cart.carts;
});

const total = computed(() => {
  return store.getters["cart/cartTotal"];
});
</script>
