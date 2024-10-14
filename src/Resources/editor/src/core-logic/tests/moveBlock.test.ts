import type {BlockContent} from "../entities/BlockContent";
import {CannotFindComponentError} from "../errors/CannotFindComponentError";
import {PrimitiveFieldType} from "../entities/ElementType";
import {createTestingPinia} from "@pinia/testing";
import {setActivePinia} from "pinia";
import {useZoneStore} from "../store/zoneStore";

const newColumnBlock: BlockContent = {
  id: "columnBlock",
  type: "block",
  block_id: "columnBlock",
  label: "Column Block",
  fields: [
    {
      id: "some_random_id",
      structureId: "columnBlockTitle",
      type: "text" as PrimitiveFieldType.TEXT,
      label: "Column block title",
      content: {
        value: "Column title",
      },
    },
    {
      id: "some_random_id",
      component_id: "banner",
      type: "component",
      label: "Banner",
      fields: [
        {
          id: "some_random_id",
          structureId: "bannerImage",
          type: "text" as PrimitiveFieldType.TEXT,
          label: "Image",
          content: {
            value: "BannerImage",
          },
        },
        {
          id: "some_random_id",
          structureId: "bannerIntro",
          type: "text" as PrimitiveFieldType.TEXT,
          label: "Intro",
          content: {
            value: "Wonderful intro",
          },
        },
      ],
    },
    {
      id: "some_random_id",
      component_id: "column",
      type: "repeater",
      label: "Columns",
      sub_elements: [],
    },
  ],
};
const emptyBlockContent1: BlockContent = {
  id: "empty_block_content_1",
  type: "block",
  block_id: "emptyBlock",
  label: "Empty Block",
  fields: [],
};

const emptyBlockContent2: BlockContent = {
  id: "empty_block_content_2",
  type: "block",
  block_id: "emptyBlock",
  label: "Empty Block",
  fields: [],
};

describe("Move Block", () => {
  beforeEach(() => {
    const pinia = createTestingPinia({
      initialState: {
        zone: {
          content: [newColumnBlock, emptyBlockContent1, emptyBlockContent2],
        },
      },
      stubActions: false,
    });
    setActivePinia(pinia);
  });

  it("moves block to given position", () => {
    const zoneStore = useZoneStore();
    expect(zoneStore.content[0].block_id).toBe("columnBlock");
    expect(zoneStore.content[1].block_id).toBe("emptyBlock");
    zoneStore.moveBlock("columnBlock", 1);
    expect(zoneStore.content[1].block_id).toBe("columnBlock");
  });

  it("keeps block content", () => {
    const zoneStore = useZoneStore();
    zoneStore.moveBlock("columnBlock", 1);
    expect(zoneStore.content[1]).toEqual(newColumnBlock);
  });

  it("keeps other blocks in the right order", () => {
    const zoneStore = useZoneStore();
    zoneStore.moveBlock("columnBlock", 1);
    expect(zoneStore.content[0]).toEqual(emptyBlockContent1);
    expect(zoneStore.content[2]).toEqual(emptyBlockContent2);
  });

  it("throws error when block does not exist", () => {
    const zoneStore = useZoneStore();
    const move = () => zoneStore.moveBlock("undefinedId", 1);
    expect(move).toThrow(CannotFindComponentError("undefinedId", "zone"));
  });
});
