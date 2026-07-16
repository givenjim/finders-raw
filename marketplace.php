<?php
session_start();
include("db/config.php");

$role = $_SESSION["user_role"] ?? "guest";

?>

<!DOCTYPE html>
<html>
<head>
<title>Marketplace | Finders</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/navbar.php"); ?>

<section class="marketplace">

<?php if($role=="worker"): ?>

<h2>Available Gigs</h2>

<?php
$gigs = $conn->query("SELECT * FROM gigs ORDER BY id DESC");
?>

<div class="product-grid">

<?php while($g = mysqli_fetch_assoc($gigs)): ?>

<div class="product-card">

<h3><?php echo $g["title"]; ?></h3>

<p><?php echo $g["description"]; ?></p>

<strong>KES <?php echo $g["budget"]; ?></strong>

<a class="btn-small" href="apply.php?gig_id=<?php echo $g["id"]; ?>">
Apply
</a>

</div>

<?php endwhile; ?>

</div>

<?php else: ?>

<h2>Available Services</h2>

<?php
$products = $conn->query(
"SELECT products.*, users.name 
FROM products 
JOIN users ON products.user_id = users.id
WHERE products.status='active'
ORDER BY products.id DESC"
);
?>

<div class="product-grid">

<?php while($row = mysqli_fetch_assoc($products)): ?>

<div class="product-card">

<img src="uploads/<?php echo $row['image']; ?>">

<h3><?php echo $row['title']; ?></h3>

<p><?php echo $row['category']; ?></p>

<p>By: <?php echo $row['name']; ?></p>

<strong>KES <?php echo $row['price']; ?></strong>

<a class="btn-small" href="service.php?id=<?php echo $row['id']; ?>">View Details</a>

</div>

<?php endwhile; ?>

</div>

<?php endif; ?>

</section>

</body>
</html>