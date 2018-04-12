<?php
require_once "Connect.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $conn = openConnection();

    if(!(isset($_POST['pid']))){
        echo "pid is not set!";

        return null;
    }
    else{
        // Gets the user's IP address
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }        

        $pid = $_POST['pid'];

        // Check if this spot exists
        $sql = "SELECT pid FROM spots WHERE pid = ?";
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("i", $pid);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                // Check if the user has already reported this spot
                $sql= "SELECT rid FROM reports WHERE pid = ? AND ip = ?";
                if($stmt = $conn->prepare($sql)){
                    $stmt->bind_param("is", $pid, $ip);
                    $stmt->execute();
                    $result = $stmt->get_result();
                
                    if($result->num_rows > 0){
                        echo "The user has already reported this spot.";

                        echo "Reported";
                    }
                    else{
                        // Send the report to the database
                        $sql = "INSERT INTO reports(ip, pid) VALUES (?, ?)";
                        if($stmt = $conn->prepare($sql)){
                            $stmt->bind_param("si", $ip, $pid);
                            $stmt->execute();

                            echo "Success";
                        }
                    }
                }
            }
            else{
                // The reported spot doesn't exist
                echo "Error";
            }
        }
    }
}
?>