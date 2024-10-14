import {findComponentByIdInBlock, findComponentStructure,} from "../utils/finder";

import type {BlockContent} from "../entities/BlockContent";
import type {BlockStructure} from "../entities/BlockStructure";
import columnStructure from "./columnStructure.json";
import filledColumnContent from "./filledColumnContentWithId.json";

describe("Component finder", () => {
  let blockContent: BlockContent;
  let blockStructure: BlockStructure;

  beforeAll(() => {
    blockContent = filledColumnContent as BlockContent;
    blockStructure = columnStructure as BlockStructure;
  });

  it("finds block id", () => {
    const component = findComponentByIdInBlock(blockContent, "block_id");
    expect(component.node.id).toEqual("block_id");
    expect(component.parent).toBeUndefined();
  });

  it("finds a component", () => {
    const component = findComponentByIdInBlock(blockContent, "field_0");
    expect(component.node.id).toEqual("field_0");
  });

  it("gives block id as parent for 1st level component search", () => {
    const component = findComponentByIdInBlock(blockContent, "field_0");
    expect(component.parent?.id).toEqual("block_id");
  });

  it("finds a repeatable component", () => {
    const component = findComponentByIdInBlock(blockContent, "field_2_0");
    expect(component.node.id).toEqual("field_2_0");
  });

  it("gives repeater id as parent for repeated component search", () => {
    const component = findComponentByIdInBlock(blockContent, "field_2_0");
    expect(component.parent?.id).toEqual("field_2");
  });

  it("finds a recursively nested component", () => {
    const component = findComponentByIdInBlock(blockContent, "field_2_1_1_0_0");
    expect(component.node.id).toEqual("field_2_1_1_0_0");
    const secondComponent = findComponentByIdInBlock(blockContent, "field_1_1");
    expect(secondComponent.node.id).toEqual("field_1_1");
    const thirdComponent = findComponentByIdInBlock(blockContent, "field_1_0");
    expect(thirdComponent.node.id).toEqual("field_1_0");
  });

  it("gives right repeater id as parent for nested component search", () => {
    const component = findComponentByIdInBlock(blockContent, "field_2_1_1_0_0");
    expect(component.parent?.id).toEqual("field_2_1_1_0");
  });

  it("finds a 1st level component structure", () => {
    const componentStructure = findComponentStructure(blockStructure, "banner");
    expect(componentStructure.label).toEqual("Banner");
  });

  it("finds a repeated nested component structure", () => {
    const componentStructure = findComponentStructure(blockStructure, "card");
    expect(componentStructure.label).toEqual("Cards");
  });
});
