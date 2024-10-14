import {BlockContent} from "../entities/BlockContent";
import {BlockStructure} from "../entities/BlockStructure";
import {buildNewBlockContentFromBlockStructure} from "../utils/builder";
// import { buildNewBlockContentFromBlockStructure } from "../utils/builder";

export const addBlock = (zoneStore, blockId: string) => {
  const blockStructure: BlockStructure = zoneStore.$state.availableBlocks.find(
    (block: BlockStructure) => block.id === blockId
  );
  if (!blockStructure) {
    // Error no structure found for block "BlockId"
    console.error("Error: No structure found for block " + blockId);
    return;
  }
  const blockContent: BlockContent =
    buildNewBlockContentFromBlockStructure(blockStructure);
  zoneStore.content.push(blockContent);
};
