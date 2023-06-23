<template>
  <div>
    <Hero class="text-center">
      <h1 class="text-5xl font-semibold">My Account</h1>
      <p class="text-gray-400 mt-5 flex items-center justify-center">
        Home
        <img src="../../assets/images/greater-than.png" alt="" width="30" />
        <span class="text-white"> My Account</span>
      </p>
    </Hero>

    <div class="xl:flex block mt-20 xl:w-7/12 gap-5 mx-auto">
      <DashboardSidebar></DashboardSidebar>
      <div>
        <div
          class="shadow-md rounded-lg mx-auto w-11/12 md:w-full xl:w-[1000px] lg:w-10/12 bg-white p-3"
          v-motion-fade
        >
          <h1 class="text-center font-bold text-xl mt-5">
            Hi {{ user.first_name + " " + user.last_name }}
          </h1>
          <div
            class="grid md:grid-cols-2 xl:grid-cols-4 col-span-12 my-8 justify-items-center gap-3"
          >
            <div
              class="border text-center p-10 rounded-md mt-3 w-full"
              v-for="card in cards"
            >
              <h1 class="text-4xl text-gray-500 font-bold">{{ card.count }}</h1>
              <h3 class="text-xl text-gray-500 font-semibold mt-2">
                {{ card.title }}
              </h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { computed, ref, reactive } from "vue";
import { useStore } from "vuex";
import DashboardSidebar from "../../components/Dashboard/DashboardSidebar.vue";
import Hero from "../../components/Hero.vue";

const cards = reactive([
  {
    count: 0,
    title: "Pending",
  },
  {
    count: 0,
    title: "Processign",
  },
  {
    count: 0,
    title: "Picked",
  },
  {
    count: 0,
    title: "Complete",
  },
]);

const store = useStore();

const user = computed(() => {
  return store.state.auth.user;
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
</script>
