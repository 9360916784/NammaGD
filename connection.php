<?php

$server = "localhost";
$username = "root";
$password = "";
$db = "namma_gd";

$conn = new mysqli($server, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set to prevent SQL injection with special characters
$conn->set_charset("utf8mb4");

?>