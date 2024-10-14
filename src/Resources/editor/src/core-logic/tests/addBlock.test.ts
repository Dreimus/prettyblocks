import type {BlockStructure} from "../entities/BlockStructure";
import columnStructure from "./columnStructure.json";
import {createTestingPinia} from "@pinia/testing";
import {setActivePinia} from "pinia";
import {useZoneStore} from "../store/zoneStore";

describe("Add new block", () => {
  beforeEach(() => {
    const emptyBlock: BlockStructure = {
      id: "emptyBlock",
      label: "Empty Block",
      fields: {},
    };
    const pinia = createTestingPinia({
      initialState: {
        zone: {
          availableBlocks: [columnStructure as BlockStructure, emptyBlock],
        },
      },
      stubActions: false,
    });
    setActivePinia(pinia);
  });

  it("Does not change state if block structure does not exist", () => {
    const zoneStore = useZoneStore();
    expect(zoneStore.content.length).toBe(0);
    zoneStore.addBlock("undefinedBlock");
    expect(zoneStore.content.length).toBe(0);
    // TODO expect error to be thrown
  });

  it("Adds a new block to zone", () => {
    const zoneStore = useZoneStore();
    expect(zoneStore.content.length).toBe(0);
    zoneStore.addBlock("columnBlock");
    expect(zoneStore.content.length).toBe(1);
  });

  it("Adds a new column block to zone", () => {
    const zoneStore = useZoneStore();
    expect(zoneStore.content.length).toBe(0);
    zoneStore.addBlock("columnBlock");
    const columnBlock = zoneStore.content[0];
    expect(columnBlock.block_id).toBe("columnBlock");
    expect(columnBlock.id).toBeDefined();
  });

  it("Adds a new block after existing blocks", () => {
    const zoneStore = useZoneStore();
    zoneStore.addBlock("emptyBlock");
    zoneStore.addBlock("columnBlock");
    expect(zoneStore.content.length).toBe(2);
    expect(zoneStore.content[1].block_id).toBe("columnBlock");
  });
});
