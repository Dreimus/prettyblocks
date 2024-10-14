import {
  buildNewBlockContentFromBlockStructure,
  buildNewComponentFromStructure,
  buildNewPrimitiveFieldFromStructure,
} from "../utils/builder";

import {BlockContent} from "../entities/BlockContent";
import {BlockStructure} from "../entities/BlockStructure";
import {ComponentContent} from "../entities/ComponentContent";
import {ComponentStructure} from "../entities/ComponentStructure";
import {PrimitiveFieldContent} from "../entities/PrimitiveFieldContent";
import {PrimitiveFieldStructure} from "../entities/PrimitiveFieldStructure";
import {PrimitiveFieldType} from "../entities/ElementType";
import {Repeater} from "../entities/Repeater";
import columnBlockStructure from "./columnStructure.json";
import columnBlockStructureWithPrimitiveRepeater from "./columnStructureWithPrimitiveRepeater.json";

/*
  Add a test here every time you create a new builder or improve an existing one.
*/

describe("Block, component and Primitive content builder", () => {
  let blockStructure: BlockStructure;
  const blockStructurePrimitiveRepeater: BlockStructure =
    columnBlockStructureWithPrimitiveRepeater as BlockStructure;

  beforeAll(() => {
    blockStructure = columnBlockStructure as BlockStructure;
  });

  describe("Primitive builder", () => {
    it("builds a primitive text", () => {
      const primitiveTextStructure: PrimitiveFieldStructure<PrimitiveFieldType.TEXT> =
        blockStructure.fields
          .title as PrimitiveFieldStructure<PrimitiveFieldType.TEXT>;
      const newTextContent: PrimitiveFieldContent<PrimitiveFieldType.TEXT> =
        buildNewPrimitiveFieldFromStructure(
          primitiveTextStructure
        ) as PrimitiveFieldContent<PrimitiveFieldType.TEXT>;
      expect(newTextContent).toHaveProperty("id");
      expect(newTextContent).toHaveProperty(
        "label",
        primitiveTextStructure.label
      );
      expect(newTextContent).toHaveProperty(
        "type",
        primitiveTextStructure.type
      );
      expect(newTextContent).toHaveProperty(
        "content.value",
        primitiveTextStructure.default.value
      );
      expect(newTextContent).toHaveProperty(
        "structureId",
        primitiveTextStructure.id
      );
    });
  });

  describe("Component builder", () => {
    it("builds a non-repeatable component", () => {
      const componentStructure: ComponentStructure = blockStructure.fields
        .banner as ComponentStructure;
      const newComponentContent: ComponentContent =
        buildNewComponentFromStructure(componentStructure) as ComponentContent;
      expect(newComponentContent).toHaveProperty("id");
      expect(newComponentContent).toHaveProperty(
        "label",
        componentStructure.label
      );
      expect(newComponentContent).toHaveProperty(
        "type",
        componentStructure.type
      );
      expect(newComponentContent).toHaveProperty(
        "component_id",
        componentStructure.id
      );
      expect(newComponentContent).toHaveProperty(
        "optional",
        componentStructure.optional || false
      );
      expect(newComponentContent).toHaveProperty("fields");
    });

    it("fills non-repeatable component fields with default values", () => {
      const componentStructure: ComponentStructure = blockStructure.fields
        .banner as ComponentStructure;
      const newComponentContent: ComponentContent =
        buildNewComponentFromStructure(componentStructure) as ComponentContent;
      const newComponentFields = newComponentContent.fields;
      expect(newComponentFields[0]).toHaveProperty("id");
      expect(newComponentFields[0]).toHaveProperty(
        "type",
        Object.values(componentStructure.fields)[0].type
      );
      expect(newComponentFields[0]).toHaveProperty(
        "label",
        Object.values(componentStructure.fields)[0].label
      );
      expect(newComponentFields[0]).toHaveProperty(
        "content.value",
        (
          Object.values(
            componentStructure.fields
          )[0] as PrimitiveFieldStructure<PrimitiveFieldType.TEXT>
        ).default.value
      );
      expect(newComponentFields[1]).toHaveProperty("id");
      expect(newComponentFields[1]).toHaveProperty(
        "type",
        Object.values(componentStructure.fields)[1].type
      );
      expect(newComponentFields[1]).toHaveProperty(
        "label",
        Object.values(componentStructure.fields)[1].label
      );
      expect(newComponentFields[1]).toHaveProperty(
        "content.value",
        (
          Object.values(
            componentStructure.fields
          )[1] as PrimitiveFieldStructure<PrimitiveFieldType.TEXT>
        ).default.value
      );
    });

    it("builds a repeatable component", () => {
      const componentStructure: ComponentStructure = blockStructure.fields
        .columns as ComponentStructure;
      const newComponentContent: Repeater<ComponentContent> =
        buildNewComponentFromStructure(
          componentStructure
        ) as Repeater<ComponentContent>;
      expect(newComponentContent).toHaveProperty("id");
      expect(newComponentContent).toHaveProperty(
        "label",
        componentStructure.label
      );
      expect(newComponentContent).toHaveProperty("type", "repeater");
      expect(newComponentContent).toHaveProperty(
        "component_id",
        componentStructure.id
      );
      expect(newComponentContent).toHaveProperty("sub_elements", []);
    });

    it("builds a primitive repeatable component", () => {
      const componentStructure: ComponentStructure =
        blockStructurePrimitiveRepeater.fields.columns as ComponentStructure;
      const newComponentContent: Repeater<ComponentContent> =
        buildNewComponentFromStructure(
          componentStructure
        ) as Repeater<ComponentContent>;
      expect(newComponentContent).toHaveProperty("id");
      expect(newComponentContent).toHaveProperty(
        "label",
        componentStructure.label
      );
      expect(newComponentContent).toHaveProperty("type", "repeater");
      expect(newComponentContent).toHaveProperty(
        "component_id",
        PrimitiveFieldType.TEXT
      );
      expect(newComponentContent).toHaveProperty("sub_elements", []);
    });
  });

  describe("Block builder", () => {
    it("builds a full block", () => {
      const newBlockContent: BlockContent =
        buildNewBlockContentFromBlockStructure(blockStructure);
      expect(newBlockContent).toHaveProperty("id");
      expect(newBlockContent).toHaveProperty("block_id", blockStructure.id);
      expect(newBlockContent.fields).toHaveLength(3);
      expect(newBlockContent.fields[0]).toHaveProperty(
        "label",
        Object.values(blockStructure.fields)[0].label
      );
      expect(newBlockContent.fields[1]).toHaveProperty(
        "label",
        Object.values(blockStructure.fields)[1].label
      );
      expect(newBlockContent.fields[2]).toHaveProperty(
        "label",
        Object.values(blockStructure.fields)[2].label
      );
    });
  });
});
