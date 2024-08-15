<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "receipt_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the transaction time from the AJAX request
$transactionTime = $_POST['transactionTime'];

// SQL to delete the group
$sql = "DELETE FROM receipt_table WHERE transaction_time = '$transactionTime'";

if ($conn->query($sql) === TRUE) {
    // If deletion is successful, send a success response
    echo "success";
} else {
    // If an error occurs, send an error response
    echo "error";
}

// Close the connection
$conn->close();
?>
