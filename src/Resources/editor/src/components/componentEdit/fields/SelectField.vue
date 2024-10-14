<template>
  <select :value="value.value" @input="onChange" class="select">
    <option v-for="option in value.options" :value="option.value">
      {{ option.label }}
    </option>
  </select>
</template>

<script setup lang="ts">
import {PrimitiveSelectType} from "../../../core-logic/entities/PrimitiveFieldContent";

const emit = defineEmits(["update:modelValue"]);
const { value } = defineProps<{ value: PrimitiveSelectType }>();

function onChange(event) {
  emit("update:modelValue", {
    value: event.target.value,
    options: value.options,
  });
}
</script>

<style scoped lang="scss">
@import "../../../assets/styles/vars";

.select {
  display: block;
  max-width: 100%;
  width: 100%;
  padding: 0.25rem 0.5rem;
  margin-right: 0.5rem;
  border-radius: 0.5rem;
  &:focus {
    border: 2px solid $primary-color;
    box-shadow: none;
  }
}
</style>
