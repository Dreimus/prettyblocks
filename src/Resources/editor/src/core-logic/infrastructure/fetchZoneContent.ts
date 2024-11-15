import {useZoneStore} from "../store/zoneStore";

export const fetchZoneContent = () => {
  let zoneStore = useZoneStore();
  let zoneId = zoneStore.selectedZoneId;
  let getContentRoute = zoneStore.availableZones.find((zone) => zone.id === zoneId).getUrl;

  fetch(getContentRoute)
    .then((response) => response.json())
    .then((data) => {
      zoneStore.zonesContent[zoneId] = data.content;
      zoneStore.$patch({
        content: data.content,
      });
    }
  );
}
