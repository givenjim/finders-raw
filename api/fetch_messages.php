<?php
session_start();
require_once "../db/config.php";

if (!isset($_SESSION['user_id'])) {
    exit("Not logged in");
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['conversation_id'])) {
    exit("No conversation");
}

$conversation_id = intval($_GET['conversation_id']);

// verify access
$stmt = $conn->prepare("SELECT * FROM conversations WHERE id = ?");
$stmt->bind_param("i", $conversation_id);
$stmt->execute();
$convo = $stmt->get_result()->fetch_assoc();

if (!$convo) {
    exit("Conversation not found");
}

if ($convo['employer_id'] != $user_id && $convo['worker_id'] != $user_id) {
    exit("Access denied");
}

// mark as read
$stmt = $conn->prepare("UPDATE messages SET is_read = 1 WHERE conversation_id = ? AND sender_id != ?");
$stmt->bind_param("ii", $conversation_id, $user_id);
$stmt->execute();

// fetch messages
$stmt = $conn->prepare("SELECT * FROM messages WHERE conversation_id = ? ORDER BY created_at ASC");
$stmt->bind_param("i", $conversation_id);
$stmt->execute();
$result = $stmt->get_result();

while ($msg = $result->fetch_assoc()) {
    $class = ($msg['sender_id'] == $user_id) ? "me" : "them";

    echo '<div class="msg '.$class.'">';
    echo nl2br(htmlspecialchars($msg['message']));
    echo '<div class="time">'.$msg['created_at'].'</div>';
    echo '</div>';
}