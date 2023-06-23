<template>
  <transition name="fade" mode="out-in">
    <div v-if="showAnimation">
      <slot></slot>
    </div>
  </transition>
</template>

<script>
import { ref, watch, onMounted } from "vue";
import { useRoute } from "vue-router";

export default {
  name: "PageTransition",
  setup() {
    const showAnimation = ref(false);
    const { name: previousRouteName } = useRoute();

    onMounted(() => {
      showAnimation.value = true;
    });

    watch(
      () => previousRouteName,
      (to, from) => {
        showAnimation.value = from !== to;
      }
    );

    return {
      showAnimation,
    };
  },
};
</script>

<style lang="css">
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.6s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
