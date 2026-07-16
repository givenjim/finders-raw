<?php
session_start();
include("db/config.php");

if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"]!="worker"){
    header("Location: login.html");
    exit();
}

$worker_id = $_SESSION["user_id"];

$applications = $conn->query("
SELECT applications.*, gigs.title 
FROM applications
JOIN gigs ON applications.gig_id = gigs.id
WHERE applications.worker_id='$worker_id'
ORDER BY applications.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>My Applications | Ajira</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/navbar.php"); ?>

<section class="dashboard">

<h2>My Applications</h2>

<?php if($applications->num_rows > 0): ?>

<?php while($a = $applications->fetch_assoc()): ?>

<div class="dash-card">

<strong><?php echo htmlspecialchars($a["title"]); ?></strong><br>

<p><?php echo htmlspecialchars($a["cover_letter"]); ?></p>

Status:
<strong><?php echo ucfirst($a["status"]); ?></strong>

</div>

<?php endwhile; ?>

<?php else: ?>

<p>You have not applied for any gigs yet.</p>

<?php endif; ?>

</section>

</body>
</html>