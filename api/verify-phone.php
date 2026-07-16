<?php
session_start();
include("../db/config.php");

$id = $_SESSION["user_id"];
$code = $_POST["code"];

$check = $conn->query(
"SELECT id FROM users 
 WHERE id='$id' AND phone_code='$code'"
);

if($check->num_rows > 0){
$conn->query(
"UPDATE users SET phone_verified=1 WHERE id='$id'"
);
echo "Phone verified";
}else{
echo "Invalid code";
}
?>
