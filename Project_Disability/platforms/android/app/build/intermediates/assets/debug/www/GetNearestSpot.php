<?php
require_once "Connect.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $conn = openConnection();

    if(!(isset($_POST['latitude']) && isset($_POST['longitude']))){
        echo "One or more variables are empty!";

        return null;
    }
    else{
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];

        // Get spots within the frame in latitude and longitude
        $sql = "SELECT * FROM spots WHERE latitude BETWEEN $latitude - 0.1 AND $latitude + 0.1 AND longitude BETWEEN $longitude - 0.1 AND $longitude + 0.1";
        $result = $conn->query($sql);

        $temp = sortNearestSpots($result, $latitude, $longitude);

        $xml = generateXML($temp);

        return $xml;
    }
}

    /**
     * Function to sort the spots by distance
     */
    function sortNearestSpots($markersArray, $latitude, $longitude){
        $spots = array();
        $distances = array();

        while($row = $markersArray->fetch_assoc()){
            $spots[] = $row;
        }

        // Calculate all distances
        for($i = 0; $i < count($spots); $i++){
            $latitudeSpot = $spots[$i]['latitude'];
            $longitudeSpot = $spots[$i]['longitude'];

            // Calculate distance to marker
            $distance = calculateGPSDistance($latitudeSpot, $longitudeSpot, $latitude, $longitude);
            $spots[$i]["distance"] = $distance;
        }

        // Bubble sort the markers by distance
        do {
            $swapped = false;
            for($i = 0; $i < count($spots) - 1; $i++){
                if($spots[$i]["distance"] > $spots[$i + 1]["distance"]){
                    list($spots[$i + 1], $spots[$i]) = array($spots[$i], $spots[$i + 1]);

                    $swapped = true;
                }
            }
        } while($swapped);

        return $spots;
    }

    /**
     * Function to transform the markers to XML
     */
    function generateXML($markersArray){
        // Start the XML file, create parent node
        $dom = new DOMDocument("1.0");
        $node = $dom->createElement("markers");
        $parnode = $dom->appendChild($node);

        // Iterate through the rows, adding XML nodes to each
        foreach($markersArray as $row){
            $node = $dom->createElement("marker");
            $newnode = $parnode->appendChild($node);
            $newnode->setAttribute("id", $row['pid']);
            $newnode->setAttribute("address", $row['address']);
            $newnode->setAttribute("lat", $row['latitude']);
            $newnode->setAttribute("lng", $row['longitude']);
            $newnode->setAttribute("image", $row['image']);
            $newnode->setAttribute("distance", $row['distance']);
        }

        header("Content-Type:text/xml");

        echo $dom->saveXML();

        return $dom->saveXML();
    }

    /**
     * Function to calculate the distance between 2 GPS coordinates
     */
    function calculateGPSDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo){
        $earthReadius = 6371000;

        // Convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $lonDelta = $lonTo - $lonFrom;

        $a = pow(cos($latTo) * sin($lonDelta), 2) +
            pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);

        return $angle * $earthReadius;
    }
?>