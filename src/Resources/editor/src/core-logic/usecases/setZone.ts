import {fetchZoneContent} from "../infrastructure/fetchZoneContent";
import {fetchAvailableBlocks} from "../infrastructure/fetchAvailableBlocks";
import {useNavigationStore} from "../store/navigationStore";

export const setZone = (zoneStore, zoneId: string) => {
  zoneStore.zonesContent[zoneStore.selectedZoneId] = zoneStore.content;
  zoneStore.selectedZoneId = zoneId;

  if (!zoneStore.zonesContent[zoneId]) {
    fetchZoneContent();
  }
  fetchAvailableBlocks();

  zoneStore.content = zoneStore.zonesContent[zoneId] ?? [];
  useNavigationStore().resetElement();
};
