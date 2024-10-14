import {fetchZoneContent} from "./fetchZoneContent";

export const setZone = (zoneStore, zoneId: string) => {
  // persist the current content of the zone

  console.log("Setting zone", zoneId);
  console.log("selectedZone", zoneStore.selectedZone);
  zoneStore.zonesContent[zoneStore.selectedZoneId] = zoneStore.content;
  // set the new selected zone
  zoneStore.selectedZoneId = zoneId;

  if (!zoneStore.zonesContent[zoneId]) {
    fetchZoneContent(zoneId);
  }

  zoneStore.content = zoneStore.zonesContent[zoneId] ?? [];
};
