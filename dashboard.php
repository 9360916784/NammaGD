<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include "connection.php";

$user_id = $_SESSION['id'];

// --- 1. Total GD Sessions ---
$total_sql = "SELECT COUNT(*) as count FROM gd_feedback WHERE user_id = $user_id";
$total_res = mysqli_query($conn, $total_sql);
$total_sessions = mysqli_fetch_assoc($total_res)['count'] ?? 0;

// --- 2. Average Confidence (Based on Sentiment Score) ---
$avg_sql = "SELECT AVG(sentiment_score) as avg_score FROM gd_feedback WHERE user_id = $user_id";
$avg_res = mysqli_query($conn, $avg_sql);
$avg_row = mysqli_fetch_assoc($avg_res);
$avg_confidence = round($avg_row['avg_score'] ?? 0);

// --- 3. Improvement Rate (Last Session vs First Session) ---
$improvement_rate = 0;
$improvement_class = "text-muted"; // Default color
$improvement_sign = "";

if ($total_sessions > 1) {
    // Get First Session Score
    $first_sql = "SELECT grammar_score, sentiment_score FROM gd_feedback WHERE user_id = $user_id ORDER BY session_date ASC LIMIT 1";
    $first_res = mysqli_query($conn, $first_sql);
    $first_row = mysqli_fetch_assoc($first_res);
    $first_total = $first_row['grammar_score'] + $first_row['sentiment_score'];

    // Get Last Session Score
    $last_sql = "SELECT grammar_score, sentiment_score FROM gd_feedback WHERE user_id = $user_id ORDER BY session_date DESC LIMIT 1";
    $last_res = mysqli_query($conn, $last_sql);
    $last_row = mysqli_fetch_assoc($last_res);
    $last_total = $last_row['grammar_score'] + $last_row['sentiment_score'];

    // Calculate Percentage Change
    if ($first_total > 0) {
        $improvement_rate = round((($last_total - $first_total) / $first_total) * 100, 1);
    }

    // Determine Color and Sign
    if ($improvement_rate > 0) {
        $improvement_class = "text-success"; // Green
        $improvement_sign = "+";
    } elseif ($improvement_rate < 0) {
        $improvement_class = "text-danger"; // Red
        $improvement_sign = ""; // Negative sign comes automatically
    } else {
        $improvement_class = "text-warning"; // Yellow/Orange
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Namma GD - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="bi bi-chat"></i> Namma GD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="learning.php">Learning Module</a></li>
                    <li class="nav-item"><a class="nav-link" href="practice.php">Practice GD</a></li>
                    <li class="nav-item"><a class="nav-link" href="feedback.php">My Feedback</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="text-center mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</h1>
        <p class="text-center text-muted">Your AI-powered group discussion training hub</p>

        <div class="row g-4 mt-4">
            <div class="col-md-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-journal-richtext display-4 text-primary"></i>
                        <h4 class="mt-3">Learning Module</h4>
                        <p>Watch videos, read articles, and take quizzes to sharpen your GD skills.</p>
                        <a href="learning.php" class="btn btn-primary">Start Learning</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-camera-video display-4 text-success"></i>
                        <h4 class="mt-3">Practice GD</h4>
                        <p>Join or host a real-time group discussion session with AI tracking.</p>
                        <a href="practice.php" class="btn btn-success">Join GD</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-robot display-4 text-warning"></i>
                        <h4 class="mt-3">My Feedback</h4>
                        <p>View AI-generated feedback on your grammar, delivery, and confidence.</p>
                        <a href="feedback.php" class="btn btn-warning text-dark">View Feedback</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-5">
            <div class="col-md-4">
                <div class="card text-center border-primary shadow-sm">
                    <div class="card-body">
                        <h5>Total GD Sessions</h5>
                        <p class="display-6 text-primary fw-bold"><?php echo $total_sessions; ?></p>
                        <small class="text-muted">Completed Sessions</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center border-success shadow-sm">
                    <div class="card-body">
                        <h5>Average Confidence</h5>
                        <p class="display-6 text-success fw-bold"><?php echo $avg_confidence; ?>%</p>
                        <small class="text-muted">Based on AI Sentiment Analysis</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center border-warning shadow-sm">
                    <div class="card-body">
                        <h5>Improvement Rate</h5>
                        <p class="display-6 fw-bold <?php echo $improvement_class; ?>">
                            <?php echo $improvement_sign . $improvement_rate; ?>%
                        </p>
                        <small class="text-muted">Progress since first session</small>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <footer class="bg-dark text-light py-3 text-center mt-5">
        <p class="mb-0">&copy; <?php echo date('Y'); ?> Namma GD | AI-Powered Group Discussion Platform</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>