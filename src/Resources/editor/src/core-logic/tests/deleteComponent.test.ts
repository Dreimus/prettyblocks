import type {BlockContent} from "../entities/BlockContent";
import {CannotFindComponentError} from "../errors/CannotFindComponentError";
import type {ComponentContent} from "../entities/ComponentContent";
import {OperationNotAllowedError} from "../errors/OperationNotAllowedError";
import type {Repeater} from "../entities/Repeater";
import {createTestingPinia} from "@pinia/testing";
import oneColumnContentWithId from "./oneColumnContentWithId.json";
import {setActivePinia} from "pinia";
import {useZoneStore} from "../store/zoneStore";

describe("Delete component", () => {
  const oneColumnBlock: BlockContent = oneColumnContentWithId as BlockContent;
  beforeEach(() => {
    const pinia = createTestingPinia({
      initialState: {
        zone: {
          content: [oneColumnBlock],
        },
      },
      stubActions: false,
    });
    setActivePinia(pinia);
  });

  it("throws error when component is not found", () => {
    const zoneStore = useZoneStore();
    const failingDelete = () => zoneStore.deleteComponentById("undefinedId");
    expect(failingDelete).toThrow(CannotFindComponentError("undefinedId"));
  });

  it("throws error when component is not inside repeater and not optional", () => {
    const zoneStore = useZoneStore();
    const failingDelete = () => zoneStore.deleteComponentById("banner_intro");
    expect(failingDelete).toThrow(
      OperationNotAllowedError(
        "Delete component",
        "Non repeated and non optional components cannot be deleted"
      )
    );
  });

  it("deletes component", () => {
    const zoneStore = useZoneStore();
    expect(
      (zoneStore.content[0].fields[1] as ComponentContent).fields
    ).toHaveLength(2);
    zoneStore.deleteComponentById("banner_image");
    expect(
      (zoneStore.content[0].fields[1] as ComponentContent).fields
    ).toHaveLength(1);
  });

  it("deletes repeatable component", () => {
    const zoneStore = useZoneStore();
    expect(
      (zoneStore.content[0].fields[2] as Repeater<ComponentContent>)
        .sub_elements
    ).toHaveLength(1);
    zoneStore.deleteComponentById("e04483da-d1a4-4dab-a467-a98a71b3719f");
    expect(
      (zoneStore.content[0].fields[2] as Repeater<ComponentContent>)
        .sub_elements
    ).toHaveLength(0);
  });
});
