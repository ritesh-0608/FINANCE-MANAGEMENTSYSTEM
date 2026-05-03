<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

require 'db.php';

$user_id = $_SESSION['user_id'];
$transaction_id = $_GET['id'];

$sql = "SELECT id, category, type, sub_type, amount, transaction_date FROM transactions WHERE user_id = ? AND id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $transaction_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode([]);
}

$stmt->close();
$conn->close();
?>