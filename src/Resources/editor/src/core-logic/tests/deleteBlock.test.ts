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
  label: "Columns",
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
          structureId: "bannerTitle",
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

describe("Delete Block", () => {
  beforeEach(() => {
    const pinia = createTestingPinia({
      initialState: {
        zone: {
          content: [emptyBlockContent1, newColumnBlock, emptyBlockContent2],
        },
      },
      stubActions: false,
    });
    setActivePinia(pinia);
  });

  it("deletes specified block", () => {
    const zoneStore = useZoneStore();
    expect(zoneStore.content).toHaveLength(3);
    expect(zoneStore.content[1].block_id).toBe("columnBlock");
    zoneStore.deleteBlockById("columnBlock");
    expect(zoneStore.content).toHaveLength(2);
    expect(zoneStore.content[1].block_id).toBe("emptyBlock");
  });

  it("throws error if block is not found", () => {
    const zoneStore = useZoneStore();
    const failingDelete = () => zoneStore.deleteBlockById("undefinedId");
    expect(failingDelete).toThrow(
      CannotFindComponentError("undefinedId", "zone")
    );
  });
});
