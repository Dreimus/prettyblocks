import {useZoneStore} from "../store/zoneStore";
import {fetchCurrentZone} from "./fetchCurrentZone";

export const fetchAvailableZones = () => {
  let zoneStore = useZoneStore();

  fetch(window.prettyblocks.routes.zone_list)
    .then((response) => response.json())
    .then((data) => {
      zoneStore.$patch({
          availableZones: data
        }
      );
      fetchCurrentZone();
    });
}
