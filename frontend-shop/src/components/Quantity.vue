<template>
  <div class="flex items-center border border-gray-200 rounded h-10">
    <button
      type="button"
      class="w-10 h-10 leading-10 text-gray-600 transition hover:opacity-75"
      :disabled="quantity == 1"
      @click="$emit('decrementQuantity', $event.target.value)"
    >
      &minus;
    </button>

    <input
      type="number"
      id="Quantity"
      class="h-10 w-16 border border-gray-200 text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
    />

    <button
      type="button"
      class="w-10 h-10 leading-10 text-gray-600 transition hover:opacity-75"
      @click="$emit('incrementQuantity', $event.target.value)"
    >
      &plus;
    </button>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useStore } from "vuex";

const store = useStore();
const props = defineProps({
  modelValue: {
    type: Number,
    required: true,
  },
  quantity: {
    type: Number,
    required: true,
  },
  value: String,
});
</script>
