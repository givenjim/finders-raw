<?php
session_start();
include("db/config.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$id   = $_SESSION["user_id"];
$role = $_SESSION["user_role"]; // ✅ FIXED

// =======================
// FETCH VERIFICATION STATUS
// =======================
$userQ = $conn->query("SELECT email_verified, phone_verified FROM users WHERE id='$id'");
$user  = $userQ->fetch_assoc();

// =======================
// FETCH EMPLOYER ORDERS
// =======================
$orders = null;
if ($role === "employer") {
    $orders = $conn->query(
        "SELECT * FROM orders 
         WHERE buyer_id='$id' 
         ORDER BY id DESC"
    );
}

// =======================
// FETCH WORKER SERVICES
// =======================
$services = null;
if ($role === "worker") {
    $services = $conn->query(
        "SELECT * FROM products 
         WHERE user_id='$id' 
         ORDER BY id DESC"
    );
}

// =======================
// FETCH EMPLOYER GIGS
// =======================
$gigs = null;
if ($role === "employer") {
    $gigs = $conn->query(
        "SELECT * FROM gigs 
         WHERE employer_id='$id' 
         ORDER BY id DESC"
    );
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Dashboard | Finders</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/navbar.php"); ?>

<section class="dashboard">

<h2>Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?></h2>

<div class="verify-box">
<p>Email: <?php echo $user["email_verified"] ? "Verified <i class='fa-solid fa-circle-check' style='color: #0a8f55 ; font-size: 18px;'></i>" : "Not Verified <i class='fa-solid fa-circle-xmark' style='color: #8B0000 ; font-size: 18px;'></i>"; ?></p>
<p>Phone: <?php echo $user["phone_verified"] ? "Verified <i class='fa-solid fa-circle-check' style='color: #0a8f55 ; font-size: 18px;'></i>" : "Not Verified <i class='fa-solid fa-circle-xmark' style='color: #8B0000 ; font-size: 18px;'></i>"; ?></p>
</div>

<!-- ===================== -->
<!-- EMPLOYER ORDERS -->
<!-- ===================== -->
<?php if($role=="employer"): ?>
<h3>Your Orders</h3>

<?php if($orders && $orders->num_rows > 0): ?>
    <?php while($o = mysqli_fetch_assoc($orders)): ?>
        <div class="dash-card">
            <strong>Order #<?php echo $o["id"]; ?></strong><br>
            Amount: KES <?php echo $o["total_amount"]; ?><br>
            Status: <?php echo ucfirst($o["status"]); ?>

<?php if($o["status"] == "pending"): ?>
<br><br>
<!-- <br><br> -->


<?php
$workerQ = $conn->query("SELECT seller_id FROM order_items WHERE order_id='{$o["id"]}' LIMIT 1");
$worker = $workerQ->fetch_assoc();
?>

<a href="message.php?user_id=<?php echo $worker["seller_id"]; ?>&order_id=<?php echo $o["id"]; ?>" 
   class="btn-small">
   Message Worker
</a>

<div class="action-buttons">

    <!-- Pay Now -->
    <form method="POST" action="pay_order.php">
        <input type="hidden" name="order_id" value="<?php echo $o["id"]; ?>">
        <input type="hidden" name="amount" value="<?php echo $o["total_amount"]; ?>">
        
        <button type="submit" class="btn-small">
            Confirm Payment
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
<?php endif; ?>

<!-- ===================== -->
<!-- WORKER SERVICES -->
<!-- ===================== -->
<?php if($role=="worker"): ?>
<h3>Your Services</h3>

<?php if($services && $services->num_rows > 0): ?>
    <?php while($s = mysqli_fetch_assoc($services)): ?>
        <div class="dash-card">
    <?php echo htmlspecialchars($s["title"]); ?> - KES <?php echo $s["price"]; ?>

    <br><br>

    <a href="edit_service.php?id=<?php echo $s["id"]; ?>" class="btn-small">Edit</a>

    <a href="delete_service.php?id=<?php echo $s["id"]; ?>" 
       class="btn-small"
       onclick="return confirm('Delete this service?')">
       Delete
    </a>
</div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No services yet.</p>
<?php endif; ?>
<?php endif; ?>

<!-- ===================== -->
<!-- WORKER ORDERS -->
<!-- ===================== -->

<?php if($role=="worker"): ?>

<h3>Orders From Employers</h3>

<?php
$worker_orders = $conn->query(
"SELECT order_items.*, orders.status, orders.buyer_id, users.name AS buyer_name
FROM order_items
JOIN orders ON order_items.order_id = orders.id
JOIN users ON orders.buyer_id = users.id
WHERE order_items.seller_id='$id'
ORDER BY order_items.id DESC"
);
?>

<?php if($worker_orders && $worker_orders->num_rows > 0): ?>

<?php while($wo = mysqli_fetch_assoc($worker_orders)): ?>

<div class="dash-card">

<strong>Order #<?php echo $wo["order_id"]; ?></strong><br>

Buyer: <?php echo htmlspecialchars($wo["buyer_name"]); ?><br>

Price: KES <?php echo $wo["price"]; ?><br>

Status: <?php echo ucfirst($wo["status"]); ?>

<?php if($wo["status"] == "paid"): ?>
<br><br>
<!-- <br><br> -->

<a href="message.php?user_id=<?php echo $wo["buyer_id"]; ?>&order_id=<?php echo $wo["order_id"]; ?>" 
   class="btn-small">
   Message Employer
</a>
<a href="api/complete_order.php?id=<?php echo $wo["order_id"]; ?>" class="btn-small btn-complete">
Mark as Completed
</a>
<?php endif; ?>

</div>

<?php endwhile; ?>

<?php else: ?>

<p>No orders yet.</p>

<?php endif; ?>

<?php endif; ?>

<!-- ===================== -->
<!-- EMPLOYER GIGS -->
<!-- ===================== -->
<?php if($role=="employer"): ?>
<h3>Your Gigs</h3>

<!-- <a href="employer_applications.php" class="btn-small">
View Applications
</a> -->
<br>
<a href="employer_applications.php" class="btn-small">View Applications</a>
<br>

<?php if($gigs && $gigs->num_rows > 0): ?>
    <?php while($g = mysqli_fetch_assoc($gigs)): ?>
        <div class="dash-card">
            <?php echo htmlspecialchars($g["title"]); ?> - Budget: KES <?php echo $g["budget"]; ?>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No gigs yet.</p>
<?php endif; ?>
<?php endif; ?>

</section>

</body>
</html>
