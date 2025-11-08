<?php
session_start();
include "connection.php";

// Restrict access only to admin
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: manage_feedback.php");
    exit();
}

$id = intval($_GET['id']);
$sql = "DELETE FROM gd_feedback WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: manage_feedback.php?deleted=1");
    exit();
} else {
    echo "Error deleting feedback: " . mysqli_error($conn);
}
