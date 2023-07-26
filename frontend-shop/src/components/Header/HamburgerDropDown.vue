<template>
  <div class="md:hidden" v-click-outside-element="closeDropDown">
    <div @click="toggleDropDown">
      <img src="../../assets/images/hamburger.png" alt="" width="20" />
    </div>
  </div>
  <div
    v-if="isDropDown"
    class="bg-white md:hidden absolute w-full left-0 top-14"
  >
    <div class="gap-4 flex flex-col shadow-xl p-5 text-center">
      <router-link to="/" active-class="text-blue-500">Home</router-link>

      <router-link to="/shop" active-class="text-blue-500">Shop</router-link>
      <router-link to="/about" active-class="text-blue-500">About</router-link>
      <router-link
        to="/contact"
        active-class="text-blue-500"
        class="border-b pb-3"
        >Contact</router-link
      >

      <router-link
        v-if="store.getters['auth/isLoggedIn']"
        to="/profile"
        active-class="text-blue-500"
        class="bg-gray-800 flex justify-center gap-3 p-3 text-white rounded-lg"
      >
        <DashboardIcon />
        Profile</router-link
      >
      <div v-else class="flex gap-5 items-center justify-center">
        <router-link
          class="bg-blue-500 text-white p-2 px-3 rounded-md"
          to="/register"
          >Register</router-link
        >
        <router-link
          to="/login"
          class="outline outline-1 outline-blue-500 p-2 px-5 rounded-md text-blue-500"
          >Login</router-link
        >
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import DashboardIcon from "../Logo/DashboardIcon.vue";
import { useStore } from "vuex";

const isDropDown = ref(false);
const store = useStore();

function toggleDropDown() {
  isDropDown.value = !isDropDown.value;
}

function closeDropDown() {
  isDropDown.value = false;
}
</script>
