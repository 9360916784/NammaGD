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
    <title>Namma GD - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
</head>

<body>
    <!-- Navbar -->
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
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="learning.php">Learning Module</a></li>
                    <li class="nav-item"><a class="nav-link" href="practice.php">Practice GD</a></li>
                    <li class="nav-item"><a class="nav-link" href="feedback.php">My Feedback</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="container my-5">
        <h1 class="text-center mb-4">Welcome, <?php echo $_SESSION['username']; ?> 👋</h1>
        <p class="text-center text-muted">Your AI-powered group discussion training hub</p>

        <div class="row g-4 mt-4">
            <!-- Learning Module -->
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

            <!-- Practice GD -->
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

            <!-- Feedback -->
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

        <!-- Quick Stats -->
        <div class="row g-4 mt-5">
            <div class="col-md-4">
                <div class="card text-center border-primary">
                    <div class="card-body">
                        <h5>Total GD Sessions</h5>
                        <p class="display-6 text-primary fw-bold">5</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center border-success">
                    <div class="card-body">
                        <h5>Average Confidence</h5>
                        <p class="display-6 text-success fw-bold">78%</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center border-warning">
                    <div class="card-body">
                        <h5>Improvement Rate</h5>
                        <p class="display-6 text-warning fw-bold">+15%</p>
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
