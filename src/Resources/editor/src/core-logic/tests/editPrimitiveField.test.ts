import type {BlockStructure} from "../entities/BlockStructure";
import {CannotFindComponentError} from "../errors/CannotFindComponentError";
import type {PrimitiveFieldContent} from "../entities/PrimitiveFieldContent";
import {PrimitiveFieldType} from "../entities/ElementType";
import allFieldsStructure from "./allFieldsStructure.json";
import {buildNewBlockContentFromBlockStructure} from "../utils/builder";
import {createTestingPinia} from "@pinia/testing";
import {setActivePinia} from "pinia";
import {useZoneStore} from "../store/zoneStore";

describe("Edit primitive field", () => {
  beforeEach(() => {
    const allFieldsStruct: BlockStructure =
      allFieldsStructure as BlockStructure;
    const allFieldsBlock =
      buildNewBlockContentFromBlockStructure(allFieldsStruct);
    const pinia = createTestingPinia({
      initialState: {
        zone: {
          content: [allFieldsBlock],
        },
      },
      stubActions: false,
    });
    setActivePinia(pinia);
  });

  it("throws an error when field does not exist", () => {
    const zoneStore = useZoneStore();
    expect(() =>
      zoneStore.editPrimitiveField("undefinedId", { value: "v" })
    ).toThrow(CannotFindComponentError("undefinedId"));
  });

  it("changes text field value", () => {
    const zoneStore = useZoneStore();
    const textField: PrimitiveFieldContent<PrimitiveFieldType.TEXT> = zoneStore
      .content[0].fields[0] as PrimitiveFieldContent<PrimitiveFieldType.TEXT>;
    expect(textField.content).toEqual({ value: "text" });
    zoneStore.editPrimitiveField<PrimitiveFieldType.TEXT>(textField.id, {
      value: "NewContent",
    });
    expect(textField.content).toEqual({ value: "NewContent" });
  });

  it("changes number field value", () => {
    const zoneStore = useZoneStore();
    const numberField: PrimitiveFieldContent<PrimitiveFieldType.NUMBER> =
      zoneStore.content[0]
        .fields[1] as PrimitiveFieldContent<PrimitiveFieldType.NUMBER>;
    expect(numberField.content).toEqual({ value: 42 });
    zoneStore.editPrimitiveField<PrimitiveFieldType.NUMBER>(numberField.id, {
      value: 12,
    });
    expect(numberField.content).toEqual({ value: 12 });
  });
});
