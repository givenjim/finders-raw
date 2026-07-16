<?php
session_start();

$user_id = $_GET["user_id"];
$order_id = $_GET["order_id"] ?? null;
$gig_id = $_GET["gig_id"] ?? null;

$url = "message.php?user_id=".$user_id;

if ($order_id) {
    $url .= "&order_id=".$order_id;
}

if ($gig_id) {
    $url .= "&gig_id=".$gig_id;
}

header("Location: $url");
exit();