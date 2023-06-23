<template>
  <div class="md:w-3/12 w-9/12 mx-auto">
    <DashboardTab link="dashboard">
      <DashboardIcon />
      Dashboard
    </DashboardTab>

    <DashboardTab link="profile">
      <ProfileIcon />
      Profile
    </DashboardTab>

    <DashboardTab link="orders">
      <OrderIcon />
      My Order
    </DashboardTab>

    <a
      class="p-4 flex justify-center text-lg gap-2 mb-5 items-center bg-white shadow-lg cursor-pointer text-gray-500"
      @click="logout"
    >
      <LogoutIcon />
      Logout
    </a>
  </div>
</template>

<script setup>
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";

import DashboardIcon from "../Logo/DashboardIcon.vue";
import ProfileIcon from "../Logo/ProfileIcon.vue";
import DashboardTab from "./DashboardTab.vue";
import LogoutIcon from "../Logo/LogoutIcon.vue";
import OrderIcon from "../Logo/OrderIcon.vue";

const store = useStore();
const router = useRouter();
const toast = useToast();

function logout() {
  store.dispatch("auth/logout").then(() => {
    router.push({
      name: "login",
    });

    toast.success("Logout Successfull");
  });
}
</script>
