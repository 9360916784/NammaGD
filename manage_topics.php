<?php
session_start();
include "connection.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Add topic
if (isset($_POST['add_topic'])) {
    $topic = mysqli_real_escape_string($conn, $_POST['topic']);
    $topic = mysqli_real_escape_string($conn, $topic);
    if (!empty($topic)) {
        mysqli_query($conn, "INSERT INTO gd_topics (topic) VALUES ('$topic')");
    }
}

// Delete topic
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $id = mysqli_real_escape_string($conn, $id);
    mysqli_query($conn, "DELETE FROM gd_topics WHERE id=$id");
}

$topics = mysqli_query($conn, "SELECT * FROM gd_topics ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Topics</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
  <h2>Manage GD Topics</h2>
  <form method="POST" class="mb-3">
    <input type="text" name="topic" class="form-control" placeholder="Enter new GD topic" required>
    <button type="submit" name="add_topic" class="btn btn-success mt-2">Add Topic</button>
  </form>

  <table class="table table-bordered">
    <thead>
      <tr><th>ID</th><th>Topic</th><th>Action</th></tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($topics)) { ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['topic']) ?></td>
          <td>
            <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</div>
</body>
</html>
