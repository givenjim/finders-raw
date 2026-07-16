<?php
session_start();
include("db/config.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$sender_id   = $_SESSION["user_id"];
$receiver_id = $_POST["receiver_id"];
$message     = $_POST["message"];

$order_id = $_POST["order_id"] ?? null;
$gig_id   = $_POST["gig_id"] ?? null;

// Insert message
$stmt = $conn->prepare("
INSERT INTO messages (sender_id, receiver_id, message, order_id, gig_id)
VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param("iisii", $sender_id, $receiver_id, $message, $order_id, $gig_id);
$stmt->execute();

// Redirect back
$url = "message.php?user_id=".$receiver_id;

if ($order_id) {
    $url .= "&order_id=".$order_id;
}

if ($gig_id) {
    $url .= "&gig_id=".$gig_id;
}

header("Location: $url");
exit();