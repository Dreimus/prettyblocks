<template>
  <input
    class="colorInput"
    type="color"
    :value="value.value"
    @change="onChange"
    ref="inputRef"
  />
</template>

<script setup lang="ts">
import {ref} from "vue";
import {PrimitiveColorType} from "../../../core-logic/entities/PrimitiveFieldContent";

const emit = defineEmits(["update:modelValue"]);
const { value } = defineProps<{ value: PrimitiveColorType }>();
const inputRef = ref(null);

const onChange = (event) => {
  emit("update:modelValue", { value: event.target.value });
  inputRef.value.blur();
};
</script>

<style scoped>
.colorInput {
  display: block;
}
</style>
