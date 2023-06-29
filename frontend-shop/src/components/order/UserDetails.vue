<template>
  <div>
    <div
      class="shadow-md rounded-lg xl:w-[1000px] mx-auto w-full mb-10 bg-white p-10 lg:w-10/12"
      v-motion-fade
      v-if="Object.keys(order).length > 0"
    >
      <h1 class="text-xl border-b pb-3 font-semibold">User Details</h1>

      <div class="overflow-auto lg:overflow-hidden">
        <table class="border mt-5 w-full">
          <tr>
            <td class="w-52 border p-3">NO INVOICE</td>
            <td class="w-5 border text-center">:</td>
            <td class="border px-6">{{ order.invoice }}</td>
          </tr>
          <tr>
            <td class="w-52 border p-3">FULL NAME</td>
            <td class="md:w-10 w-52 p-3 border text-center">:</td>
            <td class="border px-6">
              {{ `${order.first_name} ${order.last_name}` }}
            </td>
          </tr>
          <tr>
            <td class="w-52 border p-3">PHONE NUMBER</td>
            <td class="md:w-10 w-52 p-3 border text-center">:</td>
            <td class="border px-6">{{ order.phone }}</td>
          </tr>
          <tr>
            <td class="w-52 border p-3">REGION</td>
            <td class="md:w-10 w-52 p-3 border text-center">:</td>
            <td class="border px-6">
              {{ `${order.country}, ${order.states}, ${order.city}` }}
            </td>
          </tr>

          <tr>
            <td class="w-52 border p-3">ADDRESS</td>
            <td class="md:w-10 w-52 p-3 border text-center">:</td>
            <td class="border px-6">{{ order.address }}</td>
          </tr>
          <tr>
            <td class="w-52 border p-3">DELIVERY STATUS</td>
            <td class="md:w-10 w-52 p-3 border text-center">:</td>
            <td class="border px-6">{{ uppercaseLetter(order.status) }}</td>
          </tr>
          <tr>
            <td class="w-52 border p-3">PAYMENT STATUS</td>
            <td class="md:w-10 w-52 p-3 border text-center">:</td>
            <td class="border px-6">
              <div class="flex items-center gap-5">
                <p>{{ order.payment_method.toUpperCase() }}</p>
                <span>/</span>
                <button
                  class="bg-blue-700 text-sm p-1.5 px-5 shadow rounded text-white"
                  v-if="
                    order.payment_method == 'midtrans' &&
                    order.payment_status == 'pending'
                  "
                  @click.prevent="midtransPayment(order.snap_token)"
                >
                  PAY NOW
                </button>
                <p v-else>Completed</p>
              </div>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

const store = useStore();
const router = useRouter();

const order = computed(() => {
  return store.state.order.order;
});

function midtransPayment(snapToken) {
  window.snap.pay(snapToken, {
    onSuccess: function () {
      router.push({ name: "orders" });
    },
    onPending: function () {
      router.push({ name: "orders" });
    },
    onError: function () {
      router.push({ name: "orders" });
    },
  });
}
</script>
