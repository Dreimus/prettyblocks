import { ComponentContent, FieldContent } from "../entities/ComponentContent";

import { CannotFindComponentError } from "../errors/CannotFindComponentError";
import { OperationNotAllowedError } from "../errors/OperationNotAllowedError";
import { PrimitiveFieldContent } from "../entities/PrimitiveFieldContent";
import { PrimitiveFieldType } from "../entities/ElementType";
import { findComponentById } from "../utils/finder";

export const toggleComponent = (zoneStore, componentId: string) => {
  const foundComponent = findComponentById(zoneStore.content, componentId);
  if (!foundComponent) throw CannotFindComponentError(componentId);
  const foundComponentNode = foundComponent.node as
    | ComponentContent
    | PrimitiveFieldContent<PrimitiveFieldType>;
  if (!foundComponentNode.optional)
    throw OperationNotAllowedError(
      "Hide / Show component",
      "Hiding component is only allowed on optional components"
    );
  foundComponentNode.hidden = !foundComponentNode.hidden;
};
