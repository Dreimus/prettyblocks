<template>
  <div class="rangeField">
    <input
      type="range"
      :min="value.min"
      :max="value.max"
      :value="value.value"
      @input="onChange"
    />
    {{ value.value }}
  </div>
</template>

<script setup lang="ts">
import {PrimitiveRangeType} from "../../../core-logic/entities/PrimitiveFieldContent";

const emit = defineEmits(["update:modelValue"]);
const { value } = defineProps<{ value: PrimitiveRangeType }>();

function onChange(event) {
  emit("update:modelValue", {
    min: value.min,
    max: value.max,
    value: Number(event.target.value),
  });
}
</script>

<style scoped>
.rangeField {
  display: flex;
  align-items: center;
  gap: 1rem;
}
</style>
