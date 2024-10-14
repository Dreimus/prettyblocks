<template>
  <Collapsable>
    <template v-slot:header="props">
      <div
        :class="[
          'menu-item flex items-center px-2 py-1 mb-1 rounded-md hover:bg-gray-100 border-2 border-transparent cursor-pointer',
          { selected: isSelected },
        ]"
        @click="select"
      >
        <div :class="['flex items-center flex-grow pr-2', { disabled }]">
          <Icon :name="element.formatted.icon" class="h-5 w-5 mr-2"></Icon>
          <p
            class="flex-grow w-0 text-ellipsis whitespace-nowrap overflow-hidden select-none"
          >
            {{ element.formatted.title }}
          </p>
        </div>
        <div
          class="cursor-pointer mr-2"
          @click="props.collapse"
          v-if="repeatableField"
        >
          <Icon name="ChevronRightIcon" v-if="props.isCollapsed" />
          <Icon name="ChevronDownIcon" v-else />
        </div>
      </div>
    </template>
    <template v-slot:content>
      <ButtonLight
        v-if="repeatableField"
        icon="PlusCircleIcon"
        @click.prevent="addNewSubItem()"
        class="px-2 py-2 mb-1 rounded-md hover:bg-indigo hover:bg-opacity-10 w-full text-indigo"
      >
        {{ trans("add_new_element") }}
      </ButtonLight>
    </template>
  </Collapsable>
</template>

<script setup>
import {computed, defineEmits} from "vue";
import {useStore} from "../store/currentBlock";
import ButtonLight from "./ButtonLight.vue";
import Collapsable from "./Collapsable.vue";
import Icon from "./Icon.vue";
import {trans} from "../scripts/trans";

const props = defineProps({
  element: Object,
});

const emit = defineEmits(["pushEmptyState"]);

const store = useStore();

const repeatableField = computed(() => {
  return Object.values(props.element.config.fields).find(
    (field) => field.type === "repeater"
  );
});

const isSelected = computed(
  () => props.element.formatted.id == store.subSelected
);

function select() {
  setSelectedElement(props.element.formatted.id);
}

function setSelectedElement(notFormattedId) {
  let id = notFormattedId;
  store.$patch({
    id_prettyblocks: parseInt(id.split("-")[0]),
    subSelected: id,
  });
}

const addNewSubItem = () => {
  // ! Error handling, cannot add subitem because no repeater field found
  if (!repeatableField) return;
  emit("pushEmptyState", repeatableField.value);
};
</script>

<style scoped>
.menu-item.selected {
  @apply bg-indigo bg-opacity-10 text-indigo;
}

.menu-item .disabled {
  @apply transition duration-200;
  @apply opacity-70;
}

.menu-item:hover > .menu-item-actions {
  @apply w-auto;
}
</style>
