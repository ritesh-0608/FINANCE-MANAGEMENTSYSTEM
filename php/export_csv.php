<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

require 'db.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=transactions.csv');

$user_id = $_SESSION['user_id'];
$output = fopen('php://output', 'w');
fputcsv($output, array('ID', 'Category', 'Type', 'Sub Type', 'Amount', 'Date')); // Column headers

$sql = "SELECT id, category, type, sub_type, amount, transaction_date FROM transactions WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $row['transaction_date'] = '"' . date('Y-m-d', strtotime($row['transaction_date'])) . '"'; // Ensure date is formatted as YYYY-MM-DD and treated as string
    fputcsv($output, $row);
}

fclose($output);
$stmt->close();
$conn->close();
?>