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
  <div class="mt-20" v-else>
    <div class="flex justify-center">
      <div class="w-full">
        <CheckoutForm />
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

const store = useStore();
onMounted(() => {});

const profile = computed(() => {
  return JSON.parse(localStorage.getItem("user")) || {};
});

const router = useRouter();
</script>
