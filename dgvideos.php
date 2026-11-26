<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include "connection.php";

// Fetch videos
$sql = "SELECT * FROM gd_videos ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
$videos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $videos[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GD Learning Videos - Namma GD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <style>
    body {
        background-color: #f8f9fa;
    }
    .video-list {
        max-height: 80vh;
        overflow-y: auto;
    }
    .video-item {
        cursor: pointer;
        padding: 10px 15px;
        border-bottom: 1px solid #dee2e6;
    }
    .video-item:hover, .video-item.active {
        background-color: #0d6efd;
        color: white;
    }
    iframe {
        width: 100%;
        height: 450px;
        border-radius: 10px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php"><i class="bi bi-chat"></i> Namma GD</a>
    <a href="learning.php" class="btn btn-danger btn-sm shadow-sm" 
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
        <li class="nav-item"><a class="nav-link active" href="dgvideos.php">Learning Videos</a></li>
        <li class="nav-item"><a class="nav-link" href="practice.php">Practice GD</a></li>
        <li class="nav-item"><a class="nav-link" href="feedback.php">My Feedback</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Page Title -->
<div class="container my-4">
  <h2 class="text-center mb-4">🎥 Group Discussion Learning Videos</h2>
</div>

<div class="container">
  <div class="row">
    
    <!-- Video List -->
    <div class="col-md-4 mb-4">
      <div class="list-group shadow-sm video-list" id="videoList">
        <?php if (count($videos) > 0): ?>
          <?php foreach ($videos as $index => $video): 
              // Extract YouTube video ID
              preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $video['youtube_url'], $matches);
              $video_id = $matches[1] ?? '';
          ?>
          <div class="video-item <?php echo $index === 0 ? 'active' : ''; ?>" 
               data-id="<?php echo $video_id; ?>">
            <i class="bi bi-play-circle"></i> <?php echo htmlspecialchars($video['title']); ?>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="alert alert-warning">No videos available. Please ask admin to add videos.</div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Player -->
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-body">
          <?php if (count($videos) > 0): 
              preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $videos[0]['youtube_url'], $m);
              $first_id = $m[1] ?? '';
          ?>
          <iframe id="videoPlayer" 
                  src="https://www.youtube.com/embed/<?php echo $first_id; ?>" 
                  allowfullscreen></iframe>
          <?php else: ?>
          <p class="text-center">No videos found.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>

  </div>
</div>

<footer class="bg-dark text-light py-3 text-center mt-4">
  <p class="mb-0">&copy; <?php echo date('Y'); ?> Namma GD | AI-Powered Group Discussion Platform</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
const items = document.querySelectorAll('.video-item');
const player = document.getElementById('videoPlayer');

items.forEach(item => {
  item.addEventListener('click', () => {
    items.forEach(i => i.classList.remove('active'));
    item.classList.add('active');
    const vid = item.getAttribute('data-id');
    player.src = "https://www.youtube.com/embed/" + vid;
  });
});
</script>

</body>
</html>
