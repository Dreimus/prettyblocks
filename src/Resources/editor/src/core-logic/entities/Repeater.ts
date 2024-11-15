import {FieldContent} from "./ComponentContent";
import {ElementType} from "./ElementType";

export type Repeater<C extends FieldContent> = {
  id: string;
  component_id: string;
  type: ElementType.REPEATER_TYPE;
  label: string;
  sub_elements: C[];
  optional?: boolean;
  hidden?: boolean;
};
