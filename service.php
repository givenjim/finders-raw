<?php
session_start();
include("db/config.php");

$id = $_GET["id"];

$result = mysqli_query($conn,
    "SELECT products.*, users.name 
     FROM products 
     JOIN users ON products.user_id = users.id 
     WHERE products.id=$id"
);

$product = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo $product["title"]; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/navbar.php"); ?>

<section class="service-details">

<img src="uploads/<?php echo $product['image']; ?>">

<div class="service-info">

<h2><?php echo $product["title"]; ?></h2>

<p><?php echo $product["description"]; ?></p>

<p>Category: <?php echo $product["category"]; ?></p>

<p>Seller: <?php echo $product["name"]; ?></p>

<h3>$<?php echo $product["price"]; ?></h3>

<form method="POST" action="add_to_cart.php">
<input type="hidden" name="id" value="<?php echo $product['id']; ?>">
<button type="submit">Add To Cart</button>
</form>

</div>

</section>

</body>
</html>
