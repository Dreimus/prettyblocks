import {useZoneStore} from "../store/zoneStore";
import {fetchCurrentZone} from "./fetchCurrentZone";

export const fetchAvailableZones = () => {
  let zoneStore = useZoneStore();

  if (window.prettyblocks.routes.zone_list) {
    fetch(window.prettyblocks.routes.zone_list)
      .then((response) => response.json())
      .then((data) => {
        zoneStore.$patch({
            availableZones: data
          }
        );
        fetchCurrentZone();
      });
  } else {
    zoneStore.$patch({
      availableZones: [
        {
          id: "1",
          label: "Entête",
        },
        {
          id: "2",
          label: "Pied de page",
        },
        {
          id: "3",
          label: "Template - Homepage",
        },
      ],
    });
  }
}
