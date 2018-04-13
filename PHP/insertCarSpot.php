<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PHP Insert Example</title>
</head>
<body>
 hello 

<?php
/* Validate and assign input data */
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["Longitude"])){
        $Longitude = $_POST["Longitude"];
    }
    if(isset($_POST["Latitude"])){
        $Latitude = $_POST["Latitude"];
    }
}

$parked = true;


/* Include "configuration.php" file */
require_once "Connect.php";

/* Connect to the database */
$dbConnection= openConnection();

/* Perform Query */
$query = "INSERT INTO parked_car_location (Latitude, Longitude, parked) VALUES(?, ?, ?)";
$statement = $dbConnection->prepare($query);
$statement->bind_param("ddi", $Latitude, $Longitude, $parked);
if($statement->execute()){
    echo "<p>Record successfully added to database.</p>";
}
else {
    echo "<p>Record not added to database.</p>";
}


/* Provide a link for the user to proceed to a new webpage or automatically redirect to a new webpage */
//header("Location: " . $siteName . "/display_all_records_unformatted.php");
?>

</body>
</html>