<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

require 'db.php';

$id = $_POST['id'];
$category = $_POST['category'];
$type = $_POST['type'];
$sub_type = $_POST['sub_type'];
$amount = $_POST['amount'];
$transaction_date = $_POST['transaction_date'];
$user_id = $_SESSION['user_id'];

if (empty($id)) {
    // Insert new transaction
    $sql = "INSERT INTO transactions (user_id, category, type, sub_type, amount, transaction_date) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssds", $user_id, $category, $type, $sub_type, $amount, $transaction_date);
} else {
    // Update existing transaction
    $sql = "UPDATE transactions SET category = ?, type = ?, sub_type = ?, amount = ?, transaction_date = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdssi", $category, $type, $sub_type, $amount, $transaction_date, $id, $user_id);
}

if ($stmt->execute()) {
    // Redirect back to transaction history
    header("Location: ../transaction_history.html");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>