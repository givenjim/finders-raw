<?php
session_start();
include("../db/config.php");

$id = $_SESSION["user_id"];
$code = $_POST["code"];

$check = $conn->query(
"SELECT id FROM users 
 WHERE id='$id' AND email_code='$code'"
);

if($check->num_rows > 0){
$conn->query(
"UPDATE users SET email_verified=1 WHERE id='$id'"
);
echo "Email verified";
}else{
echo "Invalid code";
}
?>
