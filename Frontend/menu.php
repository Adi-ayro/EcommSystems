<?php 
session_start();
require 'vars.php';
$user = unserialize($_SESSION["User"]);
$_SESSION["Cart"];

$apiUrl = 'http://localhost:8000/recommend/' . $user->id;
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

if ($response === false) {
    die('Curl error: ' . curl_error($ch));
}

$data = json_decode($response);
$data = json_decode($data, true);

if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    die('JSON decoding error: ' . json_last_error_msg());
}

if(isset($_POST["ProductID"])){
    $elem = new Cart($_POST["ProductID"],$_POST["CategoryID"],$_POST["Name"],$_POST["Price"]);
    $serializedElem = serialize($elem);
    $cartItems = $_SESSION["Cart"] ?? array();
    $cartItems[] = $serializedElem;
    $_SESSION["Cart"] = $cartItems;
}
?>

<html>
    <head>
        <link rel="stylesheet" href="/CSS/menu.css">
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
        <div class="offer">
            <div class="offerhead">
                <h2>Fresh Arrivals</h2>
                <h1>Microsoft Surface Pro 2</h1>
                <h3>Unleash your creativity with the Microsoft Surface Pro 2 - Your versatile companion for work and play, now at your fingertips!</h2>
                <button>Shop Now</button>
            </div>
            <div class="offerimg"><img src="/Images/laptop.png"></div>
        </div>
        <h1 style = "margin-left : 10px; font-family: 'Stick No Bills', sans-serif;">Recommended Products</h1>
        <?php
            foreach ($data as $entry) {
                $addr = " /Images/" . $entry['category_id'] . ".jpg";
        ?>

        <div class="item">
            <img src= <?= $addr ?> >
            <div class="item1">
                <div class="item2">
                    <h1><?= $entry['product_name'] ?></h1>
                    <h1>Rs.<?= $entry['price'] ?></h1>
                </div>
                <h2><?= $entry['description'] ?></h2>
                <form action=" " method="post">
                    <input type="hidden" name="ProductID" value="<?= $entry['product_id'] ?>">
                    <input type="hidden" name="CategoryID" value="<?= $entry['category_id'] ?>">
                    <input type="hidden" name="Name" value="<?= $entry['product_name'] ?>">
                    <input type="hidden" name="Price" value="<?= $entry['price'] ?>">
                    <input type="submit" value="AddToCart">
                </form>
            </div>
        </div>
            
        <?php    
            }
        ?>
    </body>
</html>