<template>
  <div>
    <Hero>
      <h1 class="text-5xl font-semibold">My Order</h1>
      <p class="text-gray-400 mt-5 flex items-center justify-center">
        Home
        <img src="../../assets/images/greater-than.png" alt="" width="30" />
        <span class="text-white">Order</span>
      </p>
    </Hero>

    <div class="xl:flex mt-20 xl:w-7/12 gap-5 mx-auto">
      <DashboardSidebar />

      <div>
        <div
          class="shadow-md rounded-lg xl:w-[1000px] mx-auto w-full bg-white p-10 lg:w-10/12"
          v-motion-fade
        >
          <Table
            :headers="[
              'Order ID',
              'Order Date',
              'Payment Method',
              'Payment Status',
              'Order Status',
              'Total',
              'Actions',
            ]"
          >
            <tr
              class="text-center text-gray-500 border"
              v-for="order in orders"
            >
              <td class="p-3 border-r">
                {{ order.invoice }}
              </td>
              <td class="p-3 border-r">
                {{ order.order_placed_at }}
              </td>
              <td class="p-3 border-r">
                {{ order.payment_method.toUpperCase() }}
              </td>
              <td class="p-3 border-r">
                {{ uppercaseLetter(order.status) }}
              </td>
              <td class="p-3 border-r">
                {{ uppercaseLetter(order.status) }}
              </td>
              <td class="p-3 border-r">
                {{ formatPrice(order.total) }}
              </td>
              <td class="p-6 flex justify-center items-center">
                <router-link
                  :to="{
                    name: 'detailsOrder',
                    params: { invoice: order.invoice },
                  }"
                >
                  <EyeIcon
                /></router-link>
              </td>
            </tr>
          </Table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Hero from "../../components/Hero.vue";
import DashboardSidebar from "../../components/Dashboard/DashboardSidebar.vue";

import EyeIcon from "../../components/Logo/EyeIcon.vue";
import Table from "../../components/Table.vue";

import { ref, onMounted, computed } from "vue";
import { useStore } from "vuex";

const store = useStore();
onMounted(() => {
  store.dispatch("order/getOrders");
});

const orders = computed(() => {
  return store.state.order.orders;
});
</script>
