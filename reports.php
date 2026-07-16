<?php
session_start();
include("db/config.php");

if($_SESSION["user_role"]!="admin"){
    header("Location: login.html");
    exit();
}

$orders = mysqli_query($conn,"SELECT * FROM orders");
?>

<!DOCTYPE html>
<html>
<head>
<title>Reports | Finders</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<nav class="navbar">
<div class="logo">Reports</div>
<a href="admin.php">Back</a>
</nav>

<section class="dashboard">

<h2>Orders Report</h2>

<?php while($o=mysqli_fetch_assoc($orders)): ?>
<div class="dash-card">
Order #<?php echo $o["id"]; ?> — $<?php echo $o["total_amount"]; ?>
</div>
<?php endwhile; ?>

</section>

</body>
</html>
