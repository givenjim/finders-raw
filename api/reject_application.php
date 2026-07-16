<?php
session_start();
include("../db/config.php");

$id = $_GET["id"];

$conn->query(
"UPDATE applications
SET status='rejected'
WHERE id='$id'"
);

header("Location: ../employer_applications.php");
exit();
?>