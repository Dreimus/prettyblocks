import { BlockContent } from "../entities/BlockContent";
import { CannotFindComponentError } from "../errors/CannotFindComponentError";

export const deleteBlockById = (zoneStore, blockId: string) => {
  const blockIndex = zoneStore.content.findIndex(
    (block: BlockContent) => block.id === blockId
  );
  if (blockIndex < 0) {
    throw CannotFindComponentError(blockId, "zone");
  }
  const newArray = zoneStore.content.toSpliced(blockIndex, 1);
  zoneStore.content = newArray;
};
