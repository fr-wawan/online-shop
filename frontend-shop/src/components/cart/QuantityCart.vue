<template>
  <div class="flex items-center border border-gray-200 rounded h-10">
    <button
      type="button"
      class="w-10 h-10 leading-10 text-gray-600 transition hover:opacity-75"
      @click="decrementQuantity(props.cart)"
      :disabled="props.cart.quantity == 1"
    >
      &minus;
    </button>

    <input
      type="number"
      id="Quantity"
      class="h-10 w-16 border border-gray-200 text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none"
      v-model="props.cart.quantity"
      @input="updateCart(props.cart)"
    />

    <button
      type="button"
      class="w-10 h-10 leading-10 text-gray-600 transition hover:opacity-75"
      @click="incrementQuantity(props.cart)"
    >
      &plus;
    </button>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useStore } from "vuex";

const store = useStore();
const props = defineProps({
  cart: {
    type: Object,
    required: true,
  },
});

onMounted(() => {
  store.dispatch("cart/getCart");
});

const quantity = ref("");

const updateCart = async (cart) => {
  try {
    await new Promise((resolve) => setTimeout(resolve, 1000));

    const response = await store.dispatch("cart/updateCart", cart);
  } catch (error) {
    console.log(error);
  }
};

let timeoutId;

async function updateCartWithDelay(cart) {
  clearTimeout(timeoutId);

  await new Promise((resolve) => {
    timeoutId = setTimeout(resolve, 500);
  });

  await updateCart(cart);
}

function decrementQuantity(cart) {
  if (cart.quantity > 1) {
    cart.quantity--;
    updateCartWithDelay(cart);
  }
}

function incrementQuantity(cart) {
  cart.quantity++;
  updateCartWithDelay(cart);
}
</script>
