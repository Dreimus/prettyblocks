import {
  PrimitiveFieldContent,
  PrimitiveFieldContentMap,
} from "../entities/PrimitiveFieldContent";

import { CannotFindComponentError } from "../errors/CannotFindComponentError";
import { PrimitiveFieldType } from "../entities/ElementType";
import { findComponentById } from "../utils/finder";

export const editPrimitiveField = <T extends PrimitiveFieldType>(
  zoneStore,
  fieldId: string,
  newValue: PrimitiveFieldContentMap[T]
) => {
  const foundElement = findComponentById(zoneStore.content, fieldId);
  if (!foundElement) {
    throw CannotFindComponentError(fieldId);
  }
  (foundElement.node as PrimitiveFieldContent<T>).content = newValue;
};
