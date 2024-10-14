<template>
  <div class="switch">
    <div
      class="switchContainer"
      :class="value.value ? 'activated' : ''"
      @click="() => onChange(!value.value)"
    >
      <div class="switchToggle" />
    </div>
  </div>
</template>

<script setup lang="ts">
import {PrimitiveBooleanType} from "../../../core-logic/entities/PrimitiveFieldContent";

const emit = defineEmits(["update:modelValue"]);
const { value } = defineProps<{ value: PrimitiveBooleanType }>();

const onChange = (newValue) => {
  emit("update:modelValue", { value: newValue });
};
</script>

<style scoped lang="scss">
@import "../../../assets/styles/vars";

.switchContainer {
  width: 3rem;
  height: 1.5rem;
  border-radius: 2rem;
  background-color: $bg-hover-color;
  box-shadow: 0px 0px 5px #ccc;
  transition: background-color 0.2s ease-in-out;
  cursor: pointer;
}

.switchToggle {
  width: 1.5rem;
  height: 1.5rem;
  border-radius: 2rem;
  background-color: $bg-primary-color;
  transition: transform 0.2s ease-in-out;
}

.switchContainer.activated {
  background-color: #5a5;
  .switchToggle {
    transform: translateX(100%);
  }
}
</style>
