<?php
include 'db.php';
session_start();

$user_id = $_SESSION['user_id'];
$name = $_POST['name'];
$username = $_POST['username'];

$sql = "UPDATE Users SET name='$name', username='$username' WHERE id='$user_id'";

if ($conn->query($sql) === TRUE) {
    echo "Profile updated successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>