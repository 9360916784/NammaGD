<?php
session_start();
include "connection.php";

// Restrict access only to admin
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: manage_feedback.php");
    exit();
}

$id = intval($_GET['id']);

// Fetch feedback record
$sql = "SELECT f.*, u.username, u.email 
        FROM gd_feedback f
        JOIN users u ON f.user_id = u.id
        WHERE f.id = $id";
$result = mysqli_query($conn, $sql);
$feedback = mysqli_fetch_assoc($result);

if (!$feedback) {
    die("Invalid Feedback ID");
}

// Update feedback if form submitted
if (isset($_POST['update'])) {
    $grammar = intval($_POST['grammar_score']);
    $sentiment = intval($_POST['sentiment_score']);
    $speaking_time = intval($_POST['speaking_time']);
    $tips = mysqli_real_escape_string($conn, $_POST['improvement_tips']);

    $update_sql = "UPDATE gd_feedback 
                   SET grammar_score='$grammar',
                       sentiment_score='$sentiment',
                       speaking_time='$speaking_time',
                       improvement_tips='$tips'
                   WHERE id=$id";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: manage_feedback.php?updated=1");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error updating feedback: " . mysqli_error($conn) . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Feedback</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

  <h2>Edit Feedback</h2>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">User</label>
      <input type="text" class="form-control" value="<?= htmlspecialchars($feedback['username']) ?> (<?= htmlspecialchars($feedback['email']) ?>)" disabled>
    </div>
    <div class="mb-3">
      <label class="form-label">Topic</label>
      <input type="text" class="form-control" value="<?= htmlspecialchars($feedback['topic']) ?>" disabled>
    </div>
    <div class="mb-3">
      <label class="form-label">Grammar Score</label>
      <input type="number" name="grammar_score" class="form-control" value="<?= $feedback['grammar_score'] ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Sentiment Score</label>
      <input type="number" name="sentiment_score" class="form-control" value="<?= $feedback['sentiment_score'] ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Speaking Time (sec)</label>
      <input type="number" name="speaking_time" class="form-control" value="<?= $feedback['speaking_time'] ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Improvement Tips</label>
      <textarea name="improvement_tips" class="form-control" rows="5"><?= htmlspecialchars($feedback['improvement_tips']) ?></textarea>
    </div>
    <button type="submit" name="update" class="btn btn-success">Update</button>
    <a href="manage_feedback.php" class="btn btn-secondary">Cancel</a>
  </form>

</body>
</html>
