<?php
session_start();
include("db/config.php");

// ✅ Protect page
if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"] != "employer"){
    header("Location: login.html");
    exit();
}

$id   = $_SESSION["user_id"];
$role = $_SESSION["user_role"];

// ✅ Fetch employer orders
$orders = $conn->query(
    "SELECT * FROM orders 
     WHERE buyer_id='$id' 
     ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
<title>My Orders | Ajira</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/navbar.php"); ?>

<section class="dashboard">

<h2>My Orders</h2>

<?php if($orders && $orders->num_rows > 0): ?>

<?php while($o = mysqli_fetch_assoc($orders)): ?>

<div class="dash-card">

<strong>Order #<?php echo $o["id"]; ?></strong><br>

Amount: KES <?php echo $o["total_amount"]; ?><br>

Status: <?php echo ucfirst($o["status"]); ?>

<?php if($o["status"] == "pending"): ?>
<br><br>

<div class="action-buttons">

    <!-- Pay Now -->
    <form method="POST" action="pay_order.php">
        <input type="hidden" name="order_id" value="<?php echo $o["id"]; ?>">
        <input type="hidden" name="amount" value="<?php echo $o["total_amount"]; ?>">
        
        <button type="submit" class="btn-small">
            Pay Now
        </button>
    </form>

    <!-- Delete -->
    <a href="delete_order.php?id=<?php echo $o["id"]; ?>"
       class="btn-small btn-danger"
       onclick="return confirm('Are you sure you want to delete this order?')">
       Delete
    </a>

</div>

<?php endif; ?>

</div>

<?php endwhile; ?>

<?php else: ?>

<p>No orders yet.</p>

<?php endif; ?>

</section>

</body>
</html>