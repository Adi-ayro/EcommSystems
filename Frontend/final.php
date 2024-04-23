<?php
session_start();
require 'vars.php';

$servername = "localhost";
$username = "king";
$password = "1234";
$database = "minor";

$user = unserialize($_SESSION["User"]);
$_SESSION["Cart"];

$conn = mysqli_connect($servername, $username, $password, $database);
    
if (!$conn) {
    die("Connection Error: " . mysqli_connect_error());
}

    foreach ($_SESSION["Cart"] as $a) {
        $b = unserialize($a);
        $event_time = date("Y-m-d H:i:s");

        $sql = "INSERT INTO final (event_time, event_type, product_id, category_id, user_id) VALUES ('$event_time', 'purchase', '$b->id', '$b->category_id', '$user->id');";
        //echo $sql;
        //echo "<br>";
        
        $result = mysqli_query($conn, $sql);

    }
    
mysqli_close($conn);
session_destroy();
?>

<html>
    <head>
        <link rel="stylesheet" href="/CSS/final.css">
    </head>
    <body>
        <div class="login">
            <h1>Thank You</h1>
            <h2>Thanks a lot for Shopping with us. We will send you the order reciept and other details via your registered Email Id</h2>
        </div>
    </body>
</html>