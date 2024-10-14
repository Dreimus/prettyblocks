<template>
  <input
    ref="inputRef"
    type="number"
    :value="value.value"
    @change="onChange"
    @keyup.enter="validateAndChange"
    class="input"
  />
</template>

<script setup lang="ts">
import {ref} from "vue";
import {PrimitiveNumberType} from "../../../core-logic/entities/PrimitiveFieldContent";

const emit = defineEmits(["update:modelValue"]);
const { value } = defineProps<{ value: PrimitiveNumberType }>();

const inputRef = ref(null);

const validateAndChange = (event) => {
  inputRef.value.blur();
  onChange(event);
};
const onChange = (event) => {
  emit("update:modelValue", { value: Number(event.target.value) });
};
</script>

<style scoped lang="scss">
@import "../../../assets/styles/vars";

.input {
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
