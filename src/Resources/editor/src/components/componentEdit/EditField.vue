<template>
  <div>
    <div
      v-if="field.type === 'component'"
      @click="switchComponent"
      class="componentLink"
    >
      {{ field.label }}
    </div>
    <div v-else-if="field.type === 'repeater'" class="repeaterField">
      {{ field.label }}
      <div
        v-if="field.sub_elements[0]?.type === 'component'"
        class="repeatedElements"
      >
        <div
          v-for="subfield in field.sub_elements"
          @click="switchComponentTo(subfield)"
          class="componentLink"
        >
          {{ subfield.label }}
        </div>
      </div>
      <div v-else-if="field.sub_elements[0]?.type" class="repeatedElements">
        <EditPrimitiveField
          v-for="subfield in field.sub_elements"
          :field="subfield as PrimitiveFieldContent<PrimitiveFieldType>"
        />
      </div>
      <div class="subfieldAdd" @click="() => addNewElement(field)">
        <Icon name="PlusIcon" />
        Ajouter un élément {{ field.label }}
      </div>
    </div>
    <div v-else>
      {{ field.label }}
      <EditPrimitiveField :field="field" />
    </div>
  </div>
</template>

<script setup lang="ts">
import {FieldContent} from "../../core-logic/entities/ComponentContent.js";
import {PrimitiveFieldType} from "../../core-logic/entities/ElementType.js";
import {PrimitiveFieldContent} from "../../core-logic/entities/PrimitiveFieldContent.js";
import {Repeater} from "../../core-logic/entities/Repeater.js";
import {useNavigationStore} from "../../core-logic/store/navigationStore.js";
import {useZoneStore} from "../../core-logic/store/zoneStore.js";
import {findComponentBlock} from "../../core-logic/utils/finder.js";
import Icon from "../Icon.vue";
import EditPrimitiveField from "./EditPrimitiveField.vue";

const { field } = defineProps<{
  field: FieldContent;
}>();

const zoneStore = useZoneStore();

const switchComponent = () => {
  useNavigationStore().selectElement(field);
};

const switchComponentTo = (newField: FieldContent) => {
  useNavigationStore().selectElement(newField);
};

const addNewElement = (element) => {
  const blockId = findComponentBlock(zoneStore.content, element.id).id;
  const componentId = (element as Repeater<FieldContent>).component_id;
  zoneStore.addComponent(blockId, element.id, componentId);
};
</script>

<style scoped lang="scss">
@import "../../assets/styles/vars";

.componentLink {
  background-color: $bg-hover-color;
  color: $primary-color;
  border-radius: 0.5rem;
  padding: 0.75rem 1rem;
  cursor: pointer;
}

.subfieldAdd {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1rem;
  background: $bg-hover-color;
  color: $primary-color;
  border-radius: 0.5rem;
  cursor: pointer;
  &:hover {
    background-color: $bg-secondary-color;
    color: $secondary-color;
  }
}

.repeaterField,
.repeatedElements {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}
</style>
