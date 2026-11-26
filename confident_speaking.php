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
  <title>Confident Speaking - Namma GD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <style>
    .option-card {
      border-radius: 15px;
      padding: 20px;
      margin: 15px 0;
      cursor: pointer;
      display: flex;
      align-items: center;
      transition: transform 0.2s ease;
    }
    .option-card:hover {
      transform: scale(1.03);
    }
    .option-card i {
      font-size: 28px;
      margin-right: 15px;
      color: #f39c12;
    }
  </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid position-relative">
    
    <a class="navbar-brand" href="dashboard.php"><i class="fa fa-comments"></i> Namma GD</a>
    
    <a href="learning.php" class="btn btn-danger btn-sm shadow-sm" 
       style="position: absolute; top: 50px; left: 10px; z-index: 1050; font-size: 0.75rem; padding: 2px 10px;">
        <i class="bi bi-arrow-left"></i> Back
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="learning.php">Learning</a></li>
          <li class="nav-item"><a class="nav-link active" href="confident_speaking.php">Confident Speaking</a></li>
          <li class="nav-item"><a class="nav-link" href="practice.php">Practice</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <h2 class="text-center mb-4">Tips for Confident Speaking</h2>

  <div onclick="window.location.href='confident_speaking_content.php?type=tips'" 
       class="option-card bg-danger-subtle">
    <i class="fa fa-lightbulb"></i> <h5>Tips</h5>
  </div>

  <div onclick="window.location.href='confident_speaking_content.php?type=dosdonts'" 
       class="option-card bg-primary-subtle">
    <i class="fa fa-check-circle"></i> <h5>Do's and Don'ts</h5>
  </div>

  <div onclick="window.location.href='confident_speaking_content.php?type=faqs'" 
       class="option-card bg-info-subtle">
    <i class="fa fa-question-circle"></i> <h5>FAQs</h5>
  </div>

  <div onclick="window.location.href='confident_speaking_content.php?type=mistakes'" 
       class="option-card bg-success-subtle">
    <i class="fa fa-exclamation-triangle"></i> <h5>Mistakes</h5>
  </div>

  <div onclick="window.location.href='confident_speaking_content.php?type=phrases'" 
       class="option-card bg-warning-subtle">
    <i class="fa fa-language"></i> <h5>Phrases</h5>
  </div>

  <div onclick="window.location.href='confident_speaking_content.php?type=skills'" 
       class="option-card bg-success-subtle">
    <i class="fa fa-brain"></i> <h5>Skills</h5>
  </div>

  <div onclick="window.location.href='confident_speaking_content.php?type=howtoface'" 
       class="option-card bg-warning-subtle">
    <i class="fa fa-user-shield"></i> <h5>How to Face</h5>
  </div>
</div>

<footer class="bg-dark text-light py-3 text-center mt-4">
  <p class="mb-0">&copy; <?php echo date('Y'); ?> Namma GD | AI-Powered GD Platform</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>