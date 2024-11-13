import {useZoneStore} from "../store/zoneStore";
import {fetchZoneContent} from "./fetchZoneContent";
import {fetchAvailableBlocks} from "./fetchAvailableBlocks";

export const fetchCurrentZone = () => {

  let zoneStore = useZoneStore();

  if (zoneStore.selectedZoneId === null) {
    if (zoneStore.availableZones.length === 0) {
      throw new Error("No zones available");
    }
    zoneStore.$patch({
      selectedZoneId: zoneStore.availableZones[0].id,
    });
  }

  fetchAvailableBlocks();
  fetchZoneContent(zoneStore.selectedZoneId);
}
