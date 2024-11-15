import type {ComponentStructure} from "./ComponentStructure";
import type {PrimitiveFieldStructure} from "./PrimitiveFieldStructure";
import {PrimitiveFieldType} from "./ElementType";

export type BlockStructure = {
  id: string;
  block_id: string;
  label: string;
  slug: string;
  fields: Record<string, BlockFieldStructure>;
};

type BlockFieldStructure =
  | ComponentStructure
  | PrimitiveFieldStructure<PrimitiveFieldType>;
