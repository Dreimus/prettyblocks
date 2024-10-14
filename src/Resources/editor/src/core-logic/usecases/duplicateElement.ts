import { CannotFindComponentError } from "../errors/CannotFindComponentError";
import { OperationNotAllowedError } from "../errors/OperationNotAllowedError";
import { findComponentById } from "../utils/finder";
import { v4 as uuidv4 } from "uuid";

function deepCopy(obj) {
  return Object.keys(obj).reduce((v, d) => {
    if (obj[d].constructor === Object)
      return Object.assign(v, { [d]: deepCopy(obj[d]) });
    else if (d === "fields" || d === "sub_elements") {
      return Object.assign(v, { [d]: obj[d].map(deepCopy) });
    } else return Object.assign(v, { [d]: d === "id" ? uuidv4() : obj[d] });
  }, {});
}

export const duplicateElement = (zoneStore, elementId: string) => {
  const block = zoneStore.content.find((block) => block.id === elementId);
  if (block) {
    return zoneStore.content.push(deepCopy(block));
  }
  const foundComponent = findComponentById(zoneStore.content, elementId);
  if (!foundComponent) throw CannotFindComponentError(elementId);
  if (foundComponent.parent?.type !== "repeater")
    throw OperationNotAllowedError(
      "Duplicate element",
      "Only repeated elements or blocks can be duplicated"
    );
  foundComponent.parent.sub_elements.push(deepCopy(foundComponent.node));
};
