<template>
  <div class="tree">
    <div class="zone-selector">
      <label for="zone-select" class="zone-selector__label">Choix de zone</label>
      <select id="zone-select" class="zone-selector__select" @change="changeZone">
        <option v-for="zone in availableZones" :key="zone.id" :value="zone.id">
          {{ zone.label }}
        </option>
      </select>
    </div>
    <hr/>

    <draggable
      :list="content"
      group="blocks"
      class="tree__blocks"
      item-key="id"
      :move="handleMove"
      @end="handleDrop"
    >
      <template #item="{ element }">
        <Element
          :element="element"
          :level="0"
          :children="element.fields"
          :isDeletable="true"
          :isMovable="true"
          :isDuplicable="true"
          :move="handleMove"
          @end="handleDrop"
          class="tree-element"
        />
      </template>
    </draggable>
    <div class="blockAdd" @click="addNewBlock">
      <Icon name="PlusIcon" />
      Ajouter un bloc
    </div>
  </div>
</template>

<script setup lang="ts">
import {useZoneStore} from "../../core-logic/store/zoneStore";
import {storeToRefs} from "pinia";
import Element from "./Element.vue";
import {ref} from "vue";
import draggable from "vuedraggable";
import Icon from "../Icon.vue";
import emitter from "tiny-emitter/instance";
import {fetchAvailableZones} from "../../core-logic/usecases/fetchAvailableZones";

const zoneStore = useZoneStore();

const { content, selectedZoneId, availableZones } = storeToRefs(zoneStore);

const lastMoveEvent = ref(null);
function changeZone(event) {
  console.log("Changing zone to", event.target.value);
  zoneStore.setZone(event.target.value);

}

const handleMove = (moveEvent) => {
  lastMoveEvent.value = moveEvent;
  document
    .querySelectorAll(".tree-element")
    .forEach((treeElement) =>
      treeElement.classList.remove("place-after", "place-before")
    );
  moveEvent.related.classList.add(
    moveEvent.willInsertAfter ? "place-after" : "place-before"
  );
  return false;
};

const handleDrop = () => {
  document
    .querySelectorAll(".tree-element")
    .forEach((treeElement) =>
      treeElement.classList.remove("place-after", "place-before")
    );
  if (!lastMoveEvent.value) return;
  zoneStore.moveBlock(
    lastMoveEvent.value.draggedContext.element.id,
    lastMoveEvent.value.draggedContext.futureIndex
  );
  lastMoveEvent.value = null;
};

const addNewBlock = () => {
  emitter.emit("toggleAddBlockModal");
};
</script>

<style scoped lang="scss">
@import "../../assets/styles/vars";

.tree {
  min-width: 25rem;
  box-shadow: inset -0.5rem 0 0.5rem -0.3rem $bg-hover-color;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  overflow-y: auto;
}

.zone-selector {
  display: flex;
  flex-direction: column;
  padding: 1rem;
  background: $bg-hover-color;
  &__label {
    font-size: 1.25rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
  }
  &__select {
    padding: 0.5rem;
    border-radius: 0.5rem;
  }
}

.zone-select {
  width: 100%;
  padding: 0.5rem;
  border-radius: 0.5rem;
  display: flex;
}

.blockAdd {
  margin: 0 1rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1rem;
  background: $bg-hover-color;
  color: $primary-color;
  border-radius: 0.5rem;
  &:hover {
    background-color: $bg-secondary-color;
    color: $secondary-color;
  }
}

.dragging {
  background-color: $bg-hover-color;
}

.place-before::before,
.place-after::after {
  content: "";
  display: block;
  width: 100%;
  margin: auto;
  height: 2.5rem;
  border: 1px dashed $bg-secondary-color;
  border-radius: 0.5rem;
}
</style>
