<?php
include("db/config.php");

$id = $_GET["id"];

$conn->query("DELETE FROM products WHERE id='$id'");

header("Location: admin_services.php");
exit();
?>