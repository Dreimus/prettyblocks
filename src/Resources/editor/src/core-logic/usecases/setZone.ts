import {fetchZoneContent} from "./fetchZoneContent";
import {fetchAvailableBlocks} from "./fetchAvailableBlocks";

export const setZone = (zoneStore, zoneId: string) => {
  zoneStore.zonesContent[zoneStore.selectedZoneId] = zoneStore.content;
  zoneStore.selectedZoneId = zoneId;

  if (!zoneStore.zonesContent[zoneId]) {
    fetchZoneContent(zoneId);
  }
  fetchAvailableBlocks();

  zoneStore.content = zoneStore.zonesContent[zoneId] ?? [];
};
