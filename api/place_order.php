<?php
session_start();
include("../db/config.php");

$user_id = $_SESSION["user_id"];
$cart = $_SESSION["cart"];

$total = 0;

foreach($cart as $id){
    $res = mysqli_query($conn,"SELECT price,user_id FROM products WHERE id=$id");
    $row = mysqli_fetch_assoc($res);
    $total += $row["price"];
}

$order = mysqli_prepare($conn,
    "INSERT INTO orders(buyer_id,total_amount) VALUES(?,?)"
);

mysqli_stmt_bind_param($order,"id",$user_id,$total);
mysqli_stmt_execute($order);

$order_id = mysqli_insert_id($conn);

foreach($cart as $id){
    $res = mysqli_query($conn,"SELECT price,user_id FROM products WHERE id=$id");
    $row = mysqli_fetch_assoc($res);
    $seller_id = $row["user_id"];

    $item = mysqli_prepare($conn,
        "INSERT INTO order_items(order_id,product_id,seller_id,quantity,price)
VALUES(?,?,?,?,?)"
    );

    $qty = 1;

    mysqli_stmt_bind_param($item,"iiiid",
    $order_id,$id,$seller_id,$qty,$row["price"]
    );

    mysqli_stmt_execute($item);
}

unset($_SESSION["cart"]);

header("Location: ../dashboard.php");
exit();
?>
