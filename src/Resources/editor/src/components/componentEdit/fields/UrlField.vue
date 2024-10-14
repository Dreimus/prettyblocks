<template>
  <input
    ref="inputRef"
    type="url"
    :value="value.value"
    @change="onChange"
    @keyup.enter="onChange"
    class="input"
  />
</template>

<script setup lang="ts">
import {ref} from "vue";
import {PrimitiveTextType} from "../../../core-logic/entities/PrimitiveFieldContent";

const emit = defineEmits(["update:modelValue"]);
const { value } = defineProps<{ value: PrimitiveTextType }>();

const inputRef = ref(null);

function onChange(event) {
  emit("update:modelValue", { value: event.target.value });
  inputRef.value.blur();
}
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
