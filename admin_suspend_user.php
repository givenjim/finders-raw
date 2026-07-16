<?php
include("db/config.php");

$id = $_GET["id"];

$conn->query("UPDATE users SET status='suspended' WHERE id='$id'");

header("Location: admin_users.php");
exit();
?>