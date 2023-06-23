<template>
  <div class="my-5">
    <label :for="name">{{ label }}</label>
    <input
      :type="type"
      :name="name"
      :id="name"
      class="block border border-gray-300 mt-3 rounded md:w-full w-full p-2.5 placeholder:text-sm placeholder:p-1 placeholder:text-gray-400"
      :placeholder="placeholder"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      required
    />
  </div>
</template>

<script>
export default {
  name: "InputComponent",
  props: {
    name: String,
    label: String,
    value: String,
    type: {
      type: String,
      default: "text",
    },
    placeholder: String,
    modelValue: [String, Number],
  },
};
</script>
