<template>
  <div class="prestashop-entity-selector">
    <!-- Sélection du type d'entité -->
    <div class="type-selector">
      <label for="entity-type">Type d'entité :</label>
      <select v-model="selectedType" @change="fetchValues">
        <option value="" disabled>-- Sélectionnez un type --</option>
        <option v-for="type in availableTypes" :key="type.slug" :value="type.slug">
          {{ type.label }}
        </option>
      </select>
    </div>

    <!-- Sélection de la valeur avec auto-complétion, affichée uniquement si un type est sélectionné -->
    <div v-if="selectedType" class="value-selector">
      <label for="entity-value">Valeur :</label>
      <input
        type="text"
        placeholder="Recherchez une valeur..."
        v-model="searchQuery"
        @input="filterValues"
        class="autocomplete-input"
      />
      <select v-model="selectedValue" class="autocomplete-select" size="5">
        <option v-for="value in filteredValues" :key="value.id" :value="value.id">
          {{ value.name }}
        </option>
      </select>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, watch } from "vue";
import { defineProps, defineEmits } from "vue";

const { value: field } = defineProps<{ value: { type: string; value: { id: string; name: string } } }>();
const emit = defineEmits(["update:modelValue"]);

const availableTypes = ref<Array<{ slug: string; label: string; getValuesUrl: string }>>([]);
const values = ref<Array<{ id: string; name: string }>>([]);
const searchQuery = ref(""); // Recherche de l'utilisateur
const selectedType = ref(field.type || "");
const selectedValue = ref(field.value || null);
const entityTypeEndpoint = window.prettyblocks.routes.fields_search_entities;

// Liste filtrée en fonction de la recherche
const filteredValues = computed(() => {
  if (!searchQuery.value) return values.value;
  return values.value.filter((value) =>
    value.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

const fetchTypes = async () => {
  try {
    const response = await fetch(entityTypeEndpoint);
    if (!response.ok) throw new Error("Erreur réseau lors de la récupération des types d'entités");
    availableTypes.value = await response.json();
  } catch (error) {
    console.error("Erreur lors de la récupération des types d'entités :", error);
  }
};

const fetchValues = async () => {
  const selectedEntity = availableTypes.value.find(type => type.slug === selectedType.value);
  if (!selectedEntity || !selectedEntity.getValuesUrl) return;
  try {
    const response = await fetch(selectedEntity.getValuesUrl);
    if (!response.ok) throw new Error("Erreur réseau lors de la récupération des valeurs");
    values.value = await response.json();
  } catch (error) {
    console.error("Erreur lors de la récupération des valeurs :", error);
  }
};

// Synchronisation des données avec le parent
watch([selectedType, selectedValue], ([newType, newValue]) => {
  emit("update:modelValue", { type: newType, value: newValue });
});

// Initial fetch
fetchTypes();
if (selectedType.value) {
  fetchValues();
}
</script>

<style scoped>
.prestashop-entity-selector {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.type-selector,
.value-selector {
  display: flex;
  flex-direction: column;
}

.autocomplete-input {
  padding: 0.5em;
  border: 0.1em solid #ccc;
  border-radius: 0.25em;
  margin-bottom: 0.5em;
}

.autocomplete-select {
  padding: 0.5em;
  border: 0.1em solid #ccc;
  border-radius: 0.25em;
  overflow-y: auto; /* Permet le défilement si les options dépassent */
}
</style>
