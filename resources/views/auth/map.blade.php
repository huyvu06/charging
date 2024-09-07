<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leaflet Map with Directions and Details</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
  <style>
    #map {
      width: 100%;
      height: 1000px; /* Thay đổi chiều cao nếu cần */
    }
    .popup-content img {
      max-width: 100px; /* Kích thước ảnh trong popup */
    }
  </style>
</head>
<body>
  <div id="map"></div>

  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
  <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
  <script>
    // Khởi tạo bản đồ với lớp dữ liệu OpenStreetMap
    var map = L.map('map').setView([21.0285, 105.8467], 12); // Trung tâm bản đồ mặc định

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18,
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var userLocationMarker;

    // Hàm để cập nhật vị trí hiện tại
    function updateMapWithCurrentLocation(lat, lon) {
      var currentLocation = [lat, lon];

      if (userLocationMarker) {
        map.removeLayer(userLocationMarker);
      }

      userLocationMarker = L.marker(currentLocation).addTo(map)
        .bindPopup('Vị trí của bạn')
        .openPopup();

      map.setView(currentLocation, 15); // Điều chỉnh cấp độ zoom nếu cần

      return currentLocation;
    }

    // Xử lý vị trí hiện tại nếu có
    function handleGeolocationError(error) {
      console.error('Error getting location:', error);
      alert('Không thể lấy vị trí hiện tại. Hãy kiểm tra quyền truy cập vị trí của trình duyệt.');
    }

    var userLatLon;

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        userLatLon = updateMapWithCurrentLocation(position.coords.latitude, position.coords.longitude);
      }, handleGeolocationError);
    } else {
      console.error('Geolocation is not supported by this browser.');
      alert('Trình duyệt không hỗ trợ Geolocation.');
    }

    // Thêm thanh tìm kiếm với Leaflet Control Geocoder
    L.Control.geocoder().addTo(map);

    // Dữ liệu mẫu cho các địa điểm
    var locations = [
      {
        lat: 21.0285,
        lon: 105.8467,
        name: "Địa điểm A",
        image: "https://via.placeholder.com/100"
      },
      {
        lat: 21.0375,
        lon: 105.8410,
        name: "Địa điểm B",
        image: "https://via.placeholder.com/100"
      }
    ];

    // Thêm các địa điểm vào bản đồ và thiết lập popup
    locations.forEach(function(location) {
      var marker = L.marker([location.lat, location.lon]).addTo(map)
        .bindPopup('<div class="popup-content">' +
          '<h4>' + location.name + '</h4>' +
          '<img src="' + location.image + '" alt="' + location.name + '" />' +
          '<button onclick="getRouteToLocation(' + location.lat + ', ' + location.lon + ')">Chỉ đường</button>' +
        '</div>');
    });

    // Hàm chỉ đường đến địa điểm
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
        createMarker: function() { return null; } // Không tạo marker cho các điểm trên tuyến đường
      }).addTo(map);
    }
  </script>
</body>
</html>
