<?php
require_once "Connect.php";

$conn = openConnection();

$sql = "SELECT * FROM spots";
$result = $conn->query($sql);

if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        echo "pid: " . $row["pid"] . "<br />address: " . $row["address"] . "<br/>latitude, longitude: " . $row["latitude"] . ", " . $row["longitude"] . "<br />";
    }
}
else{
    echo "No spots found.";
}
?>