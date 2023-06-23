<template>
  <div>
    <Hero class="text-center">
      <h1 class="text-5xl font-semibold">Login</h1>
      <p class="text-gray-400 mt-5 flex items-center justify-center">
        Home
        <img src="../../assets/images/greater-than.png" alt="" width="30" />
        <span class="text-white"> My Account</span>
      </p>
    </Hero>

    <div class="md:justify-center md:gap-10 mt-20 md:flex text-center">
      <div class="mb-16">
        <Button link="register">Register</Button>
      </div>
      <div>
        <Button link="login">Login</Button>
      </div>
    </div>

    <PageTransition>
      <div
        class="bg-white shadow-md p-5 rounded-md mx-5 md:mx-auto md:w-10/12 xl:w-4/12 mt-14 xl:mt-0"
      >
        <h1 class="text-center text-3xl font-semibold my-3 mb-10">
          Login Your Account
        </h1>
        <form action="" @submit.prevent="login">
          <Input
            name="email"
            label="Email*"
            v-model="userData.email"
            placeholder="Your Email"
          ></Input>
          <Input
            name="password"
            label="Password*"
            v-model="userData.password"
            placeholder="**********"
            type="password"
          ></Input>

          <button
            class="w-full bg-blue-500 p-4 text-white font-semibold rounded mb-10 mt-3"
          >
            CREATE AN ACCOUNT
          </button>
        </form>
      </div>
      <div class="my-20 invisible">test</div>
    </PageTransition>
  </div>
</template>

<script setup>
import { useStore } from "vuex";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";
import { reactive, ref } from "vue";

import PageTransition from "../../components/PageTransition.vue";
import Input from "../../components/Input.vue";
import Hero from "../../components/Hero.vue";
import Button from "../../components/Button.vue";

const store = useStore();
const router = useRouter();
const toast = useToast();

let validation = ref([]);

// Data for binding input
let userData = reactive({
  email: "",
  password: "",
});

function login() {
  const { email, password } = userData;

  store
    .dispatch("auth/login", {
      email,
      password,
    })
    .then(() => {
      router.push({ name: "dashboard" });
      toast.success("Login Successful");
    })
    .catch((error) => {
      validation.value = error;

      if (validation.value.email) {
        toast.error(`${validation.value.email[0]}`);
      }

      if (validation.value.password) {
        toast.error(`${validation.value.password[0]}`);
      }

      if (validation.value.message) {
        toast.error(`${validation.value.message}`);
      }
    });
}
</script>
