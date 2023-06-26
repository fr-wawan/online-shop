<template>
  <div class="overflow-x-auto">
    <header class="bg-white py-4 shadow-lg fixed top-0 left-0 right-0 z-10">
      <nav
        class="flex justify-around xl:justify-between xl:mx-20 md:mx-10 md:p-5 items-center"
      >
        <router-link
          to="/"
          class="md:text-lg xl:text-xl text-blue-500 font-bold text-lg"
          >GROCERY SHOP</router-link
        >
        <div class="w-6/12 gap-4 hidden md:flex justify-center min-w-fit">
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
          <router-link to="/" href="">
            <SearchIcon />
          </router-link>

          <router-link
            to="/cart"
            v-if="store.getters['auth/isLoggedIn']"
            class="flex items-center"
          >
            <CartIcon />
            <span
              class="item-count bg-red-500 text-white font-bold text-xs w-5 h-5 flex items-center justify-center rounded-full -ml-3 md:-ml-5"
              v-if="typeof cartCount == 'number' && cartCount > 0"
              >{{ cartCount }}</span
            >
          </router-link>

          <HamburgerDropDown />
          <ProfileDropDown />
        </div>
      </nav>
    </header>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useStore } from "vuex";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";

import SearchIcon from "./Logo/SearchIcon.vue";
import CartIcon from "./Logo/CartIcon.vue";
import ProfileDropDown from "./Header/ProfileDropDown.vue";
import HamburgerDropDown from "./Header/HamburgerDropDown.vue";

const store = useStore();
const toast = useToast();
const router = useRouter();

onMounted(() => {
  store.dispatch("profile/getProfile");
  store.dispatch("cart/getCart");
});

const cartCount = computed(() => {
  return store.state.cart.count;
});

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

<style>
.badge {
  position: absolute;
  top: 29px;
  right: 175px;
  padding: 5px 10px;
  border-radius: 100%;
  background: red;
  color: white;
  font-size: 10px;
}

.cart {
  display: inline-flex;
  align-items: center;
}

.item-count {
  background-color: red;
  color: white;
  font-size: 12px;
  font-weight: bold;
  padding: 4px;
  border-radius: 50%;
  margin-left: -20px;
  margin-top: -19px;
  z-index: 1;
  text-align: center;
  height: 25px;
  width: 25px;
}
</style>
