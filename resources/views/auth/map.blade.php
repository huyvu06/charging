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
      height: auto;
    }
    .search-container {
      position: absolute;
      top: 130px;
      right: 50px;
      z-index: 1000;
      background: white;
      padding: 5px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    }
    .search-input {
      width: 300px;
      padding: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
  </style>

  <!-- Khung bản đồ -->
  <div id="map"></div>

  <div class="search-container">
    <select id="car-type-select" class="search-input">
        <option value="all">Tất cả</option>
        @foreach($carTypes as $carType)
            <option value="{{ $carType }}">{{ $carType }}</option>
        @endforeach
    </select>
    <input type="text" id="search" class="search-input" placeholder="Tìm trạm sạc theo tên hoặc tọa độ (lat, lon)...">
</div>

  <script>
   
    var map = L.map('map').setView([21.0285, 105.8467], 12);

   
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18,
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var userLocationMarker;
    var markers = {};
    var stations = @json($stations);
    var currentRoutingControl;

   
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

    
    function shareStationLocation(lat, lon) {
      var shareUrl = `${window.location.origin}/map?lat=${lat}&lon=${lon}`;
      navigator.clipboard.writeText(shareUrl).then(() => {
        alert('Liên kết vị trí trạm sạc đã được sao chép: ' + shareUrl);
      }).catch(err => {
        console.error('Failed to copy station location URL: ', err);
        alert('Không thể sao chép liên kết vị trí trạm sạc.');
      });
    }

  
    function getRouteToLocation(lat, lon) {
      if (!userLocationMarker) {
        alert('Không thể lấy vị trí hiện tại.');
        return;
      }

      
      if (currentRoutingControl) {
        map.removeControl(currentRoutingControl);
      }

    
      currentRoutingControl = L.Routing.control({
        waypoints: [
          L.latLng(userLocationMarker.getLatLng().lat, userLocationMarker.getLatLng().lng),
          L.latLng(lat, lon)
        ],
        routeWhileDragging: true,
        createMarker: function() { return null; },
        position: 'topleft'
      }).addTo(map);
    }

    
    function handleUrlParams() {
      const urlParams = new URLSearchParams(window.location.search);
      const lat = parseFloat(urlParams.get('lat'));
      const lon = parseFloat(urlParams.get('lon'));

      if (!isNaN(lat) && !isNaN(lon)) {
        map.setView([lat, lon], 15);
        var marker = L.marker([lat, lon]).addTo(map)
          .bindPopup('Vị trí từ liên kết chia sẻ')
          .openPopup();
        
       
        var nearestStation = findNearestStation(lat, lon);
        if (nearestStation) {
          marker.setPopupContent('<div class="popup-content">' +
            '<h4>' + nearestStation.name_tramsac + '</h4>' +
            '<p>Địa Chỉ: ' + nearestStation.address + '</p>' +
            '<p>Loại trạm: ' + nearestStation.loai_tram + '</p>' +
            '<p>Loại sạc: ' + nearestStation.loai_sac + '</p>' +
            (nearestStation.image ? '<img src="data:image;base64,' + nearestStation.image + '" alt="image">' : '') +
            '<button onclick="getRouteToLocation(' + nearestStation.map_lat + ', ' + nearestStation.map_lon + ')">Chỉ đường</button>' +
            '<button onclick="shareStationLocation(' + nearestStation.map_lat + ', ' + nearestStation.map_lon + ')">Chia sẻ vị trí</button>' +
            '</div>').openPopup();
        }
      } else {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            updateMapWithCurrentLocation(position.coords.latitude, position.coords.longitude);
          }, handleGeolocationError);
        } else {
          alert('Trình duyệt không hỗ trợ Geolocation.');
        }
      }
    }

   
    handleUrlParams();
    stations.forEach(function(station) {
      if (station.map_lat && station.map_lon) {
        var marker = L.marker([station.map_lat, station.map_lon]).addTo(map)
            .bindPopup('<div class="popup-content">' +
              '<h4>' + station.name_tramsac + '</h4>' +
              '<p>' + station.address + '</p>' +
              '<p>Loại trạm: ' + station.loai_tram + '</p>' +
              '<p>Loại sạc: ' + station.loai_sac + '</p>' +
              '<p>Loại xe: ' + (station.cars.map(car => car.name_car).join(', ') || 'Không có thông tin') + '</p>' + // Bao gồm loại xe
              (station.image ? '<img src="data:image;base64,' + station.image + '" alt="image">' : '') +
              '<button onclick="getRouteToLocation(' + station.map_lat + ', ' + station.map_lon + ')">Chỉ đường</button>' +
              '<button onclick="shareStationLocation(' + station.map_lat + ', ' + station.map_lon + ')">Chia sẻ vị trí</button>' +
              '</div>');

        markers[station.name_tramsac.toLowerCase()] = marker;
      } else {
        console.warn('Station missing coordinates:', station);
      }
    });

    function findNearestStation(lat, lon) {
      var nearestStation = null;
      var minDistance = Infinity;

      stations.forEach(function(station) {
        if (station.map_lat && station.map_lon) {
          var distance = L.latLng(lat, lon).distanceTo([station.map_lat, station.map_lon]);
          if (distance < minDistance) {
            minDistance = distance;
            nearestStation = station;
          }
        }
      });

      return nearestStation;
    }


    document.getElementById('search').addEventListener('input', function(event) {
      var searchQuery = event.target.value.toLowerCase();
      var foundMarker = false;

      var coordsMatch = searchQuery.match(/^(-?\d+(\.\d+)?),\s*(-?\d+(\.\d+)?)$/);
      if (coordsMatch) {
        var lat = parseFloat(coordsMatch[1]);
        var lon = parseFloat(coordsMatch[3]);
        if (!isNaN(lat) && !isNaN(lon)) {
          var nearestStation = findNearestStation(lat, lon);
          if (nearestStation) {
            map.setView([nearestStation.map_lat, nearestStation.map_lon], 15);
            markers[nearestStation.name_tramsac].openPopup();
            foundMarker = true;
          }
        }
      } else {
       
        Object.keys(markers).forEach(function(name) {
          if (name.includes(searchQuery)) {
            var marker = markers[name];
            map.setView(marker.getLatLng(), 15);
            marker.openPopup();
            foundMarker = true;
          }
        });
      }

      if (!foundMarker) {
        alert('Không tìm thấy trạm sạc nào.');
      }
    });

   
document.getElementById('car-type-select').addEventListener('change', function(event) {
  var selectedCarType = event.target.value;
  if (selectedCarType === 'all') {
    Object.values(markers).forEach(function(marker) {
      marker.addTo(map);
    });
  } else {
    Object.values(markers).forEach(function(marker) {
      if (marker.getPopup().getContent().includes(selectedCarType)) {
        marker.addTo(map);
      } else {
        map.removeLayer(marker);
      }
    });
  }
});

  </script>

@endsection
