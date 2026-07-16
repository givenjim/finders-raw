<?php
include("db/config.php");

$id = $_GET["id"];
$action = $_GET["action"];

$conn->query("UPDATE payments SET status='$action' WHERE id='$id'");

header("Location: admin_payments.php");
exit();
?>