<?php
session_start();

$id = $_POST["id"];

if(!isset($_SESSION["cart"])){
    $_SESSION["cart"] = [];
}

$_SESSION["cart"][] = $id;

header("Location: cart.php");
exit();
?>
