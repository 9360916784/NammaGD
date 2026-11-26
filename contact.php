<?php
session_start();
include "connection.php"; // Make sure your DB connection file is correct

if (isset($_POST['submit'])) {
    // 1. Get and sanitize input data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // 2. Insert into Database
    $sql = "INSERT INTO contact_messages (name, email, subject, message) 
            VALUES ('$name', '$email', '$subject', '$message')";

    if (mysqli_query($conn, $sql)) {
        // Success: Alert and redirect back to Home
        echo "<script>
                alert('Thank you! Your message has been sent successfully.');
                window.location.href='index.php';
              </script>";
    } else {
        // Error
        echo "<script>
                alert('Something went wrong. Please try again.');
                window.location.href='index.php';
              </script>";
    }
} else {
    // If accessed directly without submitting
    header("Location: index.php");
    exit();
}
?>