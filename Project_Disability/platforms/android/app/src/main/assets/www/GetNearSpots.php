<?php
require_once "Connect.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $conn = openConnection();

    if(empty($_GET['lat1']) && empty($_GET['lat2']) && empty($_GET['lng1']) && empty($_GET['lng2'])){
        echo "One or more variables are empty!";

        return null;
    }
    else{
        $latitude1 = $_GET['lat1'];
        $latitude2 = $_GET['lat2'];
        $longitude1 = $_GET['lng1'];
        $longitude2 = $_GET['lng2'];

        // Get spots within the frame in latitude and longitude
        $sql = "SELECT * FROM spots WHERE latitude BETWEEN $latitude1 AND $latitude2 AND longitude BETWEEN $longitude1 AND $longitude2";
        $result = $conn->query($sql);

        $xml = generateXML($result);

        return null;
    }
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
        while($row = $markersArray->fetch_assoc()){
            $node = $dom->createElement("marker");
            $newnode = $parnode->appendChild($node);
            $newnode->setAttribute("id", $row['pid']);
            $newnode->setAttribute("address", $row['address']);
            $newnode->setAttribute("lat", $row['latitude']);
            $newnode->setAttribute("lng", $row['longitude']);
        }

        header("Content-Type:text/xml");

        echo $dom->saveXML();

        return $dom->saveXML();
    }
?>