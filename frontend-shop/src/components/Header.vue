<template>
  <div class="overflow-x-auto">
    <header class="bg-white py-4 shadow-lg fixed top-0 left-0 right-0 z-10">
      <nav
        class="flex justify-around xl:justify-between xl:mx-20 md:p-5 items-center"
      >
        <router-link to="/" class="md:text-xl text-blue-500 font-bold text-lg"
          >GROCERY SHOP</router-link
        >
        <div class="w-8/12 gap-4 hidden md:flex justify-center min-w-fit">
          <router-link to="/" active-class="text-blue-500">Home</router-link>

          <router-link to="/shop" active-class="text-blue-500"
            >Shop</router-link
          >
          <router-link to="/about" active-class="text-blue-500"
            >About</router-link
          >
          <router-link to="/contact" active-class="text-blue-500"
            >Contact</router-link
          >
        </div>

        <div class="flex items-center gap-5">
          <a href="">
            <SearchIcon />
          </a>

          <router-link to="/cart" v-if="store.getters['auth/isLoggedIn']">
            <CartIcon />
          </router-link>
          <div
            class="flex items-center"
            @click="toggleDropDown"
            v-if="store.getters['auth/isLoggedIn']"
            v-click-outside-element="closeDropDown"
          >
            <img
              :src="
                profile?.avatar?.includes('storage')
                  ? `http://localhost:8000${profile.avatar}`
                  : profile.avatar
              "
              class="rounded-full w-9 cursor-pointer object-cover"
            />
            <DownIcon />
            <div
              class="z-10 bg-white absolute md:right-28 right-20 top-20 rounded-lg shadow w-44"
              v-if="isDropDown"
            >
              <ul class="py-2 text-sm text-gray-700">
                <li>
                  <router-link
                    :to="{ name: 'orders' }"
                    class="block px-4 py-2 hover:bg-gray-200"
                    >My Orders</router-link
                  >
                </li>
                <li>
                  <router-link
                    :to="{ name: 'profile' }"
                    class="block px-4 py-2 hover:bg-gray-200"
                    >Edit Profile</router-link
                  >
                </li>
                <li>
                  <a class="block cursor-pointer px-4 py-2 hover:bg-gray-200"
                    >Logout</a
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
    </header>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useStore } from "vuex";
import { useToast } from "vue-toastification";

import SearchIcon from "./Logo/SearchIcon.vue";
import CartIcon from "./Logo/CartIcon.vue";
import DownIcon from "./Logo/DownIcon.vue";

let isShow = ref(false);
const isDropDown = ref(false);
const store = useStore();
const toast = useToast();

onMounted(() => {
  store.dispatch("profile/getProfile");
});

const profile = computed(() => {
  return store.state.profile.profile;
});

function changeShow() {
  isShow.value = isShow.value == false ? true : false;
}

function toggleDropDown() {
  isDropDown.value = !isDropDown.value;
}

function closeDropDown() {
  isDropDown.value = false;
}
const isMobile = ref(false);
const isTablet = ref(false);

function checkScreenSize() {
  const width = window.innerWidth;
  isMobile.value = width <= 480;
  isTablet.value = width > 480 && width <= 1024;
}

window.addEventListener("load", checkScreenSize);
window.addEventListener("resize", checkScreenSize);
</script>
