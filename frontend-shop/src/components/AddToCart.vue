<template>
  <div>
    <button
      class="bg-white transition-all hover:text-white hover:bg-blue-500 border border-blue-500 p-2 text-blue-500 rounded-xl mx-3 my-3 px-10"
      @click.prevent="addToCart(props.product)"
    >
      Add To Cart
    </button>
  </div>
</template>
<script setup>
import { useStore } from "vuex";
import { useToast } from "vue-toastification";

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

function addToCart(product) {
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
}
</script>
