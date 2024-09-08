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

  <!-- Khung tìm kiếm -->
  <div class="search-container">
    <input type="text" id="search" class="search-input" placeholder="Tìm trạm sạc theo tên hoặc tọa độ (lat, lon)...">
  </div>

  <script>
    // Khởi tạo bản đồ
    var map = L.map('map').setView([21.0285, 105.8467], 12);

    // Thêm lớp tile OpenStreetMap vào bản đồ
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18,
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var userLocationMarker;
    var markers = {};
    var stations = @json($stations);
    var currentRoutingControl;

    // Hàm cập nhật bản đồ với vị trí hiện tại của người dùng
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

    // Xử lý lỗi lấy vị trí
    function handleGeolocationError(error) {
      console.error('Error getting location:', error);
      alert('Không thể lấy vị trí hiện tại.');
    }

    // Hàm chia sẻ vị trí của trạm
    function shareStationLocation(lat, lon) {
      var shareUrl = `${window.location.origin}/map?lat=${lat}&lon=${lon}`;
      navigator.clipboard.writeText(shareUrl).then(() => {
        alert('Liên kết vị trí trạm sạc đã được sao chép: ' + shareUrl);
      }).catch(err => {
        console.error('Failed to copy station location URL: ', err);
        alert('Không thể sao chép liên kết vị trí trạm sạc.');
      });
    }

    // Hàm chỉ đường đến vị trí đã chọn
    function getRouteToLocation(lat, lon) {
      if (!userLocationMarker) {
        alert('Không thể lấy vị trí hiện tại.');
        return;
      }

      // Xóa control chỉ đường trước đó nếu tồn tại
      if (currentRoutingControl) {
        map.removeControl(currentRoutingControl);
      }

      // Thêm control chỉ đường mới
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

    // Hàm xử lý tham số URL và căn giữa bản đồ
    function handleUrlParams() {
      const urlParams = new URLSearchParams(window.location.search);
      const lat = parseFloat(urlParams.get('lat'));
      const lon = parseFloat(urlParams.get('lon'));

      if (!isNaN(lat) && !isNaN(lon)) {
        // Cập nhật bản đồ đến tọa độ từ URL
        map.setView([lat, lon], 15);

        // Tạo marker cho trạm sạc từ URL
        var marker = L.marker([lat, lon]).addTo(map)
          .bindPopup('Vị trí từ liên kết chia sẻ')
          .openPopup();
        
        // Tìm trạm sạc gần nhất để cập nhật thông tin
        var nearestStation = findNearestStation(lat, lon);
        if (nearestStation) {
          marker.setPopupContent('<div class="popup-content">' +
            '<h4>' + nearestStation.name_tramsac + '</h4>' +
            '<p>Địa Chỉ: ' + nearestStation.address + '</p>' +
            '<p>Loại trạm: ' + nearestStation.loai_tram + '</p>' +
            '<p>Loại sạc: ' + nearestStation.loai_sac + '</p>' +
            // (nearestStation.image ? '<img src="' + nearestStation.image + '" alt="Trạm sạc">' : '') +
            '<button onclick="getRouteToLocation(' + nearestStation.map_lat + ', ' + nearestStation.map_lon + ')">Chỉ đường</button>' +
            '<button onclick="shareStationLocation(' + nearestStation.map_lat + ', ' + nearestStation.map_lon + ')">Chia sẻ vị trí</button>' +
            '</div>').openPopup();
        }
      } else {
        // Nếu không có tọa độ trong URL, lấy vị trí hiện tại của người dùng
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            updateMapWithCurrentLocation(position.coords.latitude, position.coords.longitude);
          }, handleGeolocationError);
        } else {
          alert('Trình duyệt không hỗ trợ Geolocation.');
        }
      }
    }

    // Gọi hàm xử lý tham số URL khi trang được tải
    handleUrlParams();

    // Thêm các marker trạm vào bản đồ
    stations.forEach(function(station) {
      if (station.map_lat && station.map_lon) {
        var marker = L.marker([station.map_lat, station.map_lon]).addTo(map)
          .bindPopup('<div class="popup-content">' +
            '<h4>' + station.name_tramsac + '</h4>' +
            '<p>' + station.address + '</p>' +
            '<p>Loại trạm: ' + station.loai_tram + '</p>' +
            '<p>Loại sạc: ' + station.loai_sac + '</p>' +
            // (station.image ? '<img src="' + station.image + '" alt="Trạm sạc">' : '') +
            '<button onclick="getRouteToLocation(' + station.map_lat + ', ' + station.map_lon + ')">Chỉ đường</button>' +
            '<button onclick="shareStationLocation(' + station.map_lat + ', ' + station.map_lon + ')">Chia sẻ vị trí</button>' +
            '</div>');

        // Lưu marker vào từ điển với tên trạm là khóa
        markers[station.name_tramsac.toLowerCase()] = marker;
      } else {
        console.warn('Station missing coordinates:', station);
      }
    });

    // Hàm tìm trạm sạc gần nhất từ tọa độ nhập vào
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

    // Chức năng tìm kiếm
    document.getElementById('search').addEventListener('input', function(event) {
      var searchQuery = event.target.value.toLowerCase();
      var foundMarker = false;

      // Kiểm tra nếu tìm kiếm là tọa độ
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
        // Tìm kiếm theo tên trạm sạc
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
  </script>

@endsection
