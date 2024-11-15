import type {FieldContent} from "./ComponentContent";
import {ElementType} from "./ElementType";

export type BlockContent = {
  id: string;
  block_id: string;
  fields: FieldContent[];
  slug: string;
  label: string;
  type: ElementType.BLOCK_TYPE;
};
