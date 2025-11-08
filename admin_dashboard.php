<?php
session_start();

// Restrict access only to admin
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Namma GD</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

  <!-- Main Container -->
  <div class="container mt-4">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row g-4">

      <!-- Manage Users -->
      <div class="col-md-4">
        <div class="card shadow-sm p-3">
          <h4><i class="fa fa-users"></i> Manage Users</h4>
          <br>
          <p>View, edit, or delete registered users.</p>
          <a href="manage_users.php" class="btn btn-primary btn-sm">Go</a>
        </div>
      </div>

      <!-- Manage Feedback -->
      <div class="col-md-4">
        <div class="card shadow-sm p-3">
          <h4><i class="fa fa-comments"></i> Manage Feedback</h4>
          <p>Review and analyze feedback submitted by users.</p>
          <a href="manage_feedback.php" class="btn btn-primary btn-sm">Go</a>
        </div>
      </div>

      <!-- Manage GD Topics -->
      <div class="col-md-4">
        <div class="card shadow-sm p-3">
          <h4><i class="fa fa-lightbulb"></i> Manage Topics</h4>
          <br>
          <p>Add, edit, or delete GD topics.</p>
          <a href="manage_topics.php" class="btn btn-primary btn-sm">Go</a>
        </div>
      </div>

      <!-- Manage GD Videos -->
      <div class="col-md-4">
        <div class="card shadow-sm p-3">
          <h4><i class="bi bi-play-btn"></i> Manage GD Videos</h4>
          <p>Add, edit, or delete GD learning videos for students.</p>
          <a href="manage_videos.php" class="btn btn-primary btn-sm">Go</a>
        </div>
      </div>


      <!-- Reports -->
      <div class="col-md-4">
        <div class="card shadow-sm p-3">
          <h4><i class="fa fa-chart-bar"></i> Reports</h4>
          <p>View statistics on users, topics, and feedback.</p>
          <a href="reports.php" class="btn btn-primary btn-sm">Go</a>
        </div>
      </div>

    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-light py-3 text-center mt-5">
    <p class="mb-0">&copy; <?php echo date('Y'); ?> Namma GD | AI-Powered Group Discussion Platform</p>
  </footer>

</body>
</html>
