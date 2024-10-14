import { CannotFindComponentError } from "../errors/CannotFindComponentError";
import { ComponentContent } from "../entities/ComponentContent";
import { OperationNotAllowedError } from "../errors/OperationNotAllowedError";
import { Repeater } from "../entities/Repeater";
import { findComponentById } from "../utils/finder";

export const deleteComponentById = (zoneStore, componentId: string) => {
  const foundComponent = findComponentById(zoneStore.content, componentId);
  if (!foundComponent) {
    throw CannotFindComponentError(componentId);
  }
  if (
    !(foundComponent.node as ComponentContent).optional &&
    (foundComponent.parent as ComponentContent | Repeater<ComponentContent>)
      ?.type !== "repeater"
  ) {
    throw OperationNotAllowedError(
      "Delete component",
      "Non repeated and non optional components cannot be deleted"
    );
  }
  if (
    (foundComponent.parent as ComponentContent | Repeater<ComponentContent>)
      .type === "component"
  ) {
    const componentIndex = (
      foundComponent.parent as ComponentContent
    ).fields.findIndex((field) => field.id === componentId);
    const newFields = (
      foundComponent.parent as ComponentContent
    ).fields.toSpliced(componentIndex, 1);
    (foundComponent.parent as ComponentContent).fields = newFields;
  } else {
    const componentIndex = (
      foundComponent.parent as Repeater<ComponentContent>
    ).sub_elements.findIndex((field) => field.id === componentId);
    const newElements = (
      foundComponent.parent as Repeater<ComponentContent>
    ).sub_elements.toSpliced(componentIndex, 1);
    (foundComponent.parent as Repeater<ComponentContent>).sub_elements =
      newElements;
  }
};
