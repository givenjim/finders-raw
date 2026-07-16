<?php
session_start();
include("db/config.php");

if(!isset($_SESSION["user_id"])){
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION["user_id"];

if(isset($_GET["id"])){

    $order_id = $_GET["id"];

    // ✅ Ensure user owns the order AND it's still pending
    $check = $conn->query(
        "SELECT * FROM orders 
         WHERE id='$order_id' 
         AND buyer_id='$user_id' 
         AND status='pending'"
    );

    if($check->num_rows > 0){

        // 🔥 Delete order items first (important)
        $conn->query("DELETE FROM order_items WHERE order_id='$order_id'");

        // 🔥 Then delete order
        $conn->query("DELETE FROM orders WHERE id='$order_id'");

    }

}

header("Location: employer_orders.php");
exit();
?>