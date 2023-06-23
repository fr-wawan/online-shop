<template>
  <div class="overflow-auto lg:overflow-hidden">
    <table class="w-full border">
      <thead>
        <tr>
          <th class="border p-3 font-semibold" v-for="header in headers">
            {{ header }}
          </th>
        </tr>
      </thead>
      <tbody>
        <slot />
      </tbody>
    </table>
  </div>
</template>

<script setup>
const props = defineProps({
  headers: {
    Type: Array,
    required: true,
  },
});

const arr = ["woi", "tes"];
</script>
