<template>
  <div
    class="md:flex items-center hidden"
    @click="toggleDropDown"
    v-if="store.getters['auth/isLoggedIn']"
    v-click-outside-element="closeDropDown"
  >
    <img
      :src="profile.avatar"
      class="rounded-full w-9 cursor-pointer object-cover"
    />
    <DownIcon />
    <div
      class="z-10 hidden md:block bg-white absolute md:right-28 top-14 right-12 xl:right-20 xl:top-20 rounded-lg shadow w-44"
      v-if="isDropDown"
    >
      <ul class="py-2 text-sm text-gray-700">
        <li>
          <router-link
            :to="{ name: 'profile' }"
            class="block px-4 py-2 hover:bg-gray-200"
            >Edit Profile</router-link
          >
        </li>
        <li>
          <router-link
            :to="{ name: 'orders' }"
            class="block px-4 py-2 hover:bg-gray-200"
            >My Orders</router-link
          >
        </li>
        <li>
          <a
            @click.prevent="logout"
            class="block cursor-pointer px-4 py-2 hover:bg-gray-200"
            >Logout</a
          >
        </li>
      </ul>
    </div>
  </div>
  <div v-else class="hidden md:flex gap-5 items-center">
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
</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import { useStore } from "vuex";
import DownIcon from "../Logo/DownIcon.vue";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";

const isDropDown = ref(false);

const store = useStore();
const toast = useToast();
const router = useRouter();

onMounted(() => {
  store.dispatch("profile/getProfile");
});

const profile = computed(() => {
  return store.state.profile.profile;
});

function toggleDropDown() {
  isDropDown.value = !isDropDown.value;
}

function closeDropDown() {
  isDropDown.value = false;
}

function logout() {
  store.dispatch("auth/logout").then(() => {
    router.push({
      name: "login",
    });

    toast.success("Logout Successfull");
  });
}
</script>
