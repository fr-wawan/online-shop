<template>
  <div class="hero object-cover bg-bottom flex text-white justify-center">
    <div class="self-center justify-self-center">
      <slot />
    </div>
  </div>
</template>

<script>
export default {
  name: "HeroComponent",
};
</script>

<style scoped>
.hero {
  width: 100%;
  background: linear-gradient(rgba(17, 24, 39, 0.8), rgba(17, 24, 39, 0.8)),
    url("../assets/images/hero-images-min.jpg");
  background-position: center top;
  height: 580px;
}
</style>
