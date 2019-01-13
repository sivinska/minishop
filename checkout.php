<?php
session_start();
require_once("db_connection.php");
include("header.php");
include("nav.php");

echo $_SESSION['username'];

if (empty($_SESSION['username']))
{
    echo "You need to log in fist!";
    header ('location: login.php');
}
else{

$sql = "INSERT INTO basket VALUES (NULL, '". $_SESSION['username'] ."')";
if (mysqli_query($connection, $sql)) {
	$id_basket = mysqli_insert_id($connection);
}

$user = $_SESSION['username'];

$sql = "SELECT id FROM users WHERE username='$user'";
$array = mysqli_query($connection, $sql);
foreach ($_SESSION["shopping_cart"] as $product){
    echo $product["title"];
    $user = $_SESSION['username'];
    $code = $product['code'];
    $quantity = $product['quantity'];
    $price = $product['price'];


    $sql = "INSERT INTO order_items VALUES (NULL, '". $user ."', $id_basket, '". $code ."', $quantity, $price )";
    $result = mysqli_query($connection, $sql);
    var_dump($result);

}

$_SESSION['shopping_cart'] = NULL;

header('location: index.php');
}

?>
