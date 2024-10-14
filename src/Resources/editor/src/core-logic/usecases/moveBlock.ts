import { BlockContent } from "../entities/BlockContent";
import { CannotFindComponentError } from "../errors/CannotFindComponentError";

export const moveBlock = (zoneStore, blockId: string, newIndex: number) => {
  const blockIndex = zoneStore.content.findIndex(
    (block: BlockContent) => block.id === blockId
  );
  if (blockIndex < 0) {
    throw CannotFindComponentError(blockId);
  }
  const movedBlock = zoneStore.content[blockIndex];
  const newArray = zoneStore.content.toSpliced(blockIndex, 1);
  newArray.splice(newIndex, 0, movedBlock);
  zoneStore.content = newArray;
};
