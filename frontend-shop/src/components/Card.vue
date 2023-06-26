<template>
  <div
    class="flex flex-col xl:mb-10 md:mb-5 mb-2 bg-white p-5 text-center rounded shadow-md flex-grow-0 shrink-0 md:basis-[23rem] mx-auto basis-[17rem] md:mx-auto"
  >
    <router-link
      :to="{ name: 'detailsProduct', params: { slug: props.product.slug } }"
    >
      <img
        :src="`https://source.unsplash.com/1200x1000?${props.product.title}`"
        class="mx-auto rounded-lg"
        alt=""
      />

      <h3 class="font-bold mt-5 mb-3">{{ props.product.title }}</h3>
      <div>
        <p class="font-bold text-xl mb-3">${{ props.product.price }}/KG</p>

        <add-to-cart :product="props.product" :quantity="quantity" />
      </div>
    </router-link>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { useStore } from "vuex";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";
import AddToCart from "./AddToCart.vue";

const props = defineProps({
  product: Object,
});

const store = useStore();
const router = useRouter();
const toast = useToast();

const quantity = ref(1);
</script>
