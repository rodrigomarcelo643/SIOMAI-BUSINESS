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

// Get product name and quantity from POST request
$productName = $_POST['productName'];
$quantity = $_POST['quantity'];

// Insert new order into database
$sql = "INSERT INTO receipt_table (product, quantity) VALUES ('$productName', '$quantity')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
?>
