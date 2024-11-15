import {ElementType, PrimitiveFieldType} from "./ElementType";

import {PrimitiveFieldStructure} from "./PrimitiveFieldStructure";

export type ComponentStructure = {
  id: string;
  type: ElementType.COMPONENT_TYPE;
  label: string;
  fields: Record<string, ComponentFieldStructure>;
  repeatable?: boolean;
  optional?: boolean;
};

export type ComponentFieldStructure =
  | ComponentStructure
  | PrimitiveFieldStructure<PrimitiveFieldType>;
