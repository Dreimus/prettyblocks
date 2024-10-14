<template>
  <component
    :is="componentMap[field.type]"
    :value="(field.content as PrimitiveFieldContentMap[PrimitiveFieldType.TEXT])"
    @update:modelValue="editField"
    class="primitiveFieldInput"
  />
</template>

<script setup lang="ts">
import {PrimitiveFieldType} from "../../core-logic/entities/ElementType";
import {PrimitiveFieldContent, PrimitiveFieldContentMap,} from "../../core-logic/entities/PrimitiveFieldContent";
import TextField from "./fields/TextField.vue";
import NumberField from "./fields/NumberField.vue";
import RangeField from "./fields/RangeField.vue";
import SelectField from "./fields/SelectField.vue";
import EmailField from "./fields/EmailField.vue";
import LinkField from "./fields/LinkField.vue";
import DateField from "./fields/DateField.vue";
import ColorField from "./fields/ColorField.vue";
import UrlField from "./fields/UrlField.vue";
import WysiwygField from "./fields/WysiwygField.vue";
import {useZoneStore} from "../../core-logic/store/zoneStore";
import SwitchField from "./fields/SwitchField.vue";

const { field } = defineProps<{
  field: PrimitiveFieldContent<PrimitiveFieldType>;
}>();
const zoneStore = useZoneStore();

const editField = (newContent: PrimitiveFieldContent<PrimitiveFieldType>) => {
  zoneStore.editPrimitiveField(field.id, newContent);
};

type ComponentMap<T extends PrimitiveFieldType> = {
  [K in T]: PrimitiveFieldContentMap[T];
};
const componentMap: ComponentMap<PrimitiveFieldType> = {
  [PrimitiveFieldType.TEXT]: TextField,
  [PrimitiveFieldType.NUMBER]: NumberField,
  [PrimitiveFieldType.RANGE]: RangeField,
  [PrimitiveFieldType.WYSIWYG]: WysiwygField,
  [PrimitiveFieldType.SWITCH]: SwitchField,
  [PrimitiveFieldType.SELECT]: SelectField,
  [PrimitiveFieldType.DATE]: DateField,
  [PrimitiveFieldType.COLOR]: ColorField,
  [PrimitiveFieldType.LINK]: LinkField,
  [PrimitiveFieldType.URL]: UrlField,
  [PrimitiveFieldType.EMAIL]: EmailField,
};
</script>

<style scoped lang="scss">
.primitiveFieldInput {
  width: 100%;
  max-width: 100%;
}
</style>
