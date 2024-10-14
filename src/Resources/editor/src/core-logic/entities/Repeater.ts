import {FieldContent} from "./ComponentContent";
import {REPEATER_TYPE} from "./ElementType";

export type Repeater<C extends FieldContent> = {
  id: string;
  component_id: string;
  type: REPEATER_TYPE;
  label: string;
  sub_elements: C[];
  optional?: boolean;
  hidden?: boolean;
};
