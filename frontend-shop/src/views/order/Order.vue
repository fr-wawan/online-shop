<template>
  <div>
    <Hero>
      <h1 class="text-5xl font-semibold">My Account</h1>
      <p class="text-gray-400 mt-5 flex items-center justify-center">
        Home
        <img src="../../assets/images/greater-than.png" alt="" width="30" />
        <span class="text-white"> My Account</span>
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
            :headers="['Order ID', 'Order Date', 'Status', 'Total', 'Actions']"
          >
            <tr class="text-center text-gray-500">
              <td class="border p-3">#56986</td>
              <td class="border p-3">21 August 2021</td>
              <td class="border p-3">Pending</td>
              <td class="border p-3">$ 985. 0789.00 for 85 Items</td>
              <td class="p-3 flex justify-center"><EyeIcon /></td>
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

import { ref } from "vue";
</script>
