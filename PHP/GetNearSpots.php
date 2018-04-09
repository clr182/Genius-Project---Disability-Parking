<?php
require_once "Connect.php";

$conn = openConnection();

$latitude = 63.67;
$longitude = 22.7048;

// Get spots within 0.01 in latitude and longitude
$sql = "SELECT * FROM spots WHERE latitude <= ($latitude + 0.01) AND latitude >= ($latitude - 0.01) AND longitude <= ($longitude + 0.01) AND longitude >= ($longitude - 0.01)";
$result = $conn->query($sql);

$xml = generateXML($result);

return $xml;

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