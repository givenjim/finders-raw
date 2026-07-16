<?php
session_start();
include("db/config.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: login.html");
    exit();
}

// Fetch all users
$users = $conn->query(
    "SELECT id, name, email, phone, role, email_verified, phone_verified 
     FROM users 
     ORDER BY id DESC"
);

if (!$users) {
    die("Database error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin | Users</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/admin_navbar.php"); ?>

<section class="dashboard">
<h2>All Users</h2>

<?php while ($u = mysqli_fetch_assoc($users)): ?>
<div class="dash-card">
<strong><?php echo htmlspecialchars($u["name"]); ?></strong><br>

Email: <?php echo $u["email"]; ?> 
(<?php echo $u["email_verified"] ? "Verified ✅" : "Not Verified ❌"; ?>)<br>

Phone: <?php echo $u["phone"]; ?> 
(<?php echo $u["phone_verified"] ? "Verified ✅" : "Not Verified ❌"; ?>)<br>

Role: <?php echo ucfirst($u["role"]); ?>

<br><br>

<div class="action-buttons">
<a href="admin_suspend_user.php?id=<?php echo $u["id"]; ?>" 
   class="btn-small btn-warning">
   Suspend
</a>


<a href="admin_delete_user.php?id=<?php echo $u["id"]; ?>" 
   class="btn-small btn-danger"
   onclick="return confirm('Delete this user?')">
   Delete
</a>


</div>

</div>
<?php endwhile; ?>

</section>

</body>
</html>
