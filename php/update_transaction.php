<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

require 'db.php';

$user_id = $_SESSION['user_id'];
$transaction_id = $_GET['id'];
$category = $_POST['category'];
$type = $_POST['type'];
$sub_type = $_POST['sub_type'];
$amount = $_POST['amount'];
$transaction_date = $_POST['transaction_date'];

$sql = "UPDATE transactions SET category = ?, type = ?, sub_type = ?, amount = ?, transaction_date = ? WHERE user_id = ? AND id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi", $category, $type, $sub_type, $amount, $transaction_date, $user_id, $transaction_id);

if ($stmt->execute()) {
    echo "Transaction updated successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>