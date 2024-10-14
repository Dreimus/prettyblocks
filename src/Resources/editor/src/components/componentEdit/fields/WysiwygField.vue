<template>
  <QuillEditor
    contentType="html"
    @update:content="onChange"
    ref="inputRef"
    :content="value.value"
    class="input"
  />
</template>

<script setup lang="ts">
import {ref} from "vue";
import {PrimitiveTextType} from "../../../core-logic/entities/PrimitiveFieldContent";

const emit = defineEmits(["update:modelValue"]);
const { value } = defineProps<{ value: PrimitiveTextType }>();

const inputRef = ref(null);

function onChange() {
  emit("update:modelValue", { value: inputRef.value.getHTML() });
}
</script>

<style scoped lang="scss"></style>
