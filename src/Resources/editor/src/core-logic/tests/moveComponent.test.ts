import type {BlockContent} from "../entities/BlockContent";
import {CannotFindComponentError} from "../errors/CannotFindComponentError";
import type {ComponentContent} from "../entities/ComponentContent";
import {OperationNotAllowedError} from "../errors/OperationNotAllowedError";
import type {Repeater} from "../entities/Repeater";
import {createTestingPinia} from "@pinia/testing";
import filledColumnContentWithId from "./filledColumnContentWithId.json";
import {setActivePinia} from "pinia";
import {useZoneStore} from "../store/zoneStore";

describe("Move component", () => {
  const columnBlock: BlockContent = filledColumnContentWithId as BlockContent;

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

  it("throws error when component is not found", () => {
    const zoneStore = useZoneStore();
    const failingMove = () => zoneStore.moveComponent("undefinedId", 1);
    expect(failingMove).toThrow(CannotFindComponentError("undefinedId"));
  });

  it("throws error when component is not inside repeater", () => {
    const zoneStore = useZoneStore();
    const failingMove = () => zoneStore.moveComponent("field_1", 1);
    expect(failingMove).toThrow(
      OperationNotAllowedError(
        "Move component",
        "Cannot move component that is not repeated"
      )
    );
  });

  it("moves component", () => {
    const zoneStore = useZoneStore();
    zoneStore.moveComponent("field_2_0_1_1", 0);
    expect(
      (
        (zoneStore.content[0].fields[2] as Repeater<ComponentContent>)
          .sub_elements[0].fields[1] as Repeater<ComponentContent>
      ).sub_elements[0].id
    ).toEqual("field_2_0_1_1");
  });
});
