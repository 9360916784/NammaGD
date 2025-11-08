<?php
session_start();
include "connection.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM users"))['c'];
$total_topics = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM gd_topics"))['c'];
$total_feedback = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM gd_feedback"))['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reports</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <h2>Admin Reports</h2>
  <div class="row">
    <div class="col-md-4"><div class="alert alert-info">Total Users: <b><?= $total_users ?></b></div></div>
    <div class="col-md-4"><div class="alert alert-warning">Total Topics: <b><?= $total_topics ?></b></div></div>
    <div class="col-md-4"><div class="alert alert-success">Total Feedback: <b><?= $total_feedback ?></b></div></div>
  </div>
  <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</body>
</html>
