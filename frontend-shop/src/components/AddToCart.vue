<template>
  <div>
    <button
      class="bg-white transition-all hover:text-white hover:bg-blue-500 border border-blue-500 p-2 text-blue-500 rounded-md mx-3 my-3 px-4 text-sm md:px-10 md:text-base"
      @click.prevent="addToCart(props.product)"
    >
      Add To Cart
    </button>
  </div>
</template>
<script setup>
import { useStore } from "vuex";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";

const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
  quantity: {
    type: Number,
    required: true,
  },
});

const store = useStore();
const toast = useToast();
const router = useRouter();

function addToCart(product) {
  if (store.getters["auth/isLoggedIn"]) {
    let formData = new FormData();
    formData.append("id", product.id);
    formData.append("quantity", props.quantity);

    store
      .dispatch("cart/storeCart", formData)
      .then(() => {
        toast.success("Success!");
      })
      .catch(() => {
        toast.error("Failed!");
      });
  } else {
    router.push({ name: "login" });
  }
}
</script>
