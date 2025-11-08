<?php
session_start();
include "connection.php";
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if ($data['action'] === 'analyze_gd') {
    $user_id = $_SESSION['id'];
    $topic = mysqli_real_escape_string($conn, $data['topic']);
    $gd_text = $data['gd_text'];

    // Gemini API Key
    $api_key = "AIzaSyDDKrioKsUFVLPz-R4RLpBV7uyBnZa7bAU";
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=" . $api_key;

    $prompt = "
You are an AI language coach. Analyze this group discussion transcript:
---
$gd_text
---

Return ONLY JSON (no explanations, no markdown), exactly in this format:
{
  \"original_text\": \"original transcript\",
  \"corrected_text\": \"grammar corrected transcript\",
  \"polite_text\": \"polite professional rewrite\",
  \"grammar_score\": number 0-100,
  \"sentiment_score\": number 0-100,
  \"improvement_tips\": [\"tip1\", \"tip2\", \"tip3\"]
}
";

    $postData = json_encode([
        "contents" => [
            ["parts" => [["text" => $prompt]]]
        ]
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    $response = curl_exec($ch);
    curl_close($ch);

    $res = json_decode($response, true);
    $reply = $res['candidates'][0]['content']['parts'][0]['text'] ?? "";

    // 🔹 Clean Gemini reply (strip ```json fences etc.)
    $reply = trim($reply);
    $reply = preg_replace('/^```(json)?/i', '', $reply);
    $reply = preg_replace('/```$/i', '', $reply);
    $reply = trim($reply);

    $jsonReply = json_decode($reply, true);

    if ($jsonReply) {
        $original_text = $gd_text;
        $corrected_text = $jsonReply['corrected_text'] ?? $gd_text;
        $polite_text = $jsonReply['polite_text'] ?? $corrected_text;
        $grammar_score = $jsonReply['grammar_score'] ?? 100;
        $sentiment_score = $jsonReply['sentiment_score'] ?? 50;
        $improvement_tips = $jsonReply['improvement_tips'] ?? ["Work on clarity and confidence."];

        $gd_text_db = mysqli_real_escape_string($conn, $gd_text);
        $corrected_text_db = mysqli_real_escape_string($conn, $corrected_text);
        $polite_text_db = mysqli_real_escape_string($conn, $polite_text);
        $tips_str = mysqli_real_escape_string($conn, is_array($improvement_tips) ? implode("\n", $improvement_tips) : $improvement_tips);

        $sql = "INSERT INTO gd_feedback (user_id, topic, transcript, grammar_score, sentiment_score, speaking_time, improvement_tips)
                VALUES ($user_id, '$topic', '$gd_text_db\n\nCorrected: $corrected_text_db\n\nPolite: $polite_text_db',
                        $grammar_score, $sentiment_score, LENGTH('$gd_text_db')/5, '$tips_str')";
        mysqli_query($conn, $sql);

        echo json_encode([
            "status" => "success",
            "original_text" => $original_text,
            "corrected_text" => $corrected_text,
            "polite_text" => $polite_text,
            "grammar_score" => $grammar_score,
            "sentiment_score" => $sentiment_score,
            "speaking_time" => round(strlen($gd_text) / 5),
            "improvement_tips" => $improvement_tips
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid Gemini response", "raw" => $reply]);
    }
}
?>
