<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
include "connection.php";

$user_id = $_SESSION['id'];

// Get all quiz levels
$levels_sql = "SELECT * FROM quiz_levels ORDER BY id ASC";
$levels_res = mysqli_query($conn, $levels_sql);

// Fetch leaderboard data (top 20 performers)
$leader_sql = "SELECT 
                  u.username,
                  l.level_name,
                  SUM(p.score) AS total_score,
                  SUM(p.attempts) AS total_attempts
               FROM quiz_progress p
               JOIN users u ON p.user_id = u.id
               JOIN quiz_levels l ON l.id = (
                   SELECT MAX(level_id) 
                   FROM quiz_progress 
                   WHERE user_id = p.user_id AND status='completed'
               )
               WHERE p.status='completed'
               GROUP BY u.id, u.username, l.level_name
               ORDER BY total_score DESC, total_attempts ASC
               LIMIT 20";
$leader_res = mysqli_query($conn, $leader_sql);

?>
<!DOCTYPE html>
<html>
<head>
    <title>GD Quiz - Namma GD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid position-relative">
        
        <a class="navbar-brand" href="dashboard.php"><i class="bi bi-chat"></i> Namma GD</a>
        
        <a href="learning.php" class="btn btn-danger btn-sm shadow-sm" 
           style="position: absolute; top: 50px; left: 10px; z-index: 1050; font-size: 0.75rem; padding: 2px 10px;">
            <i class="bi bi-arrow-left"></i> Back
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="learning.php">Learning Module</a></li>
                <li class="nav-item"><a class="nav-link" href="practice.php">Practice GD</a></li>
                <li class="nav-item"><a class="nav-link" href="feedback.php">My Feedback</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <h2 class="text-center">Group Discussion Quizzes</h2>
    <p class="text-center text-muted">Pass each level to unlock the next one!</p>
    
    <div class="row g-4 mb-5 mt-3">
        <?php while ($level = mysqli_fetch_assoc($levels_res)) {
            // Check user progress
            $progress_sql = "SELECT * FROM quiz_progress WHERE user_id=$user_id AND level_id={$level['id']}";
            $progress_res = mysqli_query($conn, $progress_sql);
            $progress = mysqli_fetch_assoc($progress_res);
            
            $status = $progress['status'] ?? 'locked';
            $score = $progress['score'] ?? null;
        ?>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title"><?php echo $level['level_name']; ?></h5>
                    <p class="card-text small text-muted"><?php echo $level['description']; ?></p>
                    
                    <?php if ($status == 'locked') { ?>
                        <button class="btn btn-secondary" disabled><i class="bi bi-lock"></i> Locked</button>
                    <?php } elseif ($status == 'completed') { ?>
                        <p class="text-success fw-bold">Score: <?php echo $score; ?>/10</p>
                        <a href="take_quiz.php?level=<?php echo $level['id']; ?>" class="btn btn-warning btn-sm">Retake</a>
                    <?php } else { ?>
                        <a href="take_quiz.php?level=<?php echo $level['id']; ?>" class="btn btn-primary">Start Quiz</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <h3 class="text-center mb-3 text-primary"><i class="bi bi-trophy-fill"></i> Leaderboard</h3>
    <div class="table-responsive">
        <table class="table table-striped table-bordered shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Rank</th>
                    <th>Username</th>
                    <th>Highest Level</th>
                    <th>Total Score</th>
                    <th>Attempts</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $rank = 1;
                while ($row = mysqli_fetch_assoc($leader_res)) {
                    $highlight = ($row['username'] === $_SESSION['username']) ? "table-warning fw-bold" : "";
                ?>
                    <tr class="<?php echo $highlight; ?>">
                        <td><?php echo $rank++; ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['level_name']); ?></td>
                        <td><?php echo $row['total_score']; ?></td>
                        <td><?php echo $row['total_attempts']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>