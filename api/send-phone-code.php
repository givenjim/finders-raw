<?php
session_start();
include("../db/config.php");

$id = $_SESSION["user_id"];
$code = rand(100000,999999);

$conn->query(
"UPDATE users SET phone_code='$code' WHERE id='$id'"
);

echo "Your phone code is: $code";
?>
