import type {FieldContent} from "./ComponentContent";

export type BlockContent = {
  id: string;
  block_id: string;
  fields: FieldContent[];
  label: string;
  type: "block";
};
