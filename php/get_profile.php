<?php
include 'db.php';
session_start();

$user_id = $_SESSION['user_id'];

$sql = "SELECT name, username, email FROM Users WHERE id='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode([]);
}

$conn->close();
?>