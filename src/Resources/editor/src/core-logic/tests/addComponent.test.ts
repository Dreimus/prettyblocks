import {BlockContent} from "../entities/BlockContent";
import {BlockStructure} from "../entities/BlockStructure";
import {CannotFindComponentError} from "../errors/CannotFindComponentError";
import {CannotFindStructureError} from "../errors/CannotFindStructureError";
import {ComponentContent} from "../entities/ComponentContent";
import {Repeater} from "../entities/Repeater";
import columnStructure from "./columnStructure.json";
import {createTestingPinia} from "@pinia/testing";
import newColumnContentWithId from "./newColumnContentWithId.json";
import oneColumnContentWithId from "./oneColumnContentWithId.json";
import {setActivePinia} from "pinia";
import {useZoneStore} from "../store/zoneStore";

describe("Add Component", () => {
  const newColumnBlock: BlockContent = newColumnContentWithId as BlockContent;
  const oneColumnBlock: BlockContent = oneColumnContentWithId as BlockContent;
  beforeEach(() => {
    const pinia = createTestingPinia({
      initialState: {
        zone: {
          availableBlocks: [columnStructure as BlockStructure],
          content: [newColumnBlock],
        },
      },
      stubActions: false,
    });
    setActivePinia(pinia);
  });

  it("throws an error if block does not exist", () => {
    const zoneStore = useZoneStore();
    expect(
      (zoneStore.content[0].fields[2] as Repeater<ComponentContent>)
        .sub_elements
    ).toHaveLength(0);
    const addComponent = () =>
      zoneStore.addComponent("undefinedBlock", "column", "column");
    expect(addComponent).toThrow(
      CannotFindComponentError("undefinedBlock", "zone")
    );
  });

  it("throws an error if component does not exist", () => {
    const zoneStore = useZoneStore();
    expect(
      (zoneStore.content[0].fields[2] as Repeater<ComponentContent>)
        .sub_elements
    ).toHaveLength(0);
    const addComponent = () =>
      zoneStore.addComponent("block_id", "column", "undefinedId");
    expect(addComponent).toThrow(CannotFindStructureError("undefinedId"));
  });

  it("throws an error if root does not exist", () => {
    const zoneStore = useZoneStore();
    expect(
      (zoneStore.content[0].fields[2] as Repeater<ComponentContent>)
        .sub_elements
    ).toHaveLength(0);
    const addComponent = () =>
      zoneStore.addComponent("block_id", "undefinedRoot", "card");
    expect(addComponent).toThrow(
      CannotFindComponentError("undefinedRoot", "block_id")
    );
  });

  it("adds a new component at indicated place", () => {
    const zoneStore = useZoneStore();
    expect(
      (zoneStore.content[0].fields[2] as Repeater<ComponentContent>)
        .sub_elements
    ).toHaveLength(0);
    zoneStore.addComponent("block_id", "column", "column");
    expect(
      (zoneStore.content[0].fields[2] as Repeater<ComponentContent>)
        .sub_elements
    ).toHaveLength(1);
  });

  it("adds component after existing components", () => {
    const zoneStore = useZoneStore();
    zoneStore.$patch({ content: [oneColumnBlock] });
    expect(
      (zoneStore.content[0].fields[2] as Repeater<ComponentContent>)
        .sub_elements
    ).toHaveLength(1);
    zoneStore.addComponent("block_id", "column", "column");
    expect(
      (zoneStore.content[0].fields[2] as Repeater<ComponentContent>)
        .sub_elements
    ).toHaveLength(2);
    expect(
      (zoneStore.content[0].fields[2] as Repeater<ComponentContent>)
        .sub_elements[0].id
    ).toEqual("e04483da-d1a4-4dab-a467-a98a71b3719f");
  });

  it("adds sub-components", () => {
    const zoneStore = useZoneStore();
    zoneStore.addComponent("block_id", "column", "column");
    expect(
      (zoneStore.content[0].fields[2] as Repeater<ComponentContent>)
        .sub_elements[0].fields
    ).toHaveLength(2);
  });

  it("adds recursively nested components", () => {
    const zoneStore = useZoneStore();
    zoneStore.$patch({ content: [oneColumnBlock] });
    zoneStore.addComponent(
      "block_id",
      "7a259b78-1371-4015-aeff-c7319e1af668",
      "card"
    );
    expect(
      (
        (zoneStore.content[0].fields[2] as Repeater<ComponentContent>)
          .sub_elements[0].fields[1] as Repeater<ComponentContent>
      ).sub_elements
    ).toHaveLength(1);
  });
});
