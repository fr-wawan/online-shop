<template>
  <div
    class="shadow-md rounded-lg xl:w-[1000px] mx-auto w-full bg-white p-10 lg:w-10/12"
    v-motion-fade
  >
    <h1 class="text-xl border-b pb-3 font-semibold">Ordered Items</h1>

    <div v-for="product in order.product" class="border-b pb-5">
      <div class="flex flex-col md:flex-row justify-between items-center mt-5">
        <img
          :src="`https://source.unsplash.com/1200x1000?${product.title}`"
          class="rounded-lg w-20"
          alt=""
        />
        <h3 class="md:text-lg my-3 font-semibold">{{ product.title }}</h3>

        <p class="">Quantity : {{ product.pivot.quantity }}</p>
        <p class="flex gap-2 items-center">
          {{ formatPrice(product.price) }} <span>x</span>
          {{ product.pivot.quantity }}
        </p>

        <p class="text font-semibold text-gray-500 text-lg">
          {{ formatPrice(product.pivot.quantity * product.price) }}
        </p>
      </div>
    </div>

    <div class="mt-7 flex flex-col md:flex-row justify-between items-center">
      <p class="font-semibold mb-5">Order Notes : {{ order.user_notes }}</p>
      <h3 class="font-semibold text-xl">
        Total : {{ formatPrice(order.total) }}
      </h3>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";
import { useStore } from "vuex";

const store = useStore();

const order = computed(() => {
  return store.state.order.order;
});
</script>
