function iniciarmapa() {
  const coord = { lat: 2.080821 , lng:  -76.812696};
  const map = new google.maps.Map(document.getElementById('map'),{
    zoom: 10,
    center: coord
  });
  const marker = new google.maps.Marker({
    position: coord,
    map: map
  });
}
