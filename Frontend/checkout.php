<?php
session_start();
require 'vars.php';
$total = 0;

$user = unserialize($_SESSION["User"]);
?>

<html>
    <head>
        <link rel="stylesheet" href="/CSS/checkout.css">
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
                <a href="chekout.php" class="icon"><i class="fa-solid fa-cart-shopping fa-xl"></i></a>
            </div>
        </div>
        <div class="final">
            <div class="cart">
                <h1>Your Cart</h1>

<?php 
foreach($_SESSION["Cart"] as $a){
    $b = unserialize($a);
    $total = $total + $b->price;
?>
                <table>
                    <tr>
                        <td><?= $b->name ?></td>
                        <td>Rs. <?= $b->price ?></td>
                    </tr>

<?php
}
?>
                    <tr>
                        <td id="Total">Total:</td>
                        <td>Rs. <?= $total ?></td>
                    </tr>
                </table>
            </div>
            
            <div class="user">
                <h1>Shipping Details</h1>
                <h2>Name: <?= $user->name ?> </h2>
                <h2>Email: <?= $user->email ?></h2>
                <h2>Address:</h2>
                <h2><?= $user->address ?></h2>
                <h2><?= $user->zipcode ?></h2>
                <button onclick = "window.location.href = 'final.php';" >Confirm</button>
            </div>
        </div>
    </body>
</html>