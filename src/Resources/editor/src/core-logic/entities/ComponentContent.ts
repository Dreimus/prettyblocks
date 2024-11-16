import {ElementType, PrimitiveFieldType} from "./ElementType";

import type {PrimitiveFieldContent} from "./PrimitiveFieldContent";
import type {Repeater} from "./Repeater";

export type FieldContent =
  | ComponentContent
  | PrimitiveFieldContent<PrimitiveFieldType>
  | Repeater<ComponentContent | PrimitiveFieldContent<PrimitiveFieldType>>;

export type ComponentContent = {
  id: string;
  component_id: string;
  type: ElementType.COMPONENT_TYPE;
  label: string;
  slug: string;
  template: string;
  optional?: boolean;
  hidden?: boolean;
  fields: FieldContent[];
};
