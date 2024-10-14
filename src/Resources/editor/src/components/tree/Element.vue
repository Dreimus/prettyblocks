<template>
  <div class="element">
    <div
      class="elementName"
      :class="{ hidden: (element as FieldContent).hidden, selectedElement: isSelected }"
    >
      <span class="elementDropdownArrow" @click="toggleCollapse">
        <Icon
          name="ChevronRightIcon"
          v-if="
            (element.type === 'repeater' || children.length > 0) && isCollapsed
          "
        />
        <Icon
          name="ChevronDownIcon"
          v-else-if="
            (element.type === 'repeater' || children.length > 0) && !isCollapsed
          "
        />
      </span>
      <span class="elementIcon"></span>
      <span class="elementLabelInput" v-if="renameState">
        <input
          type="text"
          @change="renameElement"
          @focusout="renameState = false"
          @keyup.enter="renameElement"
          :value="element.label"
          ref="inputRef"
          class="labelInput"
        />
      </span>
      <span
        class="elementLabel"
        v-else
        @click="selectElement"
        @dblclick="editElementLabel"
      >
        {{ element.label }}
      </span>
      <span class="elementActions">
        <span v-if="isDuplicable" @click="duplicateElement"
          ><Icon name="DocumentDuplicateIcon"
        /></span>
        <span @click="editElementLabel"><Icon name="PencilIcon" /></span>
        <span v-if="isDeletable" @click="deleteElement"
          ><Icon name="TrashIcon"
        /></span>
        <span
          v-if="(element as ComponentContent | PrimitiveFieldContent<PrimitiveFieldType>).optional"
          @click="toggleElement"
        >
          <Icon
            :name="(element as ComponentContent | PrimitiveFieldContent<PrimitiveFieldType>).hidden ? 'EyeSlashIcon' : 'EyeIcon'"
          />
        </span>
      </span>
    </div>
    <Subfields
      v-if="!isCollapsed"
      :fields="children"
      :parentElement="element"
    />
  </div>
</template>

<script setup lang="ts">
import {BlockContent} from "../../core-logic/entities/BlockContent";
import {ComponentContent, FieldContent,} from "../../core-logic/entities/ComponentContent";
import {useZoneStore} from "../../core-logic/store/zoneStore.js";
import {computed, nextTick, onMounted, ref, watch} from "vue";
import Subfields from "./Subfields.vue";
import Icon from "../Icon.vue";
import {PrimitiveFieldType} from "../../core-logic/entities/ElementType";
import {PrimitiveFieldContent} from "../../core-logic/entities/PrimitiveFieldContent";
import {useNavigationStore} from "../../core-logic/store/navigationStore";
import {storeToRefs} from "pinia";
import {
  findComponentByIdInRepeater,
  findComponentByIdInSubfields,
  SearchComponentResult,
} from "../../core-logic/utils/finder";
import {Repeater} from "../../core-logic/entities/Repeater";

const { element, children, isDeletable, isMovable, isDuplicable } =
  defineProps<{
    element: BlockContent | FieldContent;
    children: FieldContent[];
    isDeletable: boolean;
    isMovable: boolean;
    isDuplicable: boolean;
  }>();

const zoneStore = useZoneStore();
const navigationStore = useNavigationStore();
const renameState = ref(false);
const inputRef = ref(null);
const isCollapsed = ref(true);
const { selectedElement } = storeToRefs(navigationStore);

const isSelected = computed(() => selectedElement.value?.id === element.id);

const checkToggle = () => {
  let foundComponent: SearchComponentResult;
  if (element.type === "repeater")
    foundComponent = findComponentByIdInRepeater(
      element as Repeater<FieldContent>,
      selectedElement.value?.id
    );
  if (element.type === "component" || element.type === "block")
    foundComponent = findComponentByIdInSubfields(
      element as BlockContent | ComponentContent,
      selectedElement.value?.id
    );
  if (foundComponent) {
    isCollapsed.value = false;
  }
};

watch(selectedElement, checkToggle);
onMounted(checkToggle);

const deleteMap = {
  block: zoneStore.deleteBlockById,
  component: zoneStore.deleteComponentById,
};

const deleteElement = () => {
  if (isDeletable) {
    deleteMap[element.type](element.id);
  }
};

const editElementLabel = async () => {
  renameState.value = true;
  nextTick(() => inputRef.value.focus());
};

const renameElement = (event) => {
  zoneStore.renameElement(element.id, event.target.value);
  renameState.value = false;
};

const toggleCollapse = () => {
  isCollapsed.value = !isCollapsed.value;
};

const toggleElement = () => {
  zoneStore.toggleElement(element.id);
};

const duplicateElement = () => {
  zoneStore.duplicateElement(element.id);
};

const selectElement = () => {
  useNavigationStore().selectElement(element);
};
</script>

<style scoped lang="scss">
@import "../../assets/styles/vars";

.element {
  color: $primary-color;
}
.elementName {
  display: flex;
  align-items: center;
  padding: 0.5rem 1rem;
  &:hover {
    background-color: $bg-hover-color;
    > .elementActions {
      display: flex;
    }
    > .dragAndDropIcon {
      visibility: visible;
    }
  }
}

.hidden {
  color: $disabled-color;
}

.elementLabel {
  cursor: pointer;
}

.elementDropdownArrow {
  cursor: pointer;
}

.elementActions {
  display: none;
  margin-left: auto;
  gap: 0.5rem;
  span {
    cursor: pointer;
  }
}

.elementDropdownArrow,
.dragAndDropIcon {
  width: 1.5rem;
}

.dragAndDropIcon {
  visibility: hidden;
  cursor: move;
}

.elementLabel {
  flex: 1;
}

.elementLabelInput {
  flex: 1;
}

.labelInput {
  padding: 0.25rem 0.5rem;
  margin-right: 0.5rem;
  width: 100%;
  border-radius: 0.5rem;
  &:focus {
    border: 2px solid $primary-color;
    box-shadow: none;
  }
}

.selectedElement .elementLabel {
  font-weight: bold;
}
</style>
