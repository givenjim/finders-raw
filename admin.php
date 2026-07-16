<?php
session_start();
include("db/config.php");

if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"]!="admin"){
    header("Location: login.html");
    exit();
}

$users = mysqli_query($conn,"SELECT * FROM users");
$products = mysqli_query($conn,"SELECT * FROM products");
$gigs = mysqli_query($conn,"SELECT * FROM gigs");
$orders = mysqli_query($conn,"SELECT * FROM orders");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Panel | Finders</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/admin_navbar.php"); ?>

<section class="dashboard">

<h2>Admin Panel</h2>

<div class="dash-card">Users: <?php echo mysqli_num_rows($users); ?></div>
<div class="dash-card">Services: <?php echo mysqli_num_rows($products); ?></div>
<div class="dash-card">Gigs: <?php echo mysqli_num_rows($gigs); ?></div>
<div class="dash-card">Orders: <?php echo mysqli_num_rows($orders); ?></div>

</section>

</body>
</html>
