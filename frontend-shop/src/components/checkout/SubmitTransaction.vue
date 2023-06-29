<template>
  <div class="md:flex w-10/12 mx-auto gap-10">
    <button
      class="p-3 hover:outline outline-1 hover:outline-blue-700 hover:bg-white hover:text-blue-700 transition-all duration-300 ease-in-out bg-blue-700 w-full mt-5 text-white rounded"
      @click.prevent="submitTransaction('cod')"
    >
      Place Order | COD
    </button>
    <button
      class="p-3 bg-red-500 hover:outline outline-1 hover:outline-red-500 hover:text-red-500 transition-all duration-300 ease-in-out hover:bg-white w-full mt-5 text-white rounded"
      @click.prevent="submitTransaction('midtrans')"
    >
      Pay With Gopay, DANA, OVO, etc
    </button>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

const store = useStore();
const router = useRouter();

onMounted(() => {
  store.dispatch("cart/getCart");
});

const props = defineProps({
  notes: String,
});

const carts = computed(() => {
  return store.state.cart.carts;
});

const profile = computed(() => {
  return store.state.profile.profile;
});

const total = computed(() => {
  return store.getters["cart/cartTotal"];
});

const mappedCarts = computed(() => {
  return carts.value.map((cart) => {
    return {
      id: cart.product.id,
      quantity: cart.quantity,
      price: cart.product.price,
    };
  });
});

function submitTransaction(paymentMethod) {
  let formData = new FormData();

  formData.append("first_name", profile.value.first_name);
  formData.append("last_name", profile.value.last_name);
  formData.append("phone", profile.value.phone);
  formData.append("post_code", profile.value.post_code);
  formData.append("address", profile.value.address);
  formData.append("country", profile.value.country);
  formData.append("states", profile.value.states);
  formData.append("city", profile.value.city);
  formData.append("user_notes", props.notes);
  formData.append("paymentMethod", paymentMethod);

  mappedCarts.value.forEach((cart) => {
    formData.append("productIds[]", cart.id);
    formData.append("quantity[]", cart.quantity);
  });

  formData.append("total", total.value);

  store
    .dispatch("order/storeOrder", { formData, paymentMethod })
    .then((response) => {
      router.push({
        name: "detailsOrder",
        params: { invoice: response.invoice },
      });
    });
}
</script>
