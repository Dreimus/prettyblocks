import {ComponentContent, FieldContent} from "../entities/ComponentContent";

import {BlockContent} from "../entities/BlockContent";
import {BlockStructure} from "../entities/BlockStructure";
import {ComponentStructure} from "../entities/ComponentStructure";
import {Repeater} from "../entities/Repeater";

export type SearchComponentResult = {
  parent?: BlockContent | ComponentContent | Repeater<FieldContent>;
  node: BlockContent | FieldContent;
};

export const findComponentBlock = (
  content: BlockContent[],
  componentId: string
) => {
  for (const block of content) {
    const foundComponent = findComponentByIdInBlock(block, componentId);
    if (foundComponent) return block;
  }
};

export const findComponentById = (
  content: BlockContent[],
  componentId: string
) => {
  for (const block of content) {
    const foundComponent = findComponentByIdInBlock(block, componentId);
    if (foundComponent) return foundComponent;
  }
};

export const findComponentByIdInBlock = (
  tree: BlockContent | ComponentContent,
  id: string
): SearchComponentResult => {
  // Check if block is searched id
  if (tree.id === id) return { node: tree };
  // Check if one of the current node fields matches the id
  const foundField = tree.fields.find((field) => field.id === id);
  if (foundField) return { node: foundField, parent: tree };
  // Check all subfields
  return findComponentByIdInSubfields(tree, id);
};

export const findComponentByIdInSubfields = (
  tree: BlockContent | ComponentContent,
  id: string
) => {
  // Check all repeater subfields
  const foundField = findComponentByIdInRepeaterFields(tree, id);
  if (foundField) return foundField;
  // Check fields recursively
  const componentsFields: ComponentContent[] = tree.fields.filter(
    (field) => field.type === "component"
  ) as ComponentContent[];
  for (const field of componentsFields) {
    const foundElement = findComponentByIdInBlock(field, id);
    if (foundElement) return foundElement;
  }
};

const findComponentByIdInRepeaterFields = (
  tree: BlockContent | ComponentContent,
  id: string
) => {
  const repeaterFields: Repeater<ComponentContent>[] = tree.fields.filter(
    (field) => field.type === "repeater"
  ) as Repeater<ComponentContent>[];
  for (const repeater of repeaterFields) {
    const foundElement = findComponentByIdInRepeater(repeater, id);
    if (foundElement) return foundElement;
  }
};

export const findComponentByIdInRepeater = (
  repeater: Repeater<FieldContent>,
  id: string
) => {
  for (const field of repeater.sub_elements) {
    // Check if subfield matches
    if (field.id === id) return { node: field, parent: repeater };
    // Else check recursively
    const foundElement = findComponentByIdInBlock(
      field as ComponentContent,
      id
    );
    if (foundElement) return foundElement;
  }
};

export const findComponentStructure = (
  structure: BlockStructure | ComponentStructure,
  componentId: string
): ComponentStructure => {
  for (const field of Object.values(structure.fields)) {
    if (field.type !== "component") continue;

    if (field.id === componentId) return field;

    const result = findComponentStructure(field, componentId);
    if (result) return result;
  }
  return null;
};
