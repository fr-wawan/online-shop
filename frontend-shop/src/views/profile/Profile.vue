<template>
  <div class="overflow-x-hidden">
    <Hero class="overflow-x-hidden">
      <h1 class="text-5xl font-semibold">My Account</h1>
      <p class="text-gray-400 mt-5 flex items-center justify-center">
        Home
        <img src="../../assets/images/greater-than.png" alt="" width="30" />
        <span class="text-white"> My Account</span>
      </p>
    </Hero>

    <div class="xl:flex mt-20 xl:w-8/12 gap-5 mx-auto">
      <DashboardSidebar></DashboardSidebar>

      <div>
        <div
          v-motion-fade
          class="shadow-md min-[1500px]:w-[1000px] min-[1270px]:w-[700px] min-[1280px]:mr-64 rounded-lg mx-auto w-full lg:w-10/12 bg-white p-5"
        >
          <div>
            <h1 class="text-xl font-semibold">Profile</h1>

            <form
              method="post"
              @submit.prevent="updateProfile"
              enctype="multipart/form-data"
            >
              <div class="md:flex items-center gap-5 mt-5">
                <img
                  :src="profile.avatar"
                  class="rounded-full w-20 h-20 object-cover"
                  v-if="Object.keys(profile).length > 0"
                />

                <div v-else>
                  <ContentLoader class="rounded-full w-20 h-20 object-cover" />
                </div>

                <input
                  @change="onFileChange"
                  type="file"
                  name="file"
                  id="file"
                  class="block border border-gray-300 mt-3 rounded md:w-full w-full p-2.5 placeholder:text-sm placeholder:p-1 placeholder:text-gray-400"
                />
              </div>
              <div>
                <ProfileForm></ProfileForm>

                <SaveButton>Save Change</SaveButton>
              </div>
            </form>
          </div>
        </div>

        <div
          class="shadow-md min-[1500px]:w-[1000px] min-[1270px]:w-[700px] min-[1280px]:mr-64 rounded-lg mx-auto w-full lg:w-10/12 bg-white p-5 mt-10"
        >
          <h1 class="text-xl font-semibold">Change Password</h1>

          <form method="post" @submit.prevent="updatePassword">
            <Input
              name="password"
              label="Password*"
              placeholder="************"
              type="password"
              class="w-full"
              v-model="userPassword.password"
            ></Input>
            <Input
              name="password_confirmation"
              label="Confirm Password*"
              placeholder="************"
              type="password"
              class="w-full"
              v-model="userPassword.password_confirmation"
            ></Input>
            <SaveButton>Save Change</SaveButton>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import DashboardSidebar from "../../components/Dashboard/DashboardSidebar.vue";
import Hero from "../../components/Hero.vue";
import ProfileForm from "../../components/ProfileForm.vue";
import Input from "../../components/Input.vue";
import SaveButton from "../../components/SaveButton.vue";

import { ContentLoader } from "vue-content-loader";
import { computed, onMounted, reactive, ref } from "vue";
import { useStore } from "vuex";
import { useToast } from "vue-toastification";

const store = useStore();
const toast = useToast();

onMounted(() => {
  store.dispatch("profile/getProfile");
});

const isMobile = ref(false);
const isTablet = ref(false);

function checkScreenSize() {
  const width = window.innerWidth;
  isMobile.value = width <= 480;
  isTablet.value = width > 480 && width <= 1300;
}

window.addEventListener("load", checkScreenSize);
window.addEventListener("resize", checkScreenSize);

const profile = computed(() => {
  return store.state.profile.profile;
});

const imageAvatar = ref(null);

function onFileChange(e) {
  imageAvatar.value = e.target.files[0];

  if (!imageAvatar.value.type.match("image.*")) {
    e.target.value = "";
    imageAvatar.value = null;

    toast.error("Type must be a images");
  }
}

const validation = ref([]);

function updateProfile() {
  let formData = new FormData();

  formData.append("avatar", imageAvatar.value);
  formData.append("username", profile.value.username);
  formData.append("first_name", profile.value.first_name);
  formData.append("last_name", profile.value.last_name);
  formData.append("email", profile.value.email);
  formData.append("phone", profile.value.phone);
  formData.append("address", profile.value.address);
  formData.append("post_code", profile.value.post_code);
  formData.append("country", profile.value.country);
  formData.append("states", profile.value.states);
  formData.append("city", profile.value.city);

  store
    .dispatch("profile/updateProfile", formData)
    .then(() => {
      toast.success("Profile Successfully Updated");
      imageAvatar.value = null;
    })
    .catch((error) => {
      validation.value = error;
      console.log(error);

      for (const field in validation.value) {
        if (validation.value[field]) {
          toast.error(`${validation.value[field][0]}`);
        }
      }
    });
}

const userPassword = reactive({
  password: "",
  password_confirmation: "",
});

function updatePassword() {
  let { password, password_confirmation } = userPassword;

  store
    .dispatch("profile/updatePassword", {
      password,
      password_confirmation,
    })
    .then(() => {
      toast.success("Password Successfully Updated");
    })
    .catch((error) => {
      validation.value = error;
      if (validation.value.password) {
        toast.error(`${validation.value.password[0]}`);
      }
    });
}
</script>

<style scoped>
.width-850 {
  width: 850px;
}

@media (max-width: 400px) {
  .width-850 {
    width: 200px;
  }
}
</style>
