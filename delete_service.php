<?php
session_start();
include("db/config.php");

if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"] != "worker"){
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION["user_id"];

if(isset($_GET["id"])){

    $service_id = $_GET["id"];

    // ✅ Ensure user owns the service
    $check = $conn->query(
        "SELECT * FROM products 
         WHERE id='$service_id' 
         AND user_id='$user_id'"
    );

    if($check->num_rows > 0){
        $conn->query("DELETE FROM products WHERE id='$service_id'");
    }
}

header("Location: dashboard.php");
exit();
?>