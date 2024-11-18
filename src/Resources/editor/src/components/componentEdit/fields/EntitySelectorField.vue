<template>
  <div class="entity-selector">
    <!-- Sélection du type d'entité -->
    <div class="type-selector">
      <label for="entity-type">Type d'entité :</label>
      <select v-model="selectedType" @change="handleTypeChange">
        <option value="" disabled>-- Sélectionnez un type --</option>
        <option v-for="type in availableTypes" :key="type.slug" :value="type.slug">
          {{ type.label }}
        </option>
        <option value="custom_link">Lien libre</option>
      </select>
    </div>

    <!-- Champs pour les liens libres -->
    <div v-if="selectedType === 'custom_link'" class="custom-link">
      <label for="custom-link-label">Texte du lien :</label>
      <input
        type="text"
        placeholder="Saisissez le texte du lien..."
        v-model="customLinkLabel"
        @input="emitCustomLink"
        class="custom-link-input"
      />
      <label for="custom-link">Lien :</label>
      <input
        type="text"
        placeholder="Saisissez le lien..."
        v-model="customLink"
        @input="emitCustomLink"
        class="custom-link-input"
      />
    </div>

    <!-- Liste déroulante des valeurs pour les entités -->
    <div v-else-if="selectedType" class="value-selector">
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
import { ref, computed, watch, onMounted } from "vue";
import { defineProps, defineEmits } from "vue";

// Propriétés et émetteurs
const { value: field } = defineProps<{ value: { type?: string; value?: { id?: string; name?: string; href?: string } } | null }>();
const emit = defineEmits(["update:modelValue"]);

// Références pour les données
const availableTypes = ref<Array<{ slug: string; label: string; getValuesUrl: string }>>([]);
const values = ref<Array<{ id: string; name: string }>>([]);
const searchQuery = ref(""); // Recherche de l'utilisateur
const selectedType = ref<string>(field?.type || ""); // Type sélectionné
const selectedValue = ref<string | null>(field?.value?.id || null); // Valeur sélectionnée (id)
const customLink = ref<string>(field?.value?.href || ""); // Lien libre (href)
const customLinkLabel = ref<string>(field?.value?.name || ""); // Texte du lien libre (name)
const entityTypeEndpoint = window.prettyblocks.routes.fields_search_entities || "";

// Liste filtrée en fonction de la recherche
const filteredValues = computed(() => {
  if (!searchQuery.value) return values.value;
  return values.value.filter((value) =>
    value.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

// Chargement des types
const fetchTypes = async () => {
  try {
    console.log("Fetching entity types...");
    const response = await fetch(entityTypeEndpoint);
    if (!response.ok) throw new Error("Erreur réseau lors de la récupération des types d'entités");
    availableTypes.value = await response.json();
    console.log("Fetched types:", availableTypes.value);

    // Si un type est déjà sélectionné, charger les valeurs correspondantes
    if (selectedType.value && selectedType.value !== "custom_link") {
      await fetchValues();
    }
  } catch (error) {
    console.error("Erreur lors de la récupération des types d'entités :", error);
  }
};

// Chargement des valeurs pour un type
const fetchValues = async () => {
  const selectedEntity = availableTypes.value.find(type => type.slug === selectedType.value);
  if (!selectedEntity || !selectedEntity.getValuesUrl) {
    console.warn("Aucun URL de valeurs pour le type sélectionné :", selectedType.value);
    return;
  }

  try {
    console.log(`Fetching values for type: ${selectedType.value}`);
    const response = await fetch(selectedEntity.getValuesUrl);
    if (!response.ok) throw new Error("Erreur réseau lors de la récupération des valeurs");
    values.value = await response.json();
    console.log("Fetched values:", values.value);

    // Assurer que la valeur sélectionnée est toujours dans la liste
    if (selectedValue.value) {
      const matchingValue = values.value.find(value => value.id === selectedValue.value);
      if (!matchingValue) {
        console.warn("Valeur sélectionnée introuvable dans la liste des valeurs :", selectedValue.value);
        selectedValue.value = null;
      }
    }
  } catch (error) {
    console.error("Erreur lors de la récupération des valeurs :", error);
  }
};

// Gestion du changement de type
const handleTypeChange = () => {
  if (selectedType.value === "custom_link") {
    selectedValue.value = null;
    emitCustomLink();
  } else {
    fetchValues();
  }
};

// Émission des données pour un lien libre
const emitCustomLink = () => {
  emit("update:modelValue", {
    type: "custom_link",
    value: {
      name: customLinkLabel.value,
      href: customLink.value
    }
  });
};

// Synchronisation des données avec le parent
watch([selectedType, selectedValue], ([newType, newValue]) => {
  if (newType !== "custom_link") {
    emit("update:modelValue", { type: newType, value: newValue });
  }
});

// Initialisation
onMounted(() => {
  fetchTypes();
});
</script>

<style scoped>
.entity-selector {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.type-selector,
.value-selector,
.custom-link {
  display: flex;
  flex-direction: column;
}

.autocomplete-input,
.custom-link-input {
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
