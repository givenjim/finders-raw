<?php
session_start();
include("../db/config.php");

if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin"){
    header("Location: ../login.html");
    exit();
}

$id = $_GET["id"];

$conn->query("DELETE FROM gigs WHERE id='$id'");

header("Location: ../admin_gigs.php");
exit();
?>