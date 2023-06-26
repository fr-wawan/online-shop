<template>
  <div
    class="fixed z-10 overflow-y-auto mt-80 md:mt-0 top-0 w-full left-0"
    id="modal"
  >
    <div
      class="flex items-center justify-center min-height-100vh pt-4 px-4 pb-20 text-center sm:block sm:p-0"
    >
      <div class="fixed inset-0 transition-opacity">
        <div class="absolute inset-0 bg-gray-900 opacity-75" />
      </div>
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
        >&#8203;</span
      >
      <div
        class="inline-block align-center bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-headline"
      >
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <h1 class="text-xl font-semibold">
            <slot />
          </h1>
        </div>
        <div class="bg-gray-200 px-4 py-3 text-right">
          <router-link
            :to="link"
            type="button"
            class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 mr-2"
          >
            Go
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  link: String,
});
</script>
