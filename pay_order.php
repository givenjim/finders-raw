<?php
session_start();
include("db/config.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $order_id = $_POST["order_id"];
    $amount   = $_POST["amount"];
    $method   = "Simulated";

    // ✅ Insert payment (MATCHES YOUR TABLE STRUCTURE)
    $stmt = $conn->prepare(
        "INSERT INTO payments (order_id, method, amount, status)
         VALUES (?, ?, ?, 'success')"
    );

    $stmt->bind_param("isd", $order_id, $method, $amount);
    $stmt->execute();

    // ✅ Update order status
    $conn->query(
        "UPDATE orders SET status='paid' WHERE id='$order_id'"
    );

    header("Location: dashboard.php?paid=1");
    exit();
}
?>