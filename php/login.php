<?php
session_start();
include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT id, username, password FROM Users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: ../add_edit_transaction.html");
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No user found with that username.";
}

$stmt->close();
$conn->close();
?>