<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "finance_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
// Note: Ensure you do not commit raw passwords to public repositories


