<?php
include 'db.php';

$name = $_POST['name'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$sql = "INSERT INTO Users (name, username, email, password) VALUES ('$name', '$username', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    header("Location: ../login.html");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>