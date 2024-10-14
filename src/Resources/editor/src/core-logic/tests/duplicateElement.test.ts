import {ComponentContent, FieldContent} from "../entities/ComponentContent";

import type {BlockContent} from "../entities/BlockContent";
import {CannotFindComponentError} from "../errors/CannotFindComponentError";
import {OperationNotAllowedError} from "../errors/OperationNotAllowedError";
import {Repeater} from "../entities/Repeater";
import {createTestingPinia} from "@pinia/testing";
import {setActivePinia} from "pinia";
import {useZoneStore} from "../store/zoneStore";

const emptyBlockContent1: BlockContent = {
  id: "empty_block_content_1",
  type: "block",
  block_id: "emptyBlock",
  label: "Empty Block 1",
  fields: [],
};

const emptyBlockContent2: BlockContent = {
  id: "empty_block_content_2",
  type: "block",
  block_id: "emptyBlock",
  label: "Empty Block 2",
  fields: [],
};

describe("Duplicate Block", () => {
  beforeEach(() => {
    const pinia = createTestingPinia({
      initialState: {
        zone: {
          content: [emptyBlockContent1, emptyBlockContent2],
        },
      },
      stubActions: false,
    });
    setActivePinia(pinia);
  });

  it("duplicates selected block", () => {
    const zoneStore = useZoneStore();
    expect(zoneStore.content).toHaveLength(2);
    zoneStore.duplicateElement(emptyBlockContent1.id);
    expect(zoneStore.content).toHaveLength(3);
    expect(zoneStore.content[2].label).toBe(emptyBlockContent1.label);
  });

  it("changes block id", () => {
    const zoneStore = useZoneStore();
    expect(zoneStore.content).toHaveLength(2);
    zoneStore.duplicateElement(emptyBlockContent1.id);
    expect(zoneStore.content).toHaveLength(3);
    expect(zoneStore.content[2].id).not.toBe(emptyBlockContent1.id);
  });

  it("throws error if block is not found", () => {
    const zoneStore = useZoneStore();
    const failingDuplicate = () => zoneStore.duplicateElement("undefinedId");
    expect(failingDuplicate).toThrow(
      CannotFindComponentError("undefinedId", "zone")
    );
  });
});

describe("Duplicate element", () => {
  beforeEach(() => {
    const newColumnBlock: BlockContent = JSON.parse(`{
  "id": "block_id",
  "block_id": "columnBlock",
  "label": "column",
  "type": "block",
  "fields": [
    {
      "id": "field_0",
      "type": "text",
      "label": "Column block title",
      "optional": false,
      "hidden": false,
      "content": {
        "value": "Column title"
      }
    },
    {
      "id": "field_1",
      "component_id": "banner",
      "type": "component",
      "label": "Banner",
      "optional": false,
      "hidden": false,
      "fields": [
        {
          "id": "field_1_0",
          "type": "text",
          "label": "Image",
          "optional": true,
          "hidden": false,
          "content": {
            "value": "BannerImage"
          }
        },
        {
          "id": "field_1_1",
          "type": "text",
          "label": "Intro",
          "optional": false,
          "hidden": false,
          "content": {
            "value": "Wonderful intro"
          }
        }
      ]
    },
    {
      "id": "field_2",
      "component_id": "column",
      "type": "repeater",
      "label": "Columns",
      "optional": false,
      "hidden": false,
      "sub_elements": [
        {
          "id": "field_2_0",
          "component_id": "column",
          "type": "component",
          "label": "Columns-1",
          "optional": false,
          "hidden": false,
          "fields": [
            {
              "id": "field_2_0_0",
              "type": "text",
              "label": "Column title",
              "optional": false,
              "hidden": false,
              "content": {
                "value": "Titre de colonne"
              }
            },
            {
              "id": "field_2_0_1",
              "component_id": "card",
              "type": "repeater",
              "label": "Cards",
              "optional": false,
              "hidden": false,
              "sub_elements": [
                {
                  "id": "field_2_0_1_0",
                  "component_id": "card",
                  "type": "component",
                  "label": "Cards-1",
                  "optional": false,
                  "hidden": false,
                  "fields": [
                    {
                      "id": "field_2_0_1_0_0",
                      "type": "text",
                      "label": "Card title",
                      "optional": false,
                      "hidden": false,
                      "content": {
                        "value": "Titre de carte"
                      }
                    }
                  ]
                },
                {
                  "id": "field_2_0_1_1",
                  "component_id": "card",
                  "type": "component",
                  "label": "Cards-2",
                  "optional": false,
                  "hidden": false,
                  "fields": [
                    {
                      "id": "field_2_0_1_1_0",
                      "type": "text",
                      "label": "Card title",
                      "optional": false,
                      "hidden": false,
                      "content": {
                        "value": "Titre de carte"
                      }
                    }
                  ]
                }
              ]
            }
          ]
        },
        {
          "id": "field_2_1",
          "component_id": "column",
          "type": "component",
          "label": "Columns-2",
          "optional": false,
          "hidden": false,
          "fields": [
            {
              "id": "field_2_1_0",
              "type": "text",
              "label": "Column title",
              "optional": false,
              "hidden": false,
              "content": {
                "value": "Titre de colonne"
              }
            },
            {
              "id": "field_2_1_1",
              "component_id": "card",
              "type": "repeater",
              "label": "Cards",
              "optional": false,
              "hidden": false,
              "sub_elements": [
                {
                  "id": "field_2_1_1_0",
                  "component_id": "card",
                  "type": "component",
                  "label": "Cards-1",
                  "optional": false,
                  "hidden": false,
                  "fields": [
                    {
                      "id": "field_2_1_1_0_0",
                      "type": "text",
                      "label": "Card title",
                      "optional": false,
                      "hidden": false,
                      "content": {
                        "value": "Titre de carte"
                      }
                    }
                  ]
                },
                {
                  "id": "field_2_1_1_1",
                  "component_id": "card",
                  "type": "component",
                  "label": "Cards-2",
                  "optional": false,
                  "hidden": false,
                  "fields": [
                    {
                      "id": "field_2_1_1_1_0",
                      "type": "text",
                      "label": "Card title",
                      "optional": false,
                      "hidden": false,
                      "content": {
                        "value": "Titre de carte"
                      }
                    }
                  ]
                }
              ]
            }
          ]
        }
      ]
    }
  ]
}
`);
    const pinia = createTestingPinia({
      initialState: {
        zone: {
          content: [newColumnBlock],
        },
      },
      stubActions: false,
    });
    setActivePinia(pinia);
    useZoneStore().$patch({ content: [newColumnBlock] });
  });

  it("duplicates element", () => {
    const zoneStore = useZoneStore();
    zoneStore.duplicateElement("field_2_0");
    expect(
      (zoneStore.content[0].fields[2] as Repeater<FieldContent>).sub_elements[2]
        .label
    ).toBe("Columns-1");
  });

  it("duplicated sub_elements", () => {
    const zoneStore = useZoneStore();
    zoneStore.duplicateElement("field_2_0");
    expect(
      (
        (
          (zoneStore.content[0].fields[2] as Repeater<FieldContent>)
            .sub_elements[2] as ComponentContent
        ).fields[1] as Repeater<FieldContent>
      ).sub_elements[0].label
    ).toBe("Cards-1");
  });

  it("changes ids", () => {
    const zoneStore = useZoneStore();
    zoneStore.duplicateElement("field_2_0");
    expect(
      (zoneStore.content[0].fields[2] as Repeater<FieldContent>).sub_elements[2]
        .id
    ).not.toBe("field_2_0");
    expect(
      (
        (
          (zoneStore.content[0].fields[2] as Repeater<FieldContent>)
            .sub_elements[2] as ComponentContent
        ).fields[1] as Repeater<FieldContent>
      ).sub_elements[0].id
    ).not.toBe("field_2_0_1_0");
  });

  it("throws error when id is not found", () => {
    const zoneStore = useZoneStore();
    const failingDuplicate = () => zoneStore.duplicateElement("undefinedId");
    expect(failingDuplicate).toThrow(
      CannotFindComponentError("undefinedId", "zone")
    );
  });

  it("throws error when component is not repeatable", () => {
    const zoneStore = useZoneStore();
    const failingDuplicate = () => zoneStore.duplicateElement("field_2_0_0");
    expect(failingDuplicate).toThrow(
      OperationNotAllowedError(
        "Duplicate element",
        "Only repeated elements or blocks can be duplicated"
      )
    );
  });
});
