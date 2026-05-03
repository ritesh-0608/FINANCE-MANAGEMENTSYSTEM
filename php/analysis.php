<?php
include 'db.php';
session_start();

$user_id = $_SESSION['user_id'];

$sql = "SELECT 
    SUM(CASE WHEN category = 'income' THEN amount ELSE 0 END) AS total_income,
    SUM(CASE WHEN category = 'expense' THEN amount ELSE 0 END) AS total_expense,
    SUM(CASE WHEN category = 'income' AND type = 'office' THEN amount ELSE 0 END) AS office_income,
    SUM(CASE WHEN category = 'income' AND type = 'home' THEN amount ELSE 0 END) AS home_income,
    SUM(CASE WHEN category = 'income' AND type = 'free-lancing' THEN amount ELSE 0 END) AS freelancing_income,
    SUM(CASE WHEN category = 'income' AND type = 'others' THEN amount ELSE 0 END) AS other_income,
    SUM(CASE WHEN category = 'expense' AND type = 'food' THEN amount ELSE 0 END) AS food_expense,
    SUM(CASE WHEN category = 'expense' AND type = 'grocery' THEN amount ELSE 0 END) AS grocery_expense,
    SUM(CASE WHEN category = 'expense' AND type = 'rent' THEN amount ELSE 0 END) AS rent_expense,
    SUM(CASE WHEN category = 'expense' AND type = 'bills' THEN amount ELSE 0 END) AS bills_expense,
    SUM(CASE WHEN category = 'expense' AND type = 'shopping' THEN amount ELSE 0 END) AS shopping_expense,
    SUM(CASE WHEN category = 'expense' AND type = 'others' THEN amount ELSE 0 END) AS other_expense
    FROM Transactions WHERE user_id='$user_id'";

$result = $conn->query($sql);
$totals = $result->fetch_assoc();

echo json_encode($totals);

$conn->close();
?>