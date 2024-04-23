<?php 
session_start();
require 'vars.php';
$user = unserialize($_SESSION["User"]);
?>

<html>
    <head>
        <link rel="stylesheet" href="/CSS/user.css">
        <script src="https://kit.fontawesome.com/4db2b05c4a.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="menu">
            <div class="items">
                <h1>AAR Electronics</h1>  
            </div>
            <div class="items">
                <form action="search.php" method="post">
                    <input type="search" name="gsearch">
                    <button type="submit" class="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="items">
                <a href="user.php" class="icon"><i class="fa-solid fa-user fa-xl"></i></a>
                <a href="checkout.php" class="icon"><i class="fa-solid fa-cart-shopping fa-xl"></i></a>
            </div>
        </div>
        <div class="login">
            <h1>Account Info:</h1>
            <h2>Name: <?= $user->name ?> </h2>
            <h2><?= $user->age ?>Yrs , <?= $user->gender?></h2> 
            <h2>Email: <?= $user->email ?></h2>
            <h2>Address: <?= $user->address ?></h2>
            <h2>Zip: <?= $user->zipcode ?></h2>
        </div>
    </body>
</html>