@extends('nav.header')
@section('title', 'Map')

@section('content')
<style>
  #map {
      width: 100%;
      height: calc(100vh - 200px); /* Chiều cao của bản đồ */
  }
  .popup-content img {
      max-width: 100px;
      height: auto;
  }
  .search-container {
      position: absolute;
      top: 130px; /* Đảm bảo đủ khoảng cách từ thanh điều hướng */
      right: 50px;
      z-index: 1000;
      background: white;
      padding: 5px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
      margin-bottom: 10px; /* Khoảng cách giữa ô tìm kiếm và bản đồ */
  }
  @media (max-width: 768px) {
      .search-container {
          top: 90px; /* Điều chỉnh cho thiết bị di động */
          right: 10px;
          width: 90%;
          padding: 10px;
      }

      .station-details {
          top: 90px; /* Điều chỉnh cho thiết bị di động */
          left: 10px;
          width: 90%; /* Giảm chiều rộng cho thiết bị di động */
          max-height: 300px; /* Điều chỉnh chiều cao tối đa cho thiết bị di động */
          overflow-y: auto; /* Giữ overflow để cuộn nếu cần */
      }
  }
  .station-tooltip {
      background: white;
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 5px;
      max-width: 150px;
  }

  .search-input {
      width: 300px;
      padding: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
  }
  .station-details {
      position: absolute;
      top: 130px; /* Đảm bảo đủ khoảng cách từ thanh điều hướng */
      left: 50px;
      z-index: 1000;
      background: white;
      padding: 10px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
      width: 500px;
      max-height: 400px;
      overflow-y: auto;
      display: none; /* Ban đầu ẩn */
      margin-top: 10px; /* Khoảng cách giữa chi tiết trạm và bản đồ */
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

   <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

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
        .bindTooltip(station.name_tramsac, { permanent: true, direction: 'top', className: 'station-tooltip' })
        .on('click', function() {
          updateStationDetails(station);
        })
        .on('mouseover', function() {
          // Hiển thị thông tin chi tiết về cổng sạc
          this.bindTooltip(
            `<strong>${station.name_tramsac}</strong><br>Cổng sạc: ${station.charging_ports.map(port => port.cong_sac).join(', ') || 'Không có thông tin'}`,
            { sticky: true, className: 'station-tooltip' }
          ).openTooltip();
        })
        .on('mouseout', function() {
          // Đóng tooltip khi di chuột ra ngoài
          this.closeTooltip();
        });

      markers[station.name_tramsac.toLowerCase()] = marker;
    } else {
      console.warn('Station missing coordinates:', station);
    }
  });
}


    function updateStationDetails(station) {
  const ports = station.charging_ports || [];
  const uniquePorts = ports.map(port => port.cong_sac).join(', ') || 'Không có thông tin';
  const cars = ports.flatMap(port => port.cars) || [];

  // Tạo các tiện ích bổ sung
  const additionalFeatures = station.additional_features || [];
  const additionalFeaturesHtml = additionalFeatures.length 
    ? `<ul>${additionalFeatures.map(feature => `<li>${feature}</li>`).join('')}</ul>`
    : '<p>Không có tiện ích bổ sung.</p>';

  // Tạo phần đánh giá người dùng
  const userRatings = station.user_ratings || [];
  const userRatingsHtml = userRatings.length 
    ? userRatings.map(rating => `<p><strong>${rating.user}</strong>: ${rating.comment} (Điểm: ${rating.score})</p>`).join('')
    : '<p>Chưa có đánh giá nào.</p>';

  // Cập nhật nội dung chi tiết trạm sạc
  stationDetails.innerHTML = `
    <span class="close-btn" id="close-details">X</span>
    <h4>${station.name_tramsac}</h4>
    <p><strong>Địa chỉ:</strong> ${station.address || 'Không có thông tin'}</p>
    <p><strong>Loại xe:</strong> ${cars.map(car => car.name).join(', ') || 'Không có thông tin'}</p>
    <p><strong>Cổng sạc:</strong> ${uniquePorts}</p>
    ${station.image ? '<img src="data:image;base64,' + station.image + '" alt="image">' : ''}
    
    <div>
      <h5><i class="fas fa-cogs"></i> Tiện ích bổ sung:</h5>
      ${additionalFeaturesHtml}
    </div>

    <div>
      <h5><i class="fas fa-star"></i> Đánh giá người dùng:</h5>
      ${userRatingsHtml}
    </div>

    <div>
      <a href="#" class="action-btn" onclick="getRouteToLocation(${station.map_lat}, ${station.map_lon})">
        <i class="fas fa-directions"></i> Chỉ đường
      </a>
      <a href="#" class="action-btn" onclick="shareStationLocation(${station.map_lat}, ${station.map_lon})">
        <i class="fas fa-share-alt"></i> Chia sẻ
      </a>
    </div>
  `;
  
  // Hiển thị chi tiết trạm
  stationDetails.style.display = 'block';

  // Đóng chi tiết trạm
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
          return;
        }

        for (var stationName in markers) {
          if (stationName.includes(searchQuery)) {
            markers[stationName].addTo(map);
            foundMarker = true;
          } else {
            map.removeLayer(markers[stationName]);
          }
        }

        if (!foundMarker) {
          alert('Không tìm thấy trạm sạc nào với tên "' + event.target.value + '".');
        }
      });

      document.getElementById('car-type-select').addEventListener('change', function(event) {
    var selectedType = event.target.value.toLowerCase(); // Lấy loại xe đã chọn
    var filteredStations = stations.filter(function(station) {
        // Lọc trạm có chứa xe thuộc loại đã chọn
        return selectedType === 'all' || station.charging_ports.some(function(port) {
            return port.cars.some(function(car) {
                return car.name.toLowerCase() === selectedType;
            });
        });
    });

    // Cập nhật bản đồ
    for (var stationName in markers) {
        var marker = markers[stationName];
        var station = stations.find(st => st.name_tramsac.toLowerCase() === stationName);
        if (filteredStations.includes(station)) {
            marker.addTo(map).setOpacity(1); // Hiển thị trạm
            // Nhảy đến vị trí trạm sạc đầu tiên trong danh sách và hiển thị chi tiết
            map.setView([station.map_lat, station.map_lon], 15);
            updateStationDetails(station);
        } else {
            map.removeLayer(marker); // Ẩn trạm
        }
    }
});


    }

    window.onload = function() {
      createMarkers();
      handleUrlParams();
      initializeSearch();
    };
  </script>
@endsection
