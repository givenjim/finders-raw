<?php
session_start();

if(!isset($_SESSION["user_id"])){
    header("Location: login.html");
    exit();
}

if(!isset($_SESSION["cart"]) || count($_SESSION["cart"])==0){
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout | Finders</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/navbar.php"); ?>

<section class="form-section">

<h2>Confirm Order</h2>
<br>

<form method="POST" action="api/place_order.php">

<button type="submit">Place Order</button>

</form>

</section>

</body>
</html>
