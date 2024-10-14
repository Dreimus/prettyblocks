import {useZoneStore} from "../store/zoneStore";
import {buildNewBlockContentFromBlockStructure} from "../utils/builder";

export const fetchZoneContent = (zoneId: string) => {
  console.log("fetching zone content for zone " + zoneId);
  let zoneStore = useZoneStore();

  if (window.prettyblocks.routes.zone_list) {
    // retrieving the zone content url from zoneStore
    let getZoneRoute = zoneStore.availableZones.find((zone) => zone.id === zoneId).blockAvailableUrl;

    fetch(getZoneRoute)
      .then((response) => response.json())
      .then((data) => {

        let content = data ? [...data.map((block) => buildNewBlockContentFromBlockStructure(block))]: [];

          zoneStore.$patch({
            availableBlocks: data,  // availableBlocks is a list of block types that can be added to the zone
            //content: content,
          });

          //zoneStore.zonesContent[zoneId] = content;

      }
      );

    // doing the same for content retrieval
    let getContentRoute = zoneStore.availableZones.find((zone) => zone.id === zoneId).getUrl;

    fetch(getContentRoute)
      .then((response) => response.json())
      .then((data) => {
        zoneStore.$patch({
          content: data.content,
        });
        zoneStore.zonesContent[zoneId] = data.content;
      }
    );
  }
}
