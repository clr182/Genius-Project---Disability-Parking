<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Unformatted PHP Display All records Example</title>
</head>
<body>
<?php
/* Validate and assign input data */
/* As displaying all records does not require any input from the calling webpage, we do not need any input values */ 



/* Include "configuration.php" file */
require_once "Connect.php";



/* Connect to the database */
$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception



/* Perform Query */
$query = "SELECT  FROM gocar";
$statement = $dbConnection->prepare($query);
$statement->execute();



/* Manipulate the query result */
$result = $statement->fetchAll(PDO::FETCH_OBJ);
foreach($result as $row) 
{
    echo $row->Location. $row->TimeStamp;
}
?> 
</body>
</html>