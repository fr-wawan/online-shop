<template>
  <div>
    <div class="border">
      <h1 class="text-xl font-semibold">Order Summary</h1>
      <div v-for="cart in carts">
        <img
          :src="`https://source.unsplash.com/1200x1000?${cart.product.title}`"
          class="mx-auto rounded-lg w-14"
          alt=""
        />
      </div>
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
</script>
