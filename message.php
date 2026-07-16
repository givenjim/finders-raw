<?php
session_start();
include("db/config.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$current_user = $_SESSION["user_id"];

// Get receiver + context
$receiver_id = $_GET["user_id"] ?? null;
$order_id    = $_GET["order_id"] ?? null;
$gig_id      = $_GET["gig_id"] ?? null;

if (!$receiver_id) {
    die("No user selected for messaging.");
}

// =======================
// SEND MESSAGE
// =======================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $message = trim($_POST["message"]);

    if (!empty($message)) {

        $stmt = $conn->prepare("
        INSERT INTO messages (sender_id, receiver_id, message, order_id, gig_id)
        VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->bind_param("iisii",
            $current_user,
            $receiver_id,
            $message,
            $order_id,
            $gig_id
        );

        $stmt->execute();
    }

    // Refresh to prevent resubmission
    header("Location: message.php?user_id=$receiver_id&order_id=$order_id&gig_id=$gig_id");
    exit();
}

// =======================
// FETCH MESSAGES
// =======================

$stmt = $conn->prepare("
SELECT * FROM messages 
WHERE (sender_id=? AND receiver_id=?)
   OR (sender_id=? AND receiver_id=?)
ORDER BY created_at ASC
");

$stmt->bind_param("iiii", $id, $receiver_id, $receiver_id, $id);
$stmt->execute();

$messages = $stmt->get_result();

// Filter by context
if ($order_id) {
    $query .= " AND order_id='$order_id'";
}

if ($gig_id) {
    $query .= " AND gig_id='$gig_id'";
}

$query .= " ORDER BY created_at ASC";

$messages = $conn->query($query);

// Get receiver name
$userQ = $conn->query("SELECT name FROM users WHERE id='$receiver_id'");
$user  = $userQ->fetch_assoc();

if($receiver_id == $id){
    die("You cannot message yourself.");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Messages</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">

<style>
.chat-box {
    max-width: 700px;
    margin: auto;
}

.message {
    padding: 10px;
    margin: 5px 0;
    border-radius: 10px;
    max-width: 70%;
}

.sent {
    background: #d1f7c4;
    margin-left: auto;
    text-align: right;
}

.received {
    background: #eee;
}

.chat-input {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}
</style>

</head>

<body>

<?php include("partials/navbar.php"); ?>

<section class="dashboard chat-box">

<h2>Chat with <?php echo htmlspecialchars($user["name"]); ?></h2>

<!-- ======================= -->
<!-- MESSAGES -->
<!-- ======================= -->
<div class="chat-area">

<?php if ($messages && $messages->num_rows > 0): ?>

<?php while ($msg = $messages->fetch_assoc()): ?>

<div class="message <?php echo ($msg["sender_id"] == $current_user) ? 'sent' : 'received'; ?>">

<?php echo nl2br(htmlspecialchars($msg["message"])); ?>

<br>
<small><?php echo $msg["created_at"]; ?></small>

</div>

<?php endwhile; ?>

<?php else: ?>

<p>No messages yet. Start the conversation.</p>

<?php endif; ?>



</div>

<!-- ======================= -->
<!-- SEND MESSAGE -->
<!-- ======================= -->

<form method="POST" class="chat-input">

<input type="text" name="message" placeholder="Type your message..." required style="flex:1;">

<button type="submit" class="btn-small">Send</button>

</form>

</section>

</body>
</html>