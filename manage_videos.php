<?php
session_start();

// Optional: restrict to admin
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include "connection.php";

// --- Add Video ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_video'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $url = mysqli_real_escape_string($conn, $_POST['youtube_url']);

    if (!empty($title) && !empty($url)) {
        $insert = "INSERT INTO gd_videos (title, youtube_url) VALUES ('$title', '$url')";
        mysqli_query($conn, $insert);
        $msg = "Video added successfully!";
    } else {
        $msg = "Please fill all fields.";
    }
}

// --- Delete Video ---
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $id = mysqli_real_escape_string($conn, $id);
    mysqli_query($conn, "DELETE FROM gd_videos WHERE id = $id");
    header("Location: manage_videos.php");
    exit();
}

// --- Fetch All Videos ---
$result = mysqli_query($conn, "SELECT * FROM gd_videos ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage GD Videos - Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <style>
    body {
        background-color: #f8f9fa;
    }
    .table thead {
        background-color: #343a40;
        color: white;
    }
    .card {
        border-radius: 10px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><i class="fa fa-user-shield"></i> Admin Panel</a>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <span class="nav-link text-light">Welcome, <?php echo $_SESSION['username']; ?></span>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

<!-- Page Header -->
<div class="container mt-4">
  <h2 class="text-center mb-4">🎬 Manage GD Learning Videos</h2>

  <?php if (!empty($msg)): ?>
  <div class="alert alert-info text-center"><?php echo $msg; ?></div>
  <?php endif; ?>

  <!-- Add Video Form -->
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <h5>Add New Video</h5>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Video Title</label>
          <input type="text" name="title" class="form-control" placeholder="Enter video title" required>
        </div>
        <div class="mb-3">
          <label class="form-label">YouTube URL</label>
          <input type="url" name="youtube_url" class="form-control" placeholder="https://www.youtube.com/watch?v=..." required>
        </div>
        <button type="submit" name="add_video" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add Video</button>
      </form>
    </div>
  </div>

  <!-- Video Table -->
  <div class="card shadow-sm">
    <div class="card-body">
      <h5>All Videos</h5>
      <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
          <thead>
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>YouTube Link</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td>
                  <a href="<?php echo htmlspecialchars($row['youtube_url']); ?>" target="_blank" class="text-primary">
                    <?php echo htmlspecialchars($row['youtube_url']); ?>
                  </a>
                </td>
                <td>
                  <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" 
                     onclick="return confirm('Are you sure you want to delete this video?');">
                    <i class="bi bi-trash"></i> Delete
                  </a>
                </td>
              </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="4" class="text-center">No videos found.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<footer class="bg-dark text-light py-3 text-center mt-4">
  <p class="mb-0">&copy; <?php echo date('Y'); ?> Namma GD | Admin Control Panel</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
