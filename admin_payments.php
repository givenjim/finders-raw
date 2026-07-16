<?php
session_start();
include("db/config.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    die("Access denied");
}

$sql = "
SELECT 
    p.id AS payment_id,
    p.method,
    p.amount,
    p.status,
    p.created_at,
    o.id AS order_id,
    u.name AS buyer_name
FROM payments p
JOIN orders o ON p.order_id = o.id
JOIN users u ON o.buyer_id = u.id
ORDER BY p.id DESC
";

$result = $conn->query($sql);

if (!$result) {
    die('Database error: ' . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Payments | Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/admin_navbar.php"); ?>

<h2>All Payments</h2>

<?php if ($result->num_rows > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="dash-card">
            <strong>Payment #<?php echo $row["payment_id"]; ?></strong><br>
            Buyer: <?php echo htmlspecialchars($row["buyer_name"]); ?><br>
            Order ID: <?php echo $row["order_id"]; ?><br>
            Amount: KES <?php echo $row["amount"]; ?><br>
            Method: <?php echo ucfirst($row["method"]); ?><br>
            Status: <?php echo ucfirst($row["status"]); ?>

            <br><br>

<div class="action-buttons">

<a href="admin_update_payment.php?id=<?php echo $row["payment_id"]; ?>&action=success" 
   class="btn-small btn-success">
   Approve
</a>

<a href="admin_update_payment.php?id=<?php echo $row["payment_id"]; ?>&action=failed" 
   class="btn-small btn-danger">
   Reject
</a>

</div>
        </div>
        
    <?php endwhile; ?>
<?php else: ?>
    <p>No payments yet.</p>
<?php endif; ?>

</body>
</html>
