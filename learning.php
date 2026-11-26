<?php 
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Module - Namma GD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <style>
        .card-img-top {
            width: 100%;           
            height: 200px;         
            object-fit: cover;     
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid position-relative">
        
        <a class="navbar-brand" href="dashboard.php"><i class="bi bi-chat"></i> Namma GD</a>
        
        <a href="dashboard.php" class="btn btn-danger btn-sm shadow-sm" 
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
    <h1 class="text-center mb-4">Learning Module</h1>
    <p class="text-center text-muted">Access GD preparation resources: videos, articles, and quizzes.</p>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <img src="images/quiz_img.png" class="card-img-top" alt="Quiz">
                <div class="card-body text-center">
                    <h5 class="card-title">GD Quiz</h5>
                    <p class="card-text">Test your knowledge with interactive quizzes.</p>
                    <a href="quiz.php" class="btn btn-success">Start Quiz</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <img src="images/confident_speaker.png" class="card-img-top" alt="Article">
                <div class="card-body text-center">
                    <h5 class="card-title">Confident Speaking</h5>
                    <p class="card-text">Learn essential tips, do’s & don’ts, and phrases for GD.</p>
                    <a href="confident_speaking.php" class="btn btn-primary">Read Articles</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <img src="images/gd-signature.png" class="card-img-top" alt="Video">
                <div class="card-body text-center">
                    <h5 class="card-title">GD Videos</h5>
                    <p class="card-text">Watch tutorials and practice videos for GD preparation.</p>
                    <a href="dgvideos.php" class="btn btn-secondary">Watch Videos</a>
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