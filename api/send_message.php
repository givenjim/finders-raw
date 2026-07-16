<?php
session_start();
require_once "../db/config.php";

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "error" => "Not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_POST['conversation_id']) || !isset($_POST['message'])) {
    echo json_encode(["success" => false, "error" => "Missing data"]);
    exit;
}

$conversation_id = intval($_POST['conversation_id']);
$message = trim($_POST['message']);

if ($message == "") {
    echo json_encode(["success" => false, "error" => "Empty message"]);
    exit;
}

// verify user belongs to conversation
$stmt = $conn->prepare("SELECT * FROM conversations WHERE id = ?");
$stmt->bind_param("i", $conversation_id);
$stmt->execute();
$convo = $stmt->get_result()->fetch_assoc();

if (!$convo) {
    echo json_encode(["success" => false, "error" => "Conversation not found"]);
    exit;
}

if ($convo['employer_id'] != $user_id && $convo['worker_id'] != $user_id) {
    echo json_encode(["success" => false, "error" => "Access denied"]);
    exit;
}

// insert message
$stmt = $conn->prepare("INSERT INTO messages (conversation_id, sender_id, message) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $conversation_id, $user_id, $message);
$stmt->execute();

echo json_encode(["success" => true]);