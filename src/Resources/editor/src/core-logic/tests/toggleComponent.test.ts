import {CannotFindComponentError} from "../errors/CannotFindComponentError";
import {ComponentContent} from "../entities/ComponentContent";
import {OperationNotAllowedError} from "../errors/OperationNotAllowedError";
import {createTestingPinia} from "@pinia/testing";
import filledColumnBlockContent from "./filledColumnContentWithId.json";
import {setActivePinia} from "pinia";
import {useZoneStore} from "../store/zoneStore";

describe("Toggle com>ponent", () => {
  const columnBlockContent = filledColumnBlockContent;
  beforeEach(() => {
    const pinia = createTestingPinia({
      initialState: {
        zone: {
          content: [columnBlockContent],
        },
      },
      stubActions: false,
    });
    setActivePinia(pinia);
  });

  it("throws error when component does not exist", () => {
    const zoneStore = useZoneStore();
    expect(() => zoneStore.toggleElement("undefinedId")).toThrow(
      CannotFindComponentError("undefinedId")
    );
  });

  it("throws error when component is not optional", () => {
    const zoneStore = useZoneStore();
    expect(() => zoneStore.toggleElement("field_0")).toThrow(
      OperationNotAllowedError(
        "Hide / Show component",
        "Hiding component is only allowed on optional components"
      )
    );
  });

  it("toggles component", () => {
    const zoneStore = useZoneStore();
    const component = (zoneStore.content[0].fields[1] as ComponentContent)
      .fields[0];
    expect(component.hidden).toBe(false);
    zoneStore.toggleElement(component.id);
    expect(component.hidden).toBe(true);
    zoneStore.toggleElement(component.id);
    expect(component.hidden).toBe(false);
  });
});
