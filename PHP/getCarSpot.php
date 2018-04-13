<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once "Connect.php";
//if($_SERVER["REQUEST_METHOD"] == "POST"){
    $conn = openConnection();
    
    $sql = "SELECT PID FROM parked_car_location WHERE parked = 1";
    
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        echo "There are parked cars";
    }
    else {
        echo "There are no parked cars";
    }
//}

?>