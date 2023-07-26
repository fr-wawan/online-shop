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
    <div class="bg-white shadow-md p-5 rounded-md mx-5 md:mx-auto md:w-10/12 xl:w-4/12 mt-14 xl:mt-0">
      <h1 class="text-center text-3xl font-semibold my-3 mb-10">
        Register Your Account
      </h1>

      <form action="" @submit.prevent="register">
        <template v-for="input in registerForm" :key="input.name">
          <Input :name="input.name" :label="input.label" v-model="userData[input.name]" :placeholder="input.placeholder"
            :type="input.type" />
        </template>


        <button class="w-full bg-blue-500 p-4 text-white font-semibold rounded mb-10 mt-3">
          CREATE AN ACCOUNT
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";

import Hero from "../../components/Hero.vue";
import Button from "../../components/Button.vue";
import Input from "../../components/Input.vue";

let userData = reactive({
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


const registerForm = [
  {
    name: "first_name",
    label: "First Name*",
    placeholder: "Your First Name",
    type: "text"
  },
  {
    name: "last_name",
    label: "Last Name*",
    placeholder: "Your Last Name",
    type: "text"
  },
  {
    name: "email",
    label: "Email*",
    placeholder: "Your Email",
    type: "email"
  },
  {
    name: "password",
    label: "Password*",
    placeholder: "Your Password",
    type: "password"
  },
  {
    name: "password_confirmation",
    label: "Password Confirmation*",
    placeholder: "Your Password Confirmation",
    type: "password"
  },
]

async function register() {
  const {
    username,
    first_name,
    last_name,
    email,
    password,
    password_confirmation,
  } = userData;

  await store
    .dispatch("auth/register", {
      username,
      first_name,
      last_name,
      email,
      password,
      password_confirmation,
    })
    .then(() => {
      router.push({ name: "profile" });
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
