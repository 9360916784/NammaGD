<?php
include "connection.php";
if (isset($_POST['room_id'])) {
    $room_id = intval($_POST['room_id']);
    // Decrease count
    mysqli_query($conn, "UPDATE active_gd_rooms SET participants = participants - 1 WHERE id = $room_id AND participants > 0");
    
    // Optional: If 0 participants left, mark as completed (or delete) to keep DB clean
    mysqli_query($conn, "UPDATE active_gd_rooms SET status = 'completed' WHERE id = $room_id AND participants = 0");
}
?>