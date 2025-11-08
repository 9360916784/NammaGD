<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include "connection.php";

$user_id = $_SESSION['id'];

// Validate level
if (!isset($_GET['level'])) {
    header("Location: quiz.php");
    exit();
}
$level_id = intval($_GET['level']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $answers = $_POST['answers'] ?? [];
    $score = 0;

    // Fetch correct answers
    $q_sql = "SELECT id, correct_option FROM quiz_questions WHERE level_id=$level_id";
    $q_res = mysqli_query($conn, $q_sql);
    while ($q = mysqli_fetch_assoc($q_res)) {
        $qid = $q['id'];
        if (isset($answers[$qid]) && $answers[$qid] === $q['correct_option']) {
            $score++;
        }
    }

    // Pass mark = 7
    $status = ($score >= 7) ? 'completed' : 'unlocked';

    // Check progress record
    $check_sql = "SELECT * FROM quiz_progress WHERE user_id=$user_id AND level_id=$level_id";
    $check_res = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_res) > 0) {
        // Update existing record
        $update_sql = "UPDATE quiz_progress 
                       SET score=$score, status='$status', attempts=attempts+1 
                       WHERE user_id=$user_id AND level_id=$level_id";
        mysqli_query($conn, $update_sql);
    } else {
        // Insert new record
        $insert_sql = "INSERT INTO quiz_progress (user_id, level_id, score, status, attempts) 
                       VALUES ($user_id, $level_id, $score, '$status', 1)";
        mysqli_query($conn, $insert_sql);
    }

    // Unlock next level if passed
    if ($status === 'completed') {
        $next_level = $level_id + 1;
        $check_next = "SELECT * FROM quiz_progress WHERE user_id=$user_id AND level_id=$next_level";
        $res_next = mysqli_query($conn, $check_next);
        if (mysqli_num_rows($res_next) == 0) {
            mysqli_query($conn, "INSERT INTO quiz_progress (user_id, level_id, status) 
                                 VALUES ($user_id, $next_level, 'unlocked')");
        }
    }

    // Show result
    $_SESSION['quiz_result'] = [
        'score' => $score,
        'status' => $status
    ];

    header("Location: quiz_result.php?level=$level_id");
    exit();
}

// Fetch 10 random questions for this level
$q_sql = "SELECT * FROM quiz_questions WHERE level_id=$level_id ORDER BY RAND() LIMIT 10";
$q_res = mysqli_query($conn, $q_sql);
$questions = [];
while ($row = mysqli_fetch_assoc($q_res)) {
    $questions[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Take Quiz - Namma GD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
    <h2 class="text-center mb-4">Quiz - Level <?php echo $level_id; ?></h2>
    <form method="POST">
        <?php foreach ($questions as $index => $q) { ?>
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5><?php echo ($index+1) . ". " . htmlspecialchars($q['question']); ?></h5>
                    <?php foreach (['A','B','C','D'] as $opt) { 
                        $field = 'option_' . strtolower($opt); ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" 
                                   name="answers[<?php echo $q['id']; ?>]" 
                                   value="<?php echo $opt; ?>" id="q<?php echo $q['id'].$opt; ?>">
                            <label class="form-check-label" for="q<?php echo $q['id'].$opt; ?>">
                                <?php echo htmlspecialchars($q[$field]); ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <div class="text-center">
            <button type="submit" class="btn btn-success btn-lg">Submit Quiz</button>
        </div>
    </form>
</div>
</body>
</html>
