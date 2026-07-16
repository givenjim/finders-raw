<?php
session_start();
include("db/config.php");

if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin"){
    header("Location: login.html");
    exit();
}

$gigs = $conn->query("SELECT id,title,budget,status FROM gigs ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Gigs | Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/admin_navbar.php"); ?>

<section class="dashboard">

<h2>All Gigs</h2>

<?php if($gigs && $gigs->num_rows > 0): ?>

<?php while($g = mysqli_fetch_assoc($gigs)): ?>

<div class="dash-card">

<strong><?php echo htmlspecialchars($g["title"]); ?></strong><br>

Budget: KES <?php echo $g["budget"]; ?><br>

Status: 
<strong style="color: <?php echo ($g["status"] == "open") ? "green" : "red"; ?>">
<?php echo ucfirst($g["status"]); ?>
</strong>

<br><br>

<div class="action-buttons">

<!-- TOGGLE BUTTON -->
<form method="post" action="api/admin_toggle_gig.php" style="display:inline;">
    <input type="hidden" name="id" value="<?php echo $g["id"]; ?>">
    
    <button type="submit" class="btn-small">
        <?php echo ($g["status"] === "open") ? "Close Gig" : "Open Gig"; ?>
    </button>
    <!-- DELETE BUTTON -->
<a href="api/admin_delete_gig.php?id=<?php echo $g["id"]; ?>"
   class="btn-small btn-danger"
   onclick="return confirm('Are you sure you want to delete this gig?')">
   Delete
</a>
</form>



</div>

</div>

<?php endwhile; ?>

<?php else: ?>

<p>No gigs found.</p>

<?php endif; ?>

</section>

</body>
</html>