<template>
  <div class="h-screen bg-gray-50 scroll-smooth">
    <Header />

    <router-view></router-view>
  </div>
</template>

<script>
import Header from "./components/Header.vue";
export default {
  name: "AppComponent",

  components: {
    Header,
  },
};
</script>

<style lang="css">
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
