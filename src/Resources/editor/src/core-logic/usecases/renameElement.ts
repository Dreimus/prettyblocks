import { CannotFindComponentError } from "../errors/CannotFindComponentError";
import { findComponentById } from "../utils/finder";

export const renameElement = (
  zoneStore,
  elementId: string,
  newLabel: string
) => {
  const block = zoneStore.content.find((block) => block.id === elementId);
  if (block) {
    block.label = newLabel;
  }
  const foundComponent = findComponentById(zoneStore.content, elementId);
  if (!foundComponent) throw CannotFindComponentError(elementId);
  foundComponent.node.label = newLabel;
};
