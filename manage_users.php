<?php
session_start();
include "connection.php";

// Restrict access to admin only
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Handle role update
if (isset($_POST['update_role'])) {
    $user_id = intval($_POST['user_id']);
    $new_role = $_POST['role'];
    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $new_role, $user_id);
    $stmt->execute();
    header("Location: manage_users.php");
    exit();
}

// Handle delete user
if (isset($_POST['delete_user'])) {
    $user_id = intval($_POST['user_id']);
    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    header("Location: manage_users.php");
    exit();
}

// Fetch all users
$sql = "SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Users - Namma GD</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="admin_dashboard.php"><i class="fa fa-user-shield"></i> Admin Panel</a>
      <div class="collapse navbar-collapse">
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
    <h1 class="mb-4">Manage Users</h1>

    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>Role</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo htmlspecialchars($row['username']); ?></td>
          <td><?php echo htmlspecialchars($row['email']); ?></td>
          <td>
            <form method="POST" class="d-flex">
              <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
              <select name="role" class="form-select form-select-sm">
                <option value="student" <?php if ($row['role']=="student") echo "selected"; ?>>Student</option>
                <option value="admin" <?php if ($row['role']=="admin") echo "selected"; ?>>Admin</option>
              </select>
              <button type="submit" name="update_role" class="btn btn-sm btn-success ms-2">Update</button>
            </form>
          </td>
          <td><?php echo $row['created_at']; ?></td>
          <td>
            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
              <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
              <button type="submit" name="delete_user" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
            </form>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</body>
</html>
