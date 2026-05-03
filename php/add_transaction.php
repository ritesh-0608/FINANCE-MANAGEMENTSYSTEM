<?php
include 'db.php';
session_start();

$user_id = $_SESSION['user_id'];
$category = $_POST['category'];
$type = $_POST['type'];
$sub_type = $_POST['sub_type'];
$amount = $_POST['amount'];
$transaction_date = $_POST['transaction_date'];

$sql = "INSERT INTO Transactions (user_id, category, type, sub_type, amount, transaction_date) 
        VALUES ('$user_id', '$category', '$type', '$sub_type', '$amount', '$transaction_date')";

if ($conn->query($sql) === TRUE) {
    echo "Transaction added successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>