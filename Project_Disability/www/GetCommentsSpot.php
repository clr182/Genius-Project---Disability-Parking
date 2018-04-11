<?php
require_once "Connect.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $conn = openConnection();

    if(!(isset($_POST['pid']))){
        echo "pid is empty!";

        return null;
    }
    else{
        $pid = $_POST['pid'];

        // Get spots within the frame in latitude and longitude
        $sql = "SELECT * FROM comments WHERE pid = ?";
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("i", $pid);
            $stmt->execute();
            $result = $stmt->get_result();

            $comment = $result->fetch_assoc();

            $xml = generateXML($comment);

            return $xml;
        }
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
        foreach($markersArray as $row){
            $node = $dom->createElement("marker");
            $newnode = $parnode->appendChild($node);
            $newnode->setAttribute("id", $row['cid']);
            $newnode->setAttribute("pid", $row['pid']);
            $newnode->setAttribute("text", $row['text']);
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