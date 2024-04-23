<?php
session_start();
require 'vars.php';
?>
<html>
    <head>
        <link rel="stylesheet" href="/CSS/index.css">
    </head>
    <body>
        <div class="login">
            <h1>Welcome Aboard</h1>
            <h2>Please Login to Continue</h2>
            <form action="auth.php" method="post">
                <label>Email</label><br>
                <input type="email" name="email" required>
                <br><br><label>Password</label><br>
                <input type="password" name="password" required>
                <br><br><input type="submit">
            </form>
            <h3>First Time? <a href="signup.php">SignUp</a></h3>
        </div>
    </body>
</html>