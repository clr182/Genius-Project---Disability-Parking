<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'gocar');

/**
 * Open the database connection
 */
function openConnection(){
    // Create connection
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Set connection to UTF-8 because weird characters and stuff
    mysqli_query($conn, "SET NAME 'utf8'");

    // Check the connection
    if($conn == false){
        dir("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}
?>