<template>
  <select :value="value.value" @input="onChange" class="select">
    <option v-for="option in options" :key="option.value" :value="option.value">
      {{ option.label }}
    </option>
  </select>
</template>

<script setup lang="ts">
import { PrimitiveSelectType } from "../../../core-logic/entities/PrimitiveFieldContent";
import { ref, onMounted } from "vue";

const emit = defineEmits(["update:modelValue"]);
const { value } = defineProps<{ value: PrimitiveSelectType }>();

const options = ref<PrimitiveSelectType["options"]>([]);

const fetchRavipotes = async () => {
  try {
    const response = await fetch(window.prettyblocks.routes.fields_search_ravipotes);
    if (!response.ok) throw new Error("Erreur lors de la récupération des ravipotes");
    const data = await response.json();

    // Transformation des données
    options.value = Object.entries(data).map(([key, val]) => ({
      value: key,
      label: val,
    }));
  } catch (error) {
    console.error("Erreur lors du chargement des ravipotes :", error);
  }
};

function onChange(event) {
  emit("update:modelValue", {
    value: event.target.value,
    options: options.value,
  });
}

onMounted(() => {
  fetchRavipotes();
});
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
