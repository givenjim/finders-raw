<?php
session_start();
include("db/config.php");

if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"]!="employer"){
    header("Location: login.html");
    exit();
}
 
$employer_id = $_SESSION["user_id"];

$applications = $conn->query("
 SELECT applications.*, users.name, gigs.title,
    applications.id,
    applications.worker_id,
    applications.cover_letter,
    applications.status,
    users.name,
    gigs.title
FROM applications
JOIN users ON applications.worker_id = users.id
JOIN gigs ON applications.gig_id = gigs.id
WHERE gigs.employer_id='$employer_id'
ORDER BY applications.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Gig Applications | Finders</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/navbar.php"); ?>

<section class="dashboard">

<h2>Applications For Your Gigs</h2>

<?php if($applications->num_rows > 0): ?>

<?php while($a = $applications->fetch_assoc()): ?>

<div class="dash-card">

<strong>Gig:</strong> <?php echo htmlspecialchars($a["title"]); ?><br>

<strong>Applicant:</strong> <?php echo htmlspecialchars($a["name"]); ?><br>

<p><?php echo htmlspecialchars($a["cover_letter"]); ?></p>

Status:
<strong><?php echo ucfirst($a["status"] ?? "pending"); ?></strong>

<?php if($a["status"]=="pending"): ?>

<br><br>

<a href="update_application.php?id=<?php echo $a["id"]; ?>&action=accept" class="btn-small">Accept</a>



<a href="update_application.php?id=<?php echo $a["id"]; ?>&action=reject" class="btn-small btn-danger">Reject</a>

<br>

<!-- <a href="messages.php?user_id=<?php echo $a["worker_id"]; ?>" 
   class="btn-small">
   Message Worker
</a> -->

<br>

<a href="message.php?user_id=<?php echo $a["worker_id"]; ?>&gig_id=<?php echo $a["gig_id"]; ?>" 
   class="btn-small">
   Message Worker
</a>




<?php endif; ?>

</div>

<?php endwhile; ?>

<?php else: ?>

<p>No applications yet.</p>

<?php endif; ?>

</section>

</body>
</html>