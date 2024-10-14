import { ComponentContent, FieldContent } from "../entities/ComponentContent";
import {
  findComponentByIdInBlock,
  findComponentStructure,
} from "../utils/finder";

import { BlockContent } from "../entities/BlockContent";
import { BlockStructure } from "../entities/BlockStructure";
import { CannotFindComponentError } from "../errors/CannotFindComponentError";
import { CannotFindStructureError } from "../errors/CannotFindStructureError";
import { ComponentStructure } from "../entities/ComponentStructure";
import { Repeater } from "../entities/Repeater";
import { buildNewSingleComponentFromStructure } from "../utils/builder";

export const addComponent = (
  zoneStore,
  blockId: string,
  rootId: string,
  componentStructureId: string
) => {
  //! NOTE: Since components are added inside repeaters, we could infer componentStructureId from the repeater structure
  //! BUT I decided to keep componentStructureId as parameter since we could imagine repeaters with multiple available components inside (i.e. Slider with images and/or videos)
  const blockIndex = zoneStore.content.findIndex(
    (block: BlockContent) => block.id === blockId
  );
  if (blockIndex < 0) throw CannotFindComponentError(blockId, "zone");
  const blockContent: BlockContent = zoneStore.content[blockIndex];
  const blockStructure: BlockStructure = zoneStore.getBlockStructure(
    blockContent.block_id
  );
  if (!blockStructure) {
    throw CannotFindStructureError(blockId);
  }
  const componentStructure: ComponentStructure = findComponentStructure(
    blockStructure,
    componentStructureId
  );
  if (!componentStructure) {
    throw CannotFindStructureError(componentStructureId);
  }
  const componentContent: ComponentContent | Repeater<ComponentContent> =
    buildNewSingleComponentFromStructure(componentStructure);
  insertNewComponent(blockContent, componentContent, rootId);
};

const insertNewComponent = (
  content: BlockContent | ComponentContent,
  newComponentContent: ComponentContent,
  rootId: string
) => {
  const foundComponent = findComponentByIdInBlock(content, rootId);
  if (!foundComponent) {
    throw CannotFindComponentError(rootId, content.id);
  }
  if ((foundComponent.node as FieldContent).type !== "repeater")
    throw new Error("Cannot insert component into non repeater parent");
  (foundComponent.node as Repeater<ComponentContent>).sub_elements.push(
    newComponentContent
  );
};
