<template>
  <div>
    <Hero class="text-center">
      <h1 class="text-5xl font-semibold">Register</h1>
      <p class="text-gray-400 mt-5 flex items-center justify-center">
        Home
        <img src="../../assets/images/greater-than.png" alt="" width="30" />
        <span class="text-white">My Account</span>
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
          Register Your Account
        </h1>

        <form action="" @submit.prevent="register">
          <Input
            name="username"
            label="Username*"
            v-model="userData.username"
            placeholder="Your Username"
          ></Input>
          <Input
            name="first_name"
            label="First Name*"
            v-model="userData.first_name"
            placeholder="Your First Name"
          ></Input>
          <Input
            name="last_name"
            label="Last Name*"
            v-model="userData.last_name"
            placeholder="Your Last Name"
          ></Input>
          <Input
            name="email"
            label="Email*"
            v-model="userData.email"
            placeholder="Your Email"
            type="email"
          ></Input>
          <Input
            name="password"
            label="Password*"
            v-model="userData.password"
            placeholder="*********"
            type="password"
          ></Input>

          <Input
            name="password"
            label="Password Confirmation*"
            v-model="userData.password_confirmation"
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
    </PageTransition>
  </div>
</template>

<script setup>
import Hero from "../../components/Hero.vue";
import Button from "../../components/Button.vue";
import PageTransition from "../../components/PageTransition.vue";
import Input from "../../components/Input.vue";

import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";
import { ref, reactive } from "vue";

let userData = reactive({
  username: "",
  first_name: "",
  last_name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const validation = ref([]);

const store = useStore();
const router = useRouter();
const toast = useToast();

function register() {
  const {
    username,
    first_name,
    last_name,
    email,
    password,
    password_confirmation,
  } = userData;

  store
    .dispatch("auth/register", {
      username,
      first_name,
      last_name,
      email,
      password,
      password_confirmation,
    })
    .then(() => {
      router.push({ name: "dashboard" });
      toast.success("Register Successful");
    })
    .catch((error) => {
      validation.value = error;

      for (const field in validation.value) {
        if (validation.value[field]) {
          toast.error(`${validation.value[field][0]}`);
        }
      }
    });
}
</script>
