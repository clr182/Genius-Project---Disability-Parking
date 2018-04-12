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
var userLocation = null;

var ipaddress = "192.168.182.30";

function initMap() {
    userLocation = new google.maps.LatLng(63.67419759459405, 22.705937792731675);
    map = new google.maps.Map(document.getElementById('map'), {
        center: userLocation,
        zoom: 16,
        mapTypeId: google.maps.MapTypeId.ROADMAP});

        openSpotPreview();

        downloadUrl('http://' + ipaddress + '/genius/GetNearestSpot.php', function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName('marker');
        Array.prototype.forEach.call(markers, function(markerElem) {
            var id = markerElem.getAttribute('id');
            var name = markerElem.getAttribute('address');
            var address = markerElem.getAttribute('address');
            var image = markerElem.getAttribute('image');
            var distance = markerElem.getAttribute('distance');
            var latitude = parseFloat(markerElem.getAttribute('lat'));
            var longitude = parseFloat(markerElem.getAttribute('lng'));
            var point = new google.maps.LatLng(
                latitude,
                longitude
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

            var dstnc = document.createElement('text');
            dstnc.textContent = Math.ceil(distance) + " meters away";
            infowincontent.appendChild(dstnc);
            infowincontent.appendChild(document.createElement('br'));

            var navigate_button = document.createElement('button');
            navigate_button.textContent = "Navigate";
            navigate_button.style.cssText = "display:block;margin-left:auto;margin-right:auto;";
            navigate_button.className = "button navigate_button";
            navigate_button.addEventListener('click', function() {
                navigateToSpot(id, latitude, longitude);
            });
            infowincontent.appendChild(navigate_button);

            var report_button = document.createElement('button');
            report_button.textContent = "Report";
            report_button.style.cssText = "display:block;margin-left:auto;margin-right:auto;";
            report_button.className = "button report_button";
            report_button.addEventListener('click', function() {
                reportSpot(id);
            });
            infowincontent.appendChild(report_button);

            var comments = document.createElement('table');
            comments.setAttribute("id", "comment_table_" + id);

            var row = document.createElement('tr');
            comments.appendChild(row);

            infowincontent.appendChild(comments);

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
        if(request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
        }
    };

    var position = map.getCenter();
    var latitude = position.lat();
    var longitude = position.lng();

    request.open('POST', url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send("latitude=" + latitude + "&longitude=" + longitude);
}

function doNothing(){};

function reportSpot(pid) {
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4) {
            if(xhr.responseText == "Success"){
                alert("Parking spot reported successfully!");
            }
            else if(xhr.responseText == "Reported"){
                alert("You have reported this parking spot already!");
            }
            else{
                alert("An error has happened. Try again later.");
            }
        }
    }

    xhr.open("POST", "http://" + ipaddress + "/genius/ReportSpot.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("pid=" + pid);
}

function navigateToSpot(pid, latitude, longitude) {
    window.open("geo:0,0?q=" + latitude + "," + longitude, "_system");
}

function openSpotPreview(infoWindow, infowincontent, map, marker, id){
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200){
            xhr.onreadystatechange = doNothing;
        }
    }

    xhr.open("POST", "GetCommentsSpot.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("id=" + id);
}