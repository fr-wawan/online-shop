<template>
  <Hero>
    <h1 class="text-5xl font-semibold">Cart</h1>
    <p class="text-gray-400 mt-5 flex items-center justify-center">
      Home
      <img src="../../assets/images/greater-than.png" alt="" width="30" />
      <span class="text-white">Cart</span>
    </p>
  </Hero>
  <div class="mt-5">
    {{ carts }}
    <div
      class="rounded-lg xl:w-[1000px] mx-auto w-full bg p-10 lg:w-10/12"
      v-motion-fade
    ></div>

    <div class="w-7/12 mx-auto">
      <Table
        :headers="[
          'Delete',
          'Image',
          'Products Name',
          'Price',
          'Quantity',
          'Sub Total',
        ]"
      >
        <tr class="text-gray-500" v-for="cart in carts">
          <td class="p-3">
            <div class="flex justify-center items-center">
              <a @click="deleteCart(cart)" class="cursor-pointer">
                <DeleteIcon />
              </a>
            </div>
          </td>
          <td class="p-3 text-center border">
            <img
              :src="`https://source.unsplash.com/1200x1000?${cart.product.title}`"
              class="mx-auto rounded-lg w-14"
              alt=""
            />
          </td>
          <td class="p-3 text-center border">
            {{ cart.product.title }}
          </td>
          <td class="p-3 text-center border">
            {{ formatPrice(cart.product.price) }}
          </td>
          <td class="p-3 border">
            <div class="flex justify-center">
              <Quantity :cart="cart" />
            </div>
          </td>
          <td class="p-3 border text-center">
            {{ formatPrice(cart.product.price * cart.quantity) }}
          </td>
        </tr>
      </Table>
      <div class="text-center p-5 border border-t-0 text-gray-500 text-xl">
        <h3>Cart Total : {{ formatPrice(total) }}</h3>
      </div>

      <div class="my-5 flex gap-5 justify-end">
        <router-link to="/" class="text-blue-500 rounded-md p-4 px-5">
          Continue Shopping
        </router-link>
        <router-link
          v-if="carts.length > 0"
          to="/checkout"
          class="bg-blue-500 hover:outline-1 outline hover: hover:outline-blue-500 hover:text-blue-500 hover:bg-white transition-all duration-300 ease-in-out rounded-md text-white p-4 px-5"
        >
          Proceed To Checkout
        </router-link>
      </div>

      <div>tes</div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useStore } from "vuex";
import { useToast } from "vue-toastification";

import Hero from "../../components/Hero.vue";
import Quantity from "../../components/cart/QuantityCart.vue";
import DeleteIcon from "../../components/Logo/DeleteIcon.vue";
import Table from "../../components/Table.vue";
import { ContentLoader } from "vue-content-loader";

const store = useStore();
const toast = useToast();

onMounted(() => {
  store.dispatch("cart/getCart");
});

const carts = computed(() => {
  return store.state.cart.carts;
});

const total = computed(() => {
  return store.getters["cart/cartTotal"];
});

const deleteCart = async (cart) => {
  try {
    await store.dispatch("cart/deleteCart", cart).then(() => {
      toast.success("Removed From Cart");
    });
  } catch (error) {
    console.log(error);
  }
};
</script>
