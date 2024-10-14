import {BlockContent} from "./BlockContent";
import {BlockStructure} from "./BlockStructure";

export type ZoneState = {
  availableBlocks: BlockStructure[];
  content: BlockContent[];
};
