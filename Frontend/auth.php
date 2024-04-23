<?php
session_start();
require 'vars.php';

$servername = "localhost";
$username = "king";
$password = "1234";
$database = "minor";

$_SESSION["User"];
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection Error: " . mysqli_connect_error());
}

$mail = $_POST["email"];
$pass = $_POST["password"];
echo $mail;
echo $pass;
$sql = "Select * From users Where email = '$mail' ;";
echo $sql;
echo "<br>";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$password = $row["password"];
echo $row["id"] . $row["name"] ." " . $row["email"] . " " . $row["address"] . " " . $row["zipcode"] . "  " . $row["gender"] . "  " . $row["age"];
echo "<br>";

if($password == $pass){
    $user = new User($row["user_id"],$row["name"],$row["email"],$row["address"],$row["zipcode"],$row["gender"],$row["age"]);
    $_SESSION['User'] = serialize($user);
    print_r($_SESSION);
    echo "<br>";
    echo "Accepted";
    header("Location: menu.php");
}else{
    //header("Location: deny.php");
    echo "Denied";
}


mysqli_close($conn);
?>