<template>
  <div>
    <div class="border p-5">
      <h1 class="text-xl font-semibold">Order Summary</h1>
      <div v-for="cart in carts">
        <div class="flex justify-between mt-5 items-center mb-5">
          <img
            :src="`https://source.unsplash.com/1200x1000?${cart.product.title}`"
            class="rounded-lg w-20"
            alt=""
          />
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
  </div>
  <div class="border mt-10 flex justify-between p-7 text-lg font-semibold">
    <h3>Total :</h3>
    <h3>{{ formatPrice(total) }}</h3>
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
