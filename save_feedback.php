<?php
session_start();
include "connection.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION['id'])) {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

$user_id = $_SESSION['id'];
$topic = mysqli_real_escape_string($conn, $data['topic']);
$original = mysqli_real_escape_string($conn, $data['original_text']);
$corrected = mysqli_real_escape_string($conn, $data['corrected_text']);
$polite = mysqli_real_escape_string($conn, $data['polite_text']);
$grammar_score = (int)$data['grammar_score'];
$sentiment_score = (int)$data['sentiment_score'];
$tips_str = mysqli_real_escape_string($conn, is_array($data['improvement_tips']) ? implode("\n", $data['improvement_tips']) : $data['improvement_tips']);

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO gd_feedback (user_id, topic, transcript, grammar_score, sentiment_score, speaking_time, improvement_tips) VALUES (?, ?, ?, ?, ?, ?, ?)");

$transcript = "$original\n\nCorrected: $corrected\n\nPolite: $polite";

$stmt->bind_param("issiii", $user_id, $topic, $transcript, $grammar_score, $sentiment_score, strlen($original)/5, $tips_str);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}
?>