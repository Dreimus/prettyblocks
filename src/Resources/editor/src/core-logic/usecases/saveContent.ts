export const saveContent = async (zoneStore): Promise<any> => {
  // loop through all the zones and save the content
  const promises = zoneStore.availableZones.map(async (zone) => {

    // before saving the content, check if the zone has any content not saved
    if (zone.id === zoneStore.selectedZoneId) {
      zoneStore.zonesContent[zone.id] = zoneStore.content;
    }

    let zoneContent = zoneStore.zonesContent[zone.id];
    if (zoneContent) {
      // save the content of the zone to the server
      return fetch(zone.updateUrl, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(zoneContent),
      })
        .then((response) => response.json())
        .then((data) => {
          console.log("Saved content for zone", zone.id);
        });
    }
    return Promise.resolve();
  });


  return Promise.all(promises);
}
