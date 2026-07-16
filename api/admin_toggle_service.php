<?php
session_start();
include("../db/config.php");

if($_SESSION["user_role"]!=="admin"){
    exit("Unauthorized");
}

$id=$_POST["id"];

$q=$conn->query("SELECT status FROM services WHERE id='$id'");
$r=$q->fetch_assoc();

$new = $r["status"]==="active" ? "inactive" : "active";
$conn->query("UPDATE services SET status='$new' WHERE id='$id'");

header("Location: ../admin_services.php");
