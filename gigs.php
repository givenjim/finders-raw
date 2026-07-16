<?php
include("db/config.php");

$result = mysqli_query($conn,
"SELECT gigs.*, users.name 
 FROM gigs JOIN users ON gigs.employer_id = users.id
 WHERE status='open'
 ORDER BY gigs.id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
<title>Gigs | Finders</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/navbar.php"); ?>

<section class="marketplace">

<h2>Available Gigs</h2>

<div class="product-grid">

<?php while($g=mysqli_fetch_assoc($result)): ?>

<div class="product-card">

<h3><?php echo $g["title"]; ?></h3>

<p><?php echo $g["category"]; ?></p>

<p>Budget: $<?php echo $g["budget"]; ?></p>

<p>Employer: <?php echo $g["name"]; ?></p>

<a href="apply.php?id=<?php echo $g['id']; ?>">Apply</a>

</div>

<?php endwhile; ?>

</div>

</section>

</body>
</html>
