<?php
include 'db.php';
session_start();

$transaction_id = $_POST['transaction_id'];
$category = $_POST['category'];
$type = $_POST['type'];
$sub_type = $_POST['sub_type'];
$amount = $_POST['amount'];
$transaction_date = $_POST['transaction_date'];

$sql = "UPDATE Transactions 
        SET category='$category', type='$type', sub_type='$sub_type', amount='$amount', transaction_date='$transaction_date'
        WHERE id='$transaction_id'";

if ($conn->query($sql) === TRUE) {
    header("Location: ../dashboard.php"); // ✅ Redirect user to dashboard
    exit(); // ✅ Always call exit after header
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>