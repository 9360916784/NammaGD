<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$result = $_SESSION['quiz_result'] ?? null;
if (!$result) {
    header("Location: quiz.php");
    exit();
}

$score = $result['score'];
$status = $result['status'];
unset($_SESSION['quiz_result']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Quiz Result - Namma GD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5 text-center">
    <h2>Quiz Result</h2>
    <p class="fs-4">You scored <strong><?php echo $score; ?>/10</strong></p>
    <?php if ($status === 'completed') { ?>
        <div class="alert alert-success">🎉 Congratulations! You passed this level.</div>
    <?php } else { ?>
        <div class="alert alert-danger">❌ You did not pass. Try again!</div>
    <?php } ?>
    <a href="quiz.php" class="btn btn-primary mt-3">Back to Quiz Levels</a>
</div>
</body>
</html>
