import {buildNewBlockContentFromBlockStructure} from "../utils/builder";
import columnStructure from "../tests/columnStructure.json";
import allFieldsStructure from "../tests/allFieldsStructure.json";
import {useZoneStore} from "../store/zoneStore";


export const fetchAvailableBlocks = () => {
  let zoneStore = useZoneStore();

  if (window.prettyblocks.routes.fields_list) {
    fetch(window.prettyblocks.routes.fields_list)
      .then((response) => response.json())
      .then((data) => {
        zoneStore.$patch({
          availableBlocks: data,
          // temporary mock data @todo: remove
          content: [...data.map((block) => buildNewBlockContentFromBlockStructure(block))],
        });
      });
  } else {
    // Mock data
    const columnContent = buildNewBlockContentFromBlockStructure(columnStructure);
    const allFieldsContent =
      buildNewBlockContentFromBlockStructure(allFieldsStructure);

    zoneStore.$patch({
      availableBlocks: [columnStructure, allFieldsStructure],
      content: [columnContent, allFieldsContent],
    });
  }
}
