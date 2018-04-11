<?php
require_once "Connect.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $conn = openConnection();

    if(!(isset($_POST['cid']))){
        echo "cid is not set!";

        var_dump($_POST);

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

        $cid = $_POST['cid'];

        // Check if this spot exists
        $sql = "SELECT cid FROM comments WHERE cid = ?";
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("i", $cid);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                // Check if the user has already reported this spot
                $sql= "SELECT rid FROM reports WHERE cid = ? AND ip = ?";
                if($stmt = $conn->prepare($sql)){
                    $stmt->bind_param("is", $cid, $ip);
                    $stmt->execute();
                    $result = $stmt->get_result();
                
                    if($result->num_rows > 0){
                        echo "The user has already reported this spot.";

                        return null;
                    }
                    else{
                        // Send the report to the database
                        $sql = "INSERT INTO reports(ip, cid) VALUES (?, ?)";
                        if($stmt = $conn->prepare($sql)){
                            $stmt->bind_param("si", $ip, $cid);
                            $stmt->execute();
                        }
                    }
                }
            }
            else{
                echo "The reported spot doesn't exist.";

                return null;
            }
        }
    }
}
?>