import {useZoneStore} from "../store/zoneStore";


export const fetchAvailableBlocks = () => {
  let zoneStore = useZoneStore();

  let zoneAvailableBlocksUrl = zoneStore.availableZones.find((zone) => zone.id === zoneStore.selectedZoneId).blockAvailableUrl;

  if (!zoneAvailableBlocksUrl) {
    throw new Error("No available blocks URL found for the selected zone");
  }

  fetch(zoneAvailableBlocksUrl)
    .then((response) => response.json())
    .then((data) => {
      zoneStore.updateAvailableBlocks(data);
    });
}
