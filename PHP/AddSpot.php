<?php
require_once "Connect.php";

$spot = array("address"=>"", "latitude"=>"", "longitude"=>"", "image"=>"");
$image_dir = "images/";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $conn = openConnection();
    $uploadOk = false;

    // Check if all variables are filled
    if(!(isset($_POST['address']) && isset($_POST['latitude']) && isset($_POST['longitude']))){
        echo "One or more variables are missing.";
        var_dump($_POST);
        return;
    }

    $spot['address'] = $_POST['address'];
    $spot['latitude'] = $_POST['latitude'];
    $spot['longitude'] = $_POST['longitude'];

    // Validate image file
    if(isset($_FILES["spot_image"])){
        $image_file = $image_dir . basename($_FILES["spot_image"]["name"]);

        // Store the image file type
        $image_file_type = pathinfo($image_file, PATHINFO_EXTENSION);

        // Check the size in pixels of the image
        $check = getimagesize($_FILES["spot_image"]["tmp_name"]);
        if($check != false){
            $uploadOk = true;

            // Verify if the image has more than 2MB
            if($_FILES["spot_image"]["size"] > 2000000){
                $uploadOk = false;

                // Only allow certain types of image
                if($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif"){
                    $uploadOk = false;
                }
            }
        }
        else{
            $uploadOk = false;
        }
    }

    $sql = "INSERT INTO spots(address, latitude, longitude, image) VALUES (?, ?, ?, ?)";

    if($stmt = $conn->prepare($sql)){
        // Check if the image file is correct
        if($uploadOk){
            $temp = explode(".", $_FILES["spot_image"]["name"]);
            $newFileName = round(microtime(true)) . "." . end($temp);
            $image_file = $image_dir . $newFileName;

            // Upload the image
            if(move_uploaded_file($_FILES["spot_image"]["tmp_name"], $image_file)){
                $spot["image"] = $image_file;
            }
            else{
                echo "Error uploading image.";
            }
        }

        $stmt->bind_param("sdds", $spot["address"], $spot["latitude"], $spot["longitude"], $spot["image"]);

        if(!$stmt->execute()){
            echo "Error adding spot.";
        }
    }
}
?>