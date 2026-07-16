<?php
session_start();
include("../db/config.php");

if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"] != "worker"){
    header("Location: ../login.html");
    exit();
}

$worker_id = $_SESSION["user_id"];
$order_id  = $_GET["id"];

// 🔐 SECURITY CHECK — ensure worker owns this order
$check = $conn->query("
SELECT * FROM order_items
WHERE order_id='$order_id' AND seller_id='$worker_id'
");

if($check->num_rows == 0){
    die("Unauthorized action");
}

// ✅ UPDATE ORDER STATUS
$conn->query("
UPDATE orders
SET status='completed'
WHERE id='$order_id'
");

// redirect back
header("Location: ../dashboard.php");
exit();
?>