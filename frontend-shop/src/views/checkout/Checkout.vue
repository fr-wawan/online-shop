<template>
  <div
    v-if="
      !profile.address &&
      !profile.phone &&
      !profile.country &&
      !profile.states &&
      !profile.city &&
      !profile.post_code
    "
  >
    <Modal />
  </div>
  <div class="mt-20 container mx-auto" v-else>
    <div class="flex justify-center gap-10">
      <div class="w-full">
        <CheckoutForm />
      </div>
      <div class="w-full">
        <OrderSummary />
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, reactive, onMounted, computed } from "vue";
import { useStore } from "vuex";
import { useRouter, useRoute } from "vue-router";
import Modal from "../../components/Modal.vue";
import CheckoutForm from "../../components/checkout/CheckoutForm.vue";
import OrderSummary from "../../components/checkout/OrderSummary.vue";

const store = useStore();
onMounted(() => {});

const profile = computed(() => {
  return JSON.parse(localStorage.getItem("user")) || {};
});

const router = useRouter();
</script>
