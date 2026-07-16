<?php
session_start();
include("db/config.php");

$cart = $_SESSION["cart"] ?? [];

?>

<!DOCTYPE html>
<html>
<head>
<title>Cart | Finders</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/navbar.php"); ?>

<section class="cart">

<h2>Your Cart <i class="fa-solid fa-cart-arrow-down"></i></h2>

<?php if(count($cart)==0): ?>

<p>Your cart is empty</p>

<?php else: ?>

<?php
$total = 0;

foreach($cart as $id){

$result = mysqli_query($conn,"SELECT * FROM products WHERE id=$id");
$row = mysqli_fetch_assoc($result);

$total += $row["price"];
?>

<div class="cart-item">

<img src="uploads/<?php echo $row['image']; ?>">

<div class="cart-info">
    <h4><?php echo $row["title"]; ?></h4>
    <p>Ksh.<?php echo $row["price"]; ?></p>
</div>

<form method="POST" action="remove_from_cart.php">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <button class="remove-btn">
        <i class="fa-solid fa-trash"></i>
    </button>
</form>

</div>
</div>

<?php } ?>

<h3>Total: Ksh. <?php echo $total; ?></h3>

<a href="checkout.php">Proceed To Checkout</a>


<?php endif; ?>

</section>

</body>
</html>
