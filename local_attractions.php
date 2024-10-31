<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>當地景點推薦</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBahhHzP-5sjeqGY7P0R62EynF0LAdy0R0&libraries=places"></script>
    <script>
        let map;
        let directionsService;
        let directionsRenderer;

        function initMap() {
            // 初始地圖位置
            const location = { lat: 25.038, lng: 121.5645 }; // 例如：台北市
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: location,
            });

            // 初始化路徑規劃服務
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);

            // 取得當地景點
            const service = new google.maps.places.PlacesService(map);
            service.nearbySearch({
                location: location,
                radius: 1500,
                type: ['tourist_attraction'], // 類型可以改為其他如 restaurant, park 等
            }, (results, status) => {
                if (status === google.maps.places.PlacesServiceStatus.OK) {
                    for (let i = 0; i < results.length; i++) {
                        createMarker(results[i]);
                    }
                }
            });
        }

        function createMarker(place) {
            const marker = new google.maps.Marker({
                map: map,
                position: place.geometry.location,
            });

            google.maps.event.addListener(marker, 'click', () => {
                new google.maps.InfoWindow({
                    content: place.name,
                }).open(map, marker);
            });

            // 在地圖上添加點擊事件以計算路線
            marker.addListener('click', function() {
                const request = {
                    origin: { lat: 25.038, lng: 121.5645 }, // 起點（你可以根據需要替換）
                    destination: place.geometry.location, // 目的地
                    travelMode: google.maps.TravelMode.DRIVING // 可以是 DRIVING、WALKING 等
                };

                directionsService.route(request, (result, status) => {
                    if (status == 'OK') {
                        directionsRenderer.setDirections(result);
                    }
                });
            });
        }
    </script>
</head>
<body onload="initMap()">
<nav>
        <ul>
            <li><a href="dashboard.php">儀表板</a></li>
            <li><a href="add_itinerary.php">新增行程</a></li>
            <li><a href="local_attractions.php">當地景點推薦</a></li> <!-- 新的連結 -->
            <li><a href="logout.php">登出</a></li>
        </ul>
    </nav>
    <div class="map-container">
        <h2>當地景點推薦</h2>
        <div id="map" style="height: 500px; width: 100%;"></div>
    </div>
</body>
</html>
