import {PrimitiveFieldContentMap} from "./PrimitiveFieldContent";
import {PrimitiveFieldType} from "./ElementType";

export type PrimitiveFieldStructure<T extends PrimitiveFieldType> = {
  id: string;
  label: string;
  slug: string;
  type: T;
  default: PrimitiveFieldContentMap[T];
  repeatable?: boolean;
  optional?: boolean;
};
