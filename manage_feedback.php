<?php
session_start();
include "connection.php";

// Restrict access only to admin
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$sql = "SELECT f.*, u.username, u.email 
        FROM gd_feedback f
        JOIN users u ON f.user_id = u.id
        ORDER BY f.session_date DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Feedback</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
<div class="container mt-4">
  <h2 class="mb-4"><i class="fa fa-comments"></i> Manage Feedback</h2>

  <?php if (isset($_GET['deleted'])) { ?>
    <div class="alert alert-success">Feedback deleted successfully!</div>
  <?php } elseif (isset($_GET['updated'])) { ?>
    <div class="alert alert-success">Feedback updated successfully!</div>
  <?php } ?>

  <?php if (mysqli_num_rows($result) > 0) { ?>
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>User</th>
          <th>Email</th>
          <th>Topic</th>
          <th>Grammar Score</th>
          <th>Sentiment Score</th>
          <th>Speaking Time (sec)</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; while ($row = mysqli_fetch_assoc($result)) { ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['topic']) ?></td>
            <td><?= $row['grammar_score'] ?></td>
            <td><?= $row['sentiment_score'] ?></td>
            <td><?= $row['speaking_time'] ?></td>
            <td><?= $row['session_date'] ?></td>
            <td>
              <a href="edit_feedback.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                <i class="fa fa-edit"></i> Edit
              </a>
              <a href="delete_feedback.php?id=<?= $row['id'] ?>" 
                 class="btn btn-danger btn-sm"
                 onclick="return confirm('Are you sure you want to delete this feedback?');">
                <i class="fa fa-trash"></i> Delete
              </a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php } else { ?>
    <div class="alert alert-info">No feedback found yet.</div>
  <?php } ?>

  <a href="admin_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
</body>
</html>
