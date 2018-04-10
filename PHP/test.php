<!DOCTYPE html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>Google Maps API test</title>
    <style>
        #map {
            height: 95%;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div id="searchbar">
        <form action="<?php echo htmlspecialchars('GetNearestSpot.php'); ?>" method="post">
            Latitude: <input type="text" name="latitude">
            Longitude: <input type="text" name="longitude">
            <input type="submit" value="Submit">
        </form>
    </div>

    <div id="map"></div>

    <script>
        var customLabel = {
            spot: {
                label: 'P'
            }
        };

        var map = null;
        var lat1 = 0;
        var lat2 = 0;
        var lng1 = 0;
        var lng2 = 0;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: new google.maps.LatLng(63.675, 22.7048),
                zoom: 16,
                mapTypeId: google.maps.MapTypeId.ROADMAP});

                downloadUrl('GetAllSpots.php', function(data) {
                var xml = data.responseXML;
                var markers = xml.documentElement.getElementsByTagName('marker');
                Array.prototype.forEach.call(markers, function(markerElem) {
                    var id = markerElem.getAttribute('id');
                    var name = markerElem.getAttribute('address');
                    var address = markerElem.getAttribute('address');
                    var image = markerElem.getAttribute('image');
                    var point = new google.maps.LatLng(
                        parseFloat(markerElem.getAttribute('lat')),
                        parseFloat(markerElem.getAttribute('lng'))
                    );
                    var infowincontent = document.createElement('div');

                    var img = document.createElement('img');
                    img.src = image;
                    img.style.cssText = "display:block;margin-left:auto;margin-right:auto;height:100px;width:100px;";
                    infowincontent.appendChild(img);
                    infowincontent.appendChild(document.createElement('br'));

                    var strong = document.createElement('strong');
                    strong.textContent = name;
                    infowincontent.appendChild(strong);
                    infowincontent.appendChild(document.createElement('br'));

                    var text = document.createElement('text');
                    text.textContent = point;
                    infowincontent.appendChild(text);
                    infowincontent.appendChild(document.createElement('br'));

                    var button = document.createElement('button');
                    button.textContent = "Report";
                    button.style.cssText = "display:block;margin-left:auto;margin-right:auto;";
                    infowincontent.appendChild(button);

                    var icon = customLabel["spot"] || {};
                    var marker = new google.maps.Marker({
                        map: map,
                        position: point,
                        label: icon.label
                    });
                    marker.addListener('click', function() {
                        infoWindow.setContent(infowincontent);
                        infoWindow.open(map, marker);
                    });
                });
            });

            // TODO: add way to only load points within the current view

            var infoWindow = new google.maps.InfoWindow;
        }

        function downloadUrl(url, callback) {
            var request = new XMLHttpRequest();

            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    request.onreadystatechange = doNothing;
                    callback(request, request.status);
                }
            };

            request.open('GET', url, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(null);
        }

        function doNothing(){};
    </script>
    <script async defer 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFddZVW6vAvTEUKNQgoMlUIGYD6uzajIY&callback=initMap">
    </script>
</body>