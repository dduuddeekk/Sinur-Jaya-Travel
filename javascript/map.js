// function initMap() {
//     var map = new google.maps.Map(document.getElementById('map'), {
//       center: { lat: YOUR_LATITUDE, lng: YOUR_LONGITUDE },
//       zoom: YOUR_ZOOM_LEVEL
//     });
//   }  

var map = L.map('map').setView([YOUR_LATITUDE, YOUR_LONGITUDE], YOUR_ZOOM_LEVEL);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
  maxZoom: 19
}).addTo(map);
