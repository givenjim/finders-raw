<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== "admin"){
    header("Location: ../login.html");
    exit();
}
?>

<nav class="navbar">

<div class="logo">
<a href="admin_dashboard.php">Finders Admin</a>
</div>

<div class="nav-links">

<a href="admin_dashboard.php">Dashboard</a>

<a href="admin_users.php">Users</a>

<a href="admin_services.php">Services</a>

<a href="admin_gigs.php">Gigs</a>

<a href="admin_payments.php">Payments</a>

<a href="admin_profile.php">My Account</a>

<a href="logout.php">Logout</a>

</div>

</nav>