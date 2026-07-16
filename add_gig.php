<?php
session_start();

if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"]!="employer"){
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Post Gig | Finders</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/navbar.php"); ?>

<section class="form-section">

<h2>Post New Gig</h2>

<form method="POST" action="api/add_gig.php">

<input type="text" name="title" placeholder="Gig Title" required>

<textarea name="description" placeholder="Gig Description" required></textarea>

<input type="number" name="budget" placeholder="Budget" required>

<input type="text" name="category" placeholder="Category" required>

<input type="date" name="deadline" required>

<button type="submit">Publish Gig</button>

</form>

</section>

</body>
</html>
