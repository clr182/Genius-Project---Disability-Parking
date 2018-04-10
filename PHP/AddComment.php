<?php
require_once "Connect.php";

$comment = array();

if($_SERVER["REQUEST_METHOD"] == "POST"){
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

    $conn = openConnection();

    // Check if all variables are filled
    if(!(isset($_POST['text']) && isset($_POST['pid']))){
        echo "One or more variables are missing.";
        var_dump($_POST);
        return;
    }

    $comment['text'] = $_POST['text'];
    $comment['pid'] = $_POST['pid'];

    $sql = "INSERT INTO comments(pid, text, user_ip) VALUES (?, ?, ?)";

    if($stmt = $conn->prepare($sql)){
        $stmt->bind_param("iss", $comment["pid"], $comment["text"], $comment["user_ip"]);

        if(!$stmt->execute()){
            echo "Error adding comment.";
        }
    }
}
?>