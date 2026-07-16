<?php
session_start();
include("db/config.php");

if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"]!="employer"){
    die("Unauthorized");
}

$id = intval($_GET["id"]);
$action = $_GET["action"];

if($action=="accept"){
$status = "accepted";
}

elseif($action=="reject"){
$status = "rejected";
}

else{
die("Invalid action");
}

$conn->query("UPDATE applications SET status='$status' WHERE id='$id'");

header("Location: employer_applications.php");
exit();