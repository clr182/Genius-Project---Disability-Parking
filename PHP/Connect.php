<?php
define('DB_SERVER', 'localhost'); // Temporary, ip address on the android emulator
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'gocar');

/**
 * Open the database connection
 */
function openConnection(){
    // Create connection
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check the connection
    if($conn == false){
        die("Connection failed: " . $conn->connect_error);
    }
    else{
        // Set connection to UTF-8 because weird characters and stuff
        mysqli_query($conn, "SET NAME 'utf8'");
    }

    return $conn;
}
?>