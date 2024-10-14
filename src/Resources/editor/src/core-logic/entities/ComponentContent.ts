import {type COMPONENT_TYPE, PrimitiveFieldType} from "./ElementType";

import type {PrimitiveFieldContent} from "./PrimitiveFieldContent";
import type {Repeater} from "./Repeater";

export type FieldContent =
  | ComponentContent
  | PrimitiveFieldContent<PrimitiveFieldType>
  | Repeater<ComponentContent | PrimitiveFieldContent<PrimitiveFieldType>>;

export type ComponentContent = {
  id: string;
  component_id: string;
  type: COMPONENT_TYPE;
  label: string;
  optional?: boolean;
  hidden?: boolean;
  fields: FieldContent[];
};
