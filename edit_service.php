<?php
session_start();
include("db/config.php");

if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"] != "worker"){
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION["user_id"];
$id = $_GET["id"];

// ✅ Fetch service
$result = $conn->query(
    "SELECT * FROM products 
     WHERE id='$id' 
     AND user_id='$user_id'"
);

$service = $result->fetch_assoc();

if(!$service){
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Service</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/navbar.php"); ?>

<section class="form-section">

<h2>Edit Service</h2>

<form method="POST" action="update_service.php">

<input type="hidden" name="id" value="<?php echo $service["id"]; ?>">

<input type="text" name="title" value="<?php echo htmlspecialchars($service["title"]); ?>" required>

<textarea name="description" required><?php echo htmlspecialchars($service["description"]); ?></textarea>

<input type="number" name="price" value="<?php echo $service["price"]; ?>" required>

<input type="text" name="category" value="<?php echo $service["category"]; ?>" required>

<button type="submit" class="btn-small">Update Service</button>

</form>

</section>

</body>
</html>