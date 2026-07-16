<?php
session_start();
include("db/config.php");

if(!isset($_SESSION["user_id"])){
    header("Location: login.html");
    exit();
}

$sender_id   = $_SESSION["user_id"];
$receiver_id = $_GET["user_id"];

// Send message
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $msg = $_POST["message"];

    $stmt = $conn->prepare("
        INSERT INTO messages (sender_id, receiver_id, message)
        VALUES (?, ?, ?)
    ");
    $stmt->bind_param("iis", $sender_id, $receiver_id, $msg);
    $stmt->execute();
}

// Fetch messages
$messages = $conn->query("
SELECT * FROM messages
WHERE 
(sender_id=$sender_id AND receiver_id=$receiver_id)
OR
(sender_id=$receiver_id AND receiver_id=$sender_id)
ORDER BY created_at ASC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Chat | Finders</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Chat</h2>

<div class="chat-box">

<?php while($m = $messages->fetch_assoc()): ?>

<div style="
margin:10px;
padding:10px;
border-radius:8px;
background: <?php echo ($m["sender_id"] == $sender_id) ? '#d1ffd1' : '#f1f1f1'; ?>;
text-align: <?php echo ($m["sender_id"] == $sender_id) ? 'right' : 'left'; ?>;
">
<?php echo htmlspecialchars($m["message"]); ?>
</div>

<?php endwhile; ?>

</div>

<form method="POST">
<input type="text" name="message" placeholder="Type message..." required>
<button type="submit">Send</button>
</form>

<!-- Auto refresh -->
<script>
setTimeout(() => {
    window.location.reload();
}, 5000);
</script>

</body>
</html>