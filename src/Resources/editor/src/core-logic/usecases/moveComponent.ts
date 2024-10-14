import { CannotFindComponentError } from "../errors/CannotFindComponentError";
import { ComponentContent } from "../entities/ComponentContent";
import { OperationNotAllowedError } from "../errors/OperationNotAllowedError";
import { Repeater } from "../entities/Repeater";
import { findComponentById } from "../utils/finder";

export const moveComponent = (
  zoneStore,
  componentId: string,
  newIndex: number
) => {
  const foundComponent = findComponentById(zoneStore.content, componentId);
  if (!foundComponent) throw CannotFindComponentError(componentId);
  if (
    (foundComponent.parent as Repeater<ComponentContent> | ComponentContent)
      .type !== "repeater"
  )
    throw OperationNotAllowedError(
      "Move component",
      "Cannot move component that is not repeated"
    );
  const parent = foundComponent.parent as Repeater<ComponentContent>;
  const fromIndex = parent.sub_elements.findIndex(
    (component) => component.id === componentId
  );
  var element = parent.sub_elements[fromIndex];
  parent.sub_elements.splice(fromIndex, 1);
  parent.sub_elements.splice(newIndex, 0, element);
};
