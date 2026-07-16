<?php
session_start();
include("db/config.php");

if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"] != "worker"){
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION["user_id"];

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $id = $_POST["id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $category = $_POST["category"];

    // ✅ Ensure ownership
    $check = $conn->query(
        "SELECT * FROM products 
         WHERE id='$id' 
         AND user_id='$user_id'"
    );

    if($check->num_rows > 0){

        $stmt = $conn->prepare(
            "UPDATE products 
             SET title=?, description=?, price=?, category=? 
             WHERE id=?"
        );

        $stmt->bind_param("ssdsi", $title, $description, $price, $category, $id);
        $stmt->execute();
    }
}

header("Location: dashboard.php");
exit();
?>