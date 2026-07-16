<?php
session_start();
include("../db/config.php");

$employer_id = $_SESSION["user_id"];

$title = $_POST["title"];
$description = $_POST["description"];
$budget = $_POST["budget"];
$category = $_POST["category"];
$deadline = $_POST["deadline"];

$stmt = mysqli_prepare($conn,
    "INSERT INTO gigs(employer_id,title,description,budget,category,deadline)
     VALUES(?,?,?,?,?,?)"
);

mysqli_stmt_bind_param($stmt,"issdss",
    $employer_id,$title,$description,$budget,$category,$deadline
);

mysqli_stmt_execute($stmt);

header("Location: ../dashboard.php");
exit();
?>
