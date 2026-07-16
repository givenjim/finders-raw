<?php
session_start();
include("../db/config.php");

if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin"){
    exit("Unauthorized");
}

$id = $_POST["id"];

$check = $conn->query("SELECT status FROM users WHERE id='$id'");
$row = $check->fetch_assoc();

$newStatus = $row["status"] === "active" ? "suspended" : "active";

$conn->query("UPDATE users SET status='$newStatus' WHERE id='$id'");

header("Location: ../admin_users.php");
