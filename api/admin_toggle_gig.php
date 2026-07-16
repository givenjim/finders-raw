<?php
session_start();
include("../db/config.php");

// Protect admin
if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin"){
    header("Location: ../login.html");
    exit();
}

$id = $_POST["id"];

// Get current status
$res = $conn->query("SELECT status FROM gigs WHERE id='$id'");
$row = $res->fetch_assoc();

$current = $row["status"];

// Toggle using your existing logic (open / closed)
$new = ($current === "open") ? "closed" : "open";

// Update database
$conn->query("UPDATE gigs SET status='$new' WHERE id='$id'");

// Redirect back
header("Location: ../admin_gigs.php");
exit();
?>