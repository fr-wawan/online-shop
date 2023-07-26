<template>
  <div class="overflow-auto">
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
</script>
