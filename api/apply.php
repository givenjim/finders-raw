<?php
session_start();
include("../db/config.php");

if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"]!="worker"){
    die("Unauthorized");
}

$worker_id = $_SESSION["user_id"];
$gig_id = intval($_POST["gig_id"]);
$cover = mysqli_real_escape_string($conn,$_POST["cover_letter"]);

// $gig = $conn->query("SELECT employer_id FROM gigs WHERE id='$gig_id'");
// $g = $gig->fetch_assoc();

// $employer_id = $g["employer_id"];

$conn->query("
 INSERT INTO applications (gig_id,worker_id,cover_letter,status)
 VALUES ('$gig_id','$worker_id','$cover','pending')
");

$conn->query("
INSERT INTO applications
(gig_id,worker_id,cover_letter,status)
VALUES
('$gig_id','$worker_id','$cover','pending')
");

header("Location: ../worker_applications.php");
exit();