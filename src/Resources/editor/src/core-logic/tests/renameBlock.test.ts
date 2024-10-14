import type {BlockContent} from "../entities/BlockContent";
import {CannotFindComponentError} from "../errors/CannotFindComponentError";
import {createTestingPinia} from "@pinia/testing";
import filledColumnBlockWithId from "./filledColumnContentWithId.json";
import {setActivePinia} from "pinia";
import {useZoneStore} from "../store/zoneStore";

describe("Rename block", () => {
  const columnBlock: BlockContent = filledColumnBlockWithId as BlockContent;
  beforeEach(() => {
    const pinia = createTestingPinia({
      initialState: {
        zone: {
          content: [columnBlock],
        },
      },
      stubActions: false,
    });
    setActivePinia(pinia);
  });

  it("throws error when block does not exist", () => {
    const zoneStore = useZoneStore();
    expect(() => zoneStore.renameElement("undefinedId", "New Label")).toThrow(
      CannotFindComponentError("undefinedId")
    );
  });

  it("changes block label", () => {
    const zoneStore = useZoneStore();
    expect(zoneStore.content[0].label).toEqual("column");
    zoneStore.renameElement(zoneStore.content[0].id, "New label");
    expect(zoneStore.content[0].label).toEqual("New label");
  });
});
