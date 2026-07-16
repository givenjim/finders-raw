<?php
session_start();

if(!isset($_SESSION["user_id"])){
    header("Location: login.html");
    exit();
}

if($_SESSION["user_role"] != "worker"){
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Service | Finders</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/navbar.php"); ?>

<section class="form-section">

<h2>Create New Service</h2>

<form action="api/add_product.php" method="POST" enctype="multipart/form-data">

<input type="text" name="title" placeholder="Service Title" required>

<textarea name="description" placeholder="Service Description" required></textarea>

<input type="number" name="price" placeholder="Price" step="0.01" required>

<input type="text" name="category" placeholder="Category" required>

<input type="file" name="image" required>

<button type="submit">Publish Service</button>

</form>

</section>

</body>
</html>
