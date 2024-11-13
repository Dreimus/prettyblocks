import {useZoneStore} from "../store/zoneStore";

export const fetchZoneContent = (zoneId: string) => {
  let zoneStore = useZoneStore();
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
