<!DOCTYPE html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>Spot adder test</title>
</head>

<body>
    <div id="spot_adder">
        <form action="<?php echo htmlspecialchars('AddSpot.php'); ?>" method="post" enctype="multipart/form-data">
            <center><h2>Spot adder</h2></center>
            Add image <input type="file" name="spot_image" id="spot_image">
            <input name="address" placeholder="Spot address">
            <input name="latitude" placeholder="Spot latitude">
            <input name="longitude" placeholder="Spot longitude">
            <button type="submit" name="add_event">Submit spot</button>
        </form>
    </div>
</body>