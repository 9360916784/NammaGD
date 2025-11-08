<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include "connection.php"; // Database connection

$user_id = $_SESSION['id'];

// Fetch user's feedback history
$sql = "SELECT * FROM gd_feedback WHERE user_id = '$user_id' ORDER BY session_date DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Feedback - Namma GD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <li class="nav-item"><a class="nav-link" href="learning.php">Learning</a></li>
                <li class="nav-item"><a class="nav-link" href="practice.php">Practice GD</a></li>
                <li class="nav-item"><a class="nav-link active" href="feedback.php">My Feedback</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Page Header -->
<div class="container my-5">
    <h1 class="text-center mb-4">My Feedback</h1>
    <p class="text-center text-muted">Review AI-generated analysis from your past GD sessions.</p>

    <?php if (mysqli_num_rows($result) > 0) { ?>
        <div class="table-responsive">
            <table class="table table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Topic</th>
                        <th>Grammar (%)</th>
                        <th>Sentiment (%)</th>
                        <th>Speaking Time (sec)</th>
                        <th>Improvement Tips</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo date("d M Y", strtotime($row['session_date'])); ?></td>
                            <td><?php echo htmlspecialchars($row['topic']); ?></td>
                            <td><?php echo $row['grammar_score']; ?>%</td>
                            <td><?php echo $row['sentiment_score']; ?>%</td>
                            <td><?php echo $row['speaking_time']; ?></td>
                            <td><?php echo htmlspecialchars($row['improvement_tips']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Chart -->
        <h3 class="text-center mt-5">Performance Trend</h3>
        <canvas id="performanceChart" height="120"></canvas>

    <?php } else { ?>
        <div class="alert alert-warning text-center">
            No feedback available yet. Complete a GD session to receive feedback.
        </div>
    <?php } ?>
</div>

<footer class="bg-dark text-light py-3 text-center mt-5">
    <p class="mb-0">&copy; <?php echo date('Y'); ?> Namma GD | AI-Powered Group Discussion Platform</p>
</footer>

<script>
<?php
// Prepare chart data
$dates = [];
$grammarScores = [];
$sentimentScores = [];

mysqli_data_seek($result, 0); // reset pointer to reuse $result
while ($row = mysqli_fetch_assoc($result)) {
    $dates[] = date("d M", strtotime($row['session_date']));
    $grammarScores[] = $row['grammar_score'];
    $sentimentScores[] = $row['sentiment_score'];
}
?>

const ctx = document.getElementById('performanceChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($dates); ?>,
        datasets: [
            {
                label: 'Grammar Score',
                data: <?php echo json_encode($grammarScores); ?>,
                borderColor: 'blue',
                fill: false
            },
            {
                label: 'Sentiment Score',
                data: <?php echo json_encode($sentimentScores); ?>,
                borderColor: 'green',
                fill: false
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
</script>

</body>
</html>
