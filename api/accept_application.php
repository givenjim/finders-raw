<?php
session_start();
include("db/config.php");

$id = $_SESSION["user_id"];

$applications = $conn->query(
"SELECT applications.*, users.name, gigs.title
FROM applications
JOIN users ON applications.worker_id = users.id
JOIN gigs ON applications.gig_id = gigs.id
WHERE gigs.employer_id='$id'
ORDER BY applications.id DESC"
);
?>

<h2>Applications For Your Gigs</h2>

<?php while($app = mysqli_fetch_assoc($applications)): ?>

<div class="dash-card">

<strong><?php echo $app["title"]; ?></strong><br>

Worker: <?php echo $app["name"]; ?><br>

Message: <?php echo $app["message"]; ?><br>

Status: <?php echo ucfirst($app["status"]); ?><br>

<a href="api/accept_application.php?id=<?php echo $app["id"]; ?>">Accept</a>

<a href="api/reject_application.php?id=<?php echo $app["id"]; ?>">Reject</a>

</div>

<?php endwhile; ?>