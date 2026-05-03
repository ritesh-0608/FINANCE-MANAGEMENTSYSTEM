<?php
include 'db.php';

$transaction_id = $_POST['transaction_id'];

$sql = "DELETE FROM Transactions WHERE id='$transaction_id'";

if ($conn->query($sql) === TRUE) {
    echo "Transaction deleted successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>