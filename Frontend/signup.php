<?php

$servername = "localhost";
$username = "king";
$password = "1234";
$database = "minor";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection Error: " . mysqli_connect_error());
}

if(isset($_POST["name"])){
$name = $_POST["name"];
$email = $_POST["email"];
$address = $_POST["address"];
$age = $_POST["age"];
$zipcode = $_POST["zipcode"];
$gender = $_POST["gender"];
$password = $_POST["pass"];

$sql = "insert into users(email, password, name, address, zipcode, age, gender) values('$email', '$password', '$name', '$address', '$zipcode', '$age', '$gender');";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Error in the query: ' . mysqli_error($conn));
}else{
    echo "<h2> Signup Success </h2>";
}
}
?>

<html>
    <head>
        <link rel="stylesheet" href="/CSS/signup.css">
    </head>
    <body>
        <div class="login">
            <h1>SignUp</h1>
            <form action=" " method="post">
                <label>Name</label><br>
                <input type="input" name="name" pattern="[A-Z]{1}-[a-z]{*}" required>
                <label>Age</label><br>
                <input type="input" name="age" pattern="[0-9]{2}" required>
                <label>Gender</label><br>
                <select name="gender">
                    <option value="F">F</option>
                    <option value="M">M</option>
                </select><br>
                <label>Address</label><br>
                <input type="input" name="address" required>
                <label>Zipcode</label><br>
                <input type="input" name="zipcode" pattern="[0-9]{6}" required>
                <label>Email</label><br>
                <input type="email" name="email" required>
                <br><label>Password</label><br>
                <input type="password" name="pass" required>
                <br><br><input type="submit">
            </form>
            <h3>Already Signed Up? <a href="index.php">Login</a></h3>
        </div>
    </body>
</html>