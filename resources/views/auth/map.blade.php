@extends('nav.header')
@section('title', 'Map')

@section('content')
  <style>
    #map {
      width: 100%;
      height: 1000px;
    }
    .popup-content img {
      max-width: 100px;
    }
  </style>
  <div id="map"></div>
  <script>
    // Initialize the map
    var map = L.map('map').setView([21.0285, 105.8467], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18,
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Function to update map with the current location
    function updateMapWithCurrentLocation(lat, lon) {
      var currentLocation = [lat, lon];
      if (userLocationMarker) {
        map.removeLayer(userLocationMarker);
      }
      userLocationMarker = L.marker(currentLocation).addTo(map)
        .bindPopup('Vị trí của bạn')
        .openPopup();
      map.setView(currentLocation, 15);
      return currentLocation;
    }

    function handleGeolocationError(error) {
      console.error('Error getting location:', error);
      alert('Không thể lấy vị trí hiện tại.');
    }

    var userLatLon;
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        userLatLon = updateMapWithCurrentLocation(position.coords.latitude, position.coords.longitude);
      }, handleGeolocationError);
    } else {
      alert('Trình duyệt không hỗ trợ Geolocation.');
    }

    L.Control.geocoder().addTo(map);

    // Fetch stations data from Laravel
    var stations = @json($stations);

    // Add station markers to the map
    stations.forEach(function(station) {
      if (station.map_lat && station.map_lon) {
        L.marker([station.map_lat, station.map_lon]).addTo(map)
          .bindPopup('<div class="popup-content">' +
            '<h4>' + station.name_tramsac + '</h4>' +
            '<p>' + station.address + '</p>' +
            '<button onclick="getRouteToLocation(' + station.map_lat + ', ' + station.map_lon + ')">Chỉ đường</button>' +
          '</div>');
      } else {
        console.warn('Station missing coordinates:', station);
      }
    });

    // Function to get route to the selected location
    function getRouteToLocation(lat, lon) {
      if (!userLatLon) {
        alert('Không thể lấy vị trí hiện tại.');
        return;
      }
      L.Routing.control({
        waypoints: [
          L.latLng(userLatLon[0], userLatLon[1]),
          L.latLng(lat, lon)
        ],
        routeWhileDragging: true,
        createMarker: function() { return null; }
      }).addTo(map);
    }
  </script>
@endsection
