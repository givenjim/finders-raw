<?php
session_start();
include("db/config.php");

if(!isset($_SESSION["user_id"])){
    header("Location: login.html");
    exit();
}

$id = $_SESSION["user_id"];

// Get unique chat users
$result = $conn->query("
SELECT DISTINCT 
    CASE 
        WHEN sender_id = $id THEN receiver_id
        ELSE sender_id
    END AS user_id
FROM messages
WHERE sender_id = $id OR receiver_id = $id
");

?>

<!DOCTYPE html>
<html>
<head>
<title>Inbox | Finders</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Your Messages</h2>

<?php while($row = $result->fetch_assoc()): 

$user = $conn->query("SELECT name FROM users WHERE id=".$row["user_id"])->fetch_assoc();
?>

<div class="dash-card">
<strong><?php echo $user["name"]; ?></strong><br>

<a href="chat.php?user_id=<?php echo $row["user_id"]; ?>" class="btn-small">
Open Chat
</a>
</div>

<?php endwhile; ?>

</body>
</html>