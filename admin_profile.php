<?php
session_start();
include("db/config.php");

if(!isset($_SESSION["user_id"])){
    header("Location: login.html");
    exit();
}

$id = $_SESSION["user_id"];

$result = mysqli_query($conn,"SELECT * FROM users WHERE id=$id");
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title>Profile | Finders</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/admin_navbar.php"); ?>

<section class="form-section">

<h2>Your Profile</h2>

<form method="POST" action="api/update_profile.php" enctype="multipart/form-data">

<input type="text" name="name" value="<?php echo $user['name']; ?>" required>

<input type="text" name="location" value="<?php echo $user['location']; ?>" placeholder="Location">

<textarea name="bio" placeholder="Short Bio"><?php echo $user['bio']; ?></textarea>

<input type="file" name="profile_image">

<button type="submit">Save Profile</button>

</form>

</section>

</body>
</html>
