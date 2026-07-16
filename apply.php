<?php
session_start();

if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"]!="worker"){
    header("Location: login.html");
    exit();
}

if(!isset($_GET["gig_id"])){
    die("Gig not specified.");
}

$gig_id = intval($_GET["gig_id"]);
?>

<!DOCTYPE html>
<html>
<head>
<title>Apply | Finders</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/navbar.php"); ?>

<section class="form-section">

<h2>Apply For Gig</h2>

<form method="POST" action="api/apply.php">

<input type="hidden" name="gig_id" value="<?php echo $gig_id; ?>">

<textarea name="cover_letter" placeholder="Cover Letter" required></textarea>

<button class="btn" type="submit">Submit Application</button>

</form>

</section>

</body>
</html>