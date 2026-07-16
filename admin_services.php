<?php
session_start();
include("db/config.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: login.html");
    exit();
}

// Fetch all services (stored as products)
$services = $conn->query(
    "SELECT p.id, p.title, p.price, u.name AS owner
     FROM products p
     JOIN users u ON p.user_id = u.id
     ORDER BY p.id DESC"
);

if (!$services) {
    die("Database error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin | Services</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/admin_navbar.php"); ?>

<section class="dashboard">
<h2>All Services</h2>

<?php if (mysqli_num_rows($services) == 0): ?>
    <p>No services found.</p>
<?php endif; ?>

<?php while ($s = mysqli_fetch_assoc($services)): ?>
<div class="dash-card">
<strong><?php echo htmlspecialchars($s["title"]); ?></strong><br>
Price: KES <?php echo $s["price"]; ?><br>
Provider: <?php echo htmlspecialchars($s["owner"]); ?>

<br><br>

<a href="admin_delete_service.php?id=<?php echo $s["id"]; ?>" 
   class="btn-small btn-danger"
   onclick="return confirm('Delete this service?')">
   Delete
</a>

</div>
<?php endwhile; ?>

</section>

</body>
</html>
