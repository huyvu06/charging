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
    .station-details {
      position: absolute;
      top: 130px;
      left: 50px;
      z-index: 1000;
      background: white;
      padding: 10px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
      width: 300px;
      height: auto;
      display: none; /* Initially hidden */
    }
    .station-details img {
      max-width: 100%;
      height: auto;
    }
    .close-btn {
      cursor: pointer;
      float: right;
      color: red;
      font-weight: bold;
    }
  </style>

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

  <div class="station-details" id="station-details">
    <span class="close-btn" id="close-details">X</span>
    <h4>Thông tin trạm sạc</h4>
    <p>Bấm vào một trạm sạc trên bản đồ để xem chi tiết.</p>
  </div>

  <script>
    // Initialize map
    var map = L.map('map').setView([21.0285, 105.8467], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18,
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var userLocationMarker;
    var markers = {};
    var stations = @json($stations);
    var currentRoutingControl;
    var stationDetails = document.getElementById('station-details');

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

    function createMarkers() {
      stations.forEach(function(station) {
        if (station.map_lat && station.map_lon) {
          var marker = L.marker([station.map_lat, station.map_lon]).addTo(map)
            .bindTooltip(station.name_tramsac, { permanent: true, direction: 'top' })
            .on('click', function() {
              updateStationDetails(station);
            });
          markers[station.name_tramsac.toLowerCase()] = marker;
        } else {
          console.warn('Station missing coordinates:', station);
        }
      });
    }

    function updateStationDetails(station) {
      const cars = station.cars;
      const uniqueElectricity = [...new Set(cars.map(car => car.dong_dien))].join(', ') || 'Không có thông tin';
      const uniquePorts = [...new Set(cars.map(car => car.cong_sac))].join(', ') || 'Không có thông tin';

      stationDetails.innerHTML = `
        <span class="close-btn" id="close-details">X</span>
        <h4>${station.name_tramsac}</h4>
        <p><strong>Địa chỉ:</strong> ${station.address}</p>
        <p><strong>Loại xe:</strong> ${cars.map(car => car.name_car).join(', ') || 'Không có thông tin'}</p>
        <p><strong>Dòng điện:</strong> ${uniqueElectricity}</p>
        <p><strong>Cổng sạc:</strong> ${uniquePorts}</p>
        ${station.image ? '<img src="data:image;base64,' + station.image + '" alt="image">' : ''}
        <button onclick="getRouteToLocation(${station.map_lat}, ${station.map_lon})">Chỉ đường</button>
        <button onclick="shareStationLocation(${station.map_lat}, ${station.map_lon})">Chia sẻ vị trí</button>
      `;
      stationDetails.style.display = 'block'; 

      document.getElementById('close-details').onclick = function() {
        stationDetails.style.display = 'none';
      };
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
          updateStationDetails(nearestStation);
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

    function initializeSearch() {
      document.getElementById('search').addEventListener('input', function(event) {
        var searchQuery = event.target.value.toLowerCase();
        var foundMarker = false;

        var coordsMatch = searchQuery.match(/^(-?\d+(\.\d+)?),\s*(-?\d+(\.\d+)?)$/);
        if (coordsMatch) {
          var lat = parseFloat(coordsMatch[1]);
          var lon = parseFloat(coordsMatch[3]);
          updateMapWithCurrentLocation(lat, lon);
          return; // Exit the search if coordinates are matched
        }

        for (var stationName in markers) {
          var marker = markers[stationName];
          if (stationName.includes(searchQuery)) {
            marker.addTo(map).setOpacity(1);
            foundMarker = true;
          } else {
            marker.remove();
          }
        }

        if (!foundMarker) {
          alert('Không tìm thấy trạm sạc nào.');
        }
      });
    }

    function handleCarTypeChange() {
  var selectedCarType = document.getElementById('car-type-select').value;
  for (var stationName in markers) {
    var marker = markers[stationName];
    var station = stations.find(station => station.name_tramsac.toLowerCase() === stationName.toLowerCase());
    
    // Kiểm tra xem trạm có xe tương ứng hay không
    var hasSelectedCarType = station && (selectedCarType === 'all' || station.cars.some(car => car.name_car === selectedCarType));
    
    if (hasSelectedCarType) {
      marker.addTo(map); // Đảm bảo marker được thêm vào bản đồ
      marker.setOpacity(1); // Hiển thị marker
    } else {
      marker.remove(); // Xóa marker nếu không phù hợp
    }
  }
}


    // Initialize map and events
    createMarkers();
    handleUrlParams();
    initializeSearch();
    document.getElementById('car-type-select').addEventListener('change', handleCarTypeChange);
  </script>
@endsection
