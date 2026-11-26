<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include "connection.php";

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
    <style>
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }
        .score-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border: 4px solid #e9ecef;
        }
        .score-good { border-color: #198754; color: #198754; }
        .score-avg { border-color: #ffc107; color: #ffc107; }
        .score-bad { border-color: #dc3545; color: #dc3545; }
        
        .feedback-modal-box {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
            border-left: 4px solid #0d6efd;
            margin-bottom: 10px;
            font-size: 0.9rem;
            white-space: pre-wrap;
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php"><i class="bi bi-chat"></i> Namma GD</a>
        <a href="dashboard.php" class="btn btn-danger btn-sm shadow-sm" 
           style="position: absolute; top: 60px; left: 5px; z-index: 1050; font-size: 0.75rem; padding: 2px 10px;">
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
                <li class="nav-item"><a class="nav-link" href="learning.php">Learning</a></li>
                <li class="nav-item"><a class="nav-link" href="practice.php">Practice GD</a></li>
                <li class="nav-item"><a class="nav-link active" href="feedback.php">My Feedback</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <h2 class="text-center mb-4">📊 Performance Analytics</h2>
    
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <canvas id="performanceChart" height="80"></canvas>
        </div>
    </div>

    <h3 class="mb-4"><i class="bi bi-journal-check"></i> Session History</h3>

    <?php if (mysqli_num_rows($result) > 0) { ?>
        <div class="row g-4">
            <?php 
            mysqli_data_seek($result, 0); // Reset pointer
            while ($row = mysqli_fetch_assoc($result)) { 
                $g_score = $row['grammar_score'];
                $s_score = $row['sentiment_score'];
                
                // Color logic
                $g_class = $g_score >= 80 ? 'score-good' : ($g_score >= 50 ? 'score-avg' : 'score-bad');
                $s_class = $s_score >= 70 ? 'score-good' : ($s_score >= 40 ? 'score-avg' : 'score-bad');
                
                // Truncate topic if too long
                $topic_display = strlen($row['topic']) > 40 ? substr($row['topic'], 0, 40) . '...' : $row['topic'];
                
                // Safe fetch for new columns
                $corrected = $row['corrected_text'] ?? "Not available";
                $polite = $row['polite_text'] ?? "Not available";
            ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 card-hover">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <small class="text-muted"><i class="bi bi-calendar"></i> <?php echo date("d M Y, h:i A", strtotime($row['session_date'])); ?></small>
                            <span class="badge bg-secondary"><?php echo $row['speaking_time']; ?> sec</span>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary mb-3"><?php echo htmlspecialchars($topic_display); ?></h5>
                            
                            <div class="d-flex justify-content-center gap-4 mb-3">
                                <div>
                                    <div class="score-circle <?php echo $g_class; ?> fs-5"><?php echo $g_score; ?></div>
                                    <small class="text-muted d-block mt-1">Grammar</small>
                                </div>
                                <div>
                                    <div class="score-circle <?php echo $s_class; ?> fs-5"><?php echo $s_score; ?></div>
                                    <small class="text-muted d-block mt-1">Sentiment</small>
                                </div>
                            </div>

                            <button class="btn btn-outline-primary btn-sm w-100 view-btn"
                                data-topic="<?php echo htmlspecialchars($row['topic']); ?>"
                                data-grammar="<?php echo $g_score; ?>"
                                data-sentiment="<?php echo $s_score; ?>"
                                data-original="<?php echo htmlspecialchars($row['transcript']); ?>" 
                                data-corrected="<?php echo htmlspecialchars($corrected); ?>"
                                data-polite="<?php echo htmlspecialchars($polite); ?>"
                                data-tips="<?php echo htmlspecialchars($row['improvement_tips']); ?>">
                                <i class="bi bi-eye"></i> View Full Analysis
                            </button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="alert alert-info text-center py-5">
            <h4>No sessions found!</h4>
            <p>Go to the <a href="practice.php">Practice Page</a> to start your first GD.</p>
        </div>
    <?php } ?>
</div>

<footer class="bg-dark text-light py-3 text-center mt-5">
    <p class="mb-0">&copy; <?php echo date('Y'); ?> Namma GD | AI-Powered Group Discussion Platform</p>
</footer>

<div class="modal fade" id="analysisModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="m-topic">Feedback Analysis</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        
        <div class="row text-center mb-3">
            <div class="col-6">
                <h3 class="text-success" id="m-grammar"></h3>
                <small>Grammar Score</small>
            </div>
            <div class="col-6">
                <h3 class="text-info" id="m-sentiment"></h3>
                <small>Sentiment Score</small>
            </div>
        </div>
        <hr>

        <h6>📝 Original Transcript</h6>
        <div class="feedback-modal-box bg-light" id="m-original"></div>

        <h6>✨ Corrected Grammar</h6>
        <div class="feedback-modal-box" style="background:#e8f5e9; border-color:#28a745;" id="m-corrected"></div>

        <h6>👔 Polite Version</h6>
        <div class="feedback-modal-box" style="background:#e3f2fd; border-color:#0d6efd;" id="m-polite"></div>

        <h6 class="text-danger mt-3">💡 Improvement Tips</h6>
        <ul id="m-tips" class="list-group list-group-flush"></ul>

      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// --- CHART LOGIC ---
<?php
// Prepare chart data again for JS
$dates = [];
$grammarScores = [];
$sentimentScores = [];

mysqli_data_seek($result, 0); 
while ($row = mysqli_fetch_assoc($result)) {
    $dates[] = date("d M", strtotime($row['session_date']));
    $grammarScores[] = $row['grammar_score'];
    $sentimentScores[] = $row['sentiment_score'];
}
?>

// Only render chart if data exists
<?php if(count($dates) > 0): ?>
const ctx = document.getElementById('performanceChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode(array_reverse($dates)); ?>, // Reverse to show timeline left-to-right
        datasets: [
            {
                label: 'Grammar',
                data: <?php echo json_encode(array_reverse($grammarScores)); ?>,
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                fill: true,
                tension: 0.3
            },
            {
                label: 'Sentiment',
                data: <?php echo json_encode(array_reverse($sentimentScores)); ?>,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                fill: true,
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' }
        },
        scales: {
            y: { beginAtZero: true, max: 100 }
        }
    }
});
<?php endif; ?>

// --- MODAL LOGIC (INTELLIGENT PARSER) ---
const buttons = document.querySelectorAll('.view-btn');
const modal = new bootstrap.Modal(document.getElementById('analysisModal'));

buttons.forEach(btn => {
    btn.addEventListener('click', () => {
        // 1. Populate Header & Scores
        document.getElementById('m-topic').innerText = btn.getAttribute('data-topic');
        document.getElementById('m-grammar').innerText = btn.getAttribute('data-grammar') + '%';
        document.getElementById('m-sentiment').innerText = btn.getAttribute('data-sentiment') + '%';
        
        // 2. PARSE TRANSCRIPT DATA
        let rawOriginal = btn.getAttribute('data-original');
        let rawCorrected = btn.getAttribute('data-corrected');
        let rawPolite = btn.getAttribute('data-polite');

        let finalOriginal = rawOriginal;
        let finalCorrected = rawCorrected;
        let finalPolite = rawPolite;

        // CHECK IF OLD DATA FORMAT (Original + Corrected combined in one field)
        if (rawOriginal.includes("Corrected:") && (rawCorrected === 'Not available' || rawCorrected === '')) {
            // Split manually
            try {
                let parts = rawOriginal.split("Corrected:");
                finalOriginal = parts[0].replace("Original:", "").trim(); // First part is Original
                
                if (parts[1]) {
                    // Check for Polite part inside Corrected
                    if (parts[1].includes("Polite:")) {
                        let subParts = parts[1].split("Polite:");
                        finalCorrected = subParts[0].trim();
                        finalPolite = subParts[1].trim();
                    } else {
                        finalCorrected = parts[1].trim();
                    }
                }
            } catch (e) {
                console.error("Parsing error", e);
            }
        } 
        // CLEANUP: Remove any "Original:" prefix if it exists in newer data
        finalOriginal = finalOriginal.replace("Original:", "").trim();

        // Update Modal Boxes
        document.getElementById('m-original').innerText = finalOriginal;
        document.getElementById('m-corrected').innerText = finalCorrected;
        document.getElementById('m-polite').innerText = finalPolite;

        // 3. Format Tips
        const tipsList = document.getElementById('m-tips');
        tipsList.innerHTML = '';
        let tipsRaw = btn.getAttribute('data-tips');
        
        // Filter empty tips and split by comma or newline
        let tips = tipsRaw.split(/,|\n/).filter(t => t.trim().length > 0);
        
        if(tips.length === 0) {
            tipsList.innerHTML = '<li class="list-group-item text-muted">No tips available.</li>';
        } else {
            tips.forEach(t => {
                let cleanTip = t.replace(/[\[\]"]/g, '').trim(); // Remove JSON symbols
                if(cleanTip) {
                    let li = document.createElement('li');
                    li.className = "list-group-item";
                    li.innerText = "👉 " + cleanTip;
                    tipsList.appendChild(li);
                }
            });
        }

        modal.show();
    });
});
</script>

</body>
</html>