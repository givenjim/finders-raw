<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>

<nav class="navbar">

<div class="logo">
<a href="dashboard.php">Finders</a>
</div>

<div class="nav-links">

<a href="dashboard.php">Dashboard</a>
<a href="marketplace.php">Marketplace</a>
<a href="inbox.php">Inbox</a>

<?php if(isset($_SESSION["user_role"]) && $_SESSION["user_role"]=="worker"): ?>
<a href="add_product.php">Add Service</a>
<a href="worker_applications.php">My Applications</a>
<?php endif; ?>

<?php if(isset($_SESSION["user_role"]) && $_SESSION["user_role"]=="employer"): ?>
<a href="add_gig.php">Post Gig</a>
<a href="employer_applications.php">Applications</a>
<a href="employer_orders.php">My Orders</a>
<?php endif; ?>

<?php if(isset($_SESSION["user_id"])): ?>
<a href="profile.php">Profile</a>
<a href="logout.php">Logout</a>
<?php else: ?>
<a href="login.html">Login</a>
<a href="register.html">Register</a>
<?php endif; ?>

</div>

</nav>