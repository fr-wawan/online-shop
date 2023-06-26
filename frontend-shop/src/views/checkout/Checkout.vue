<template>
  <div class="mt-20 container mx-auto">
    <div
      v-if="
        !localProfile.address &&
        !localProfile.phone &&
        !localProfile.country &&
        !localProfile.states &&
        !localProfile.city &&
        !localProfile.post_code
      "
    >
      <Modal link="/profile">Please Complete The Profile First</Modal>
    </div>
    <div v-if="!carts.length > 0">
      <Modal link="/">You dont have any items in your Cart</Modal>
    </div>
    <div class="flex flex-col-reverse md:flex-row justify-center gap-10">
      <div class="w-full">
        <CheckoutForm @getNotes="notes = $event"> </CheckoutForm>
      </div>
      <div class="w-full">
        <OrderSummary />
        <SubmitTransaction :notes="notes" />
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, reactive, onMounted, computed, watch } from "vue";
import { useStore } from "vuex";
import { useRouter, useRoute } from "vue-router";
import Modal from "../../components/Modal.vue";
import CheckoutForm from "../../components/checkout/CheckoutForm.vue";
import OrderSummary from "../../components/checkout/OrderSummary.vue";
import SubmitTransaction from "../../components/checkout/SubmitTransaction.vue";

const store = useStore();
onMounted(() => {});

const localProfile = computed(() => {
  return JSON.parse(localStorage.getItem("user")) || {};
});

const carts = computed(() => {
  return store.state.cart.carts;
});

const router = useRouter();

let notes = ref("");
</script>
