<?php
// Establish connection to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "order_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL statement to delete all data from the orders table
$delete_sql = "DELETE FROM orders";

if ($conn->query($delete_sql) === TRUE) {
    echo "Data deleted successfully";
} else {
    echo "Error deleting data: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
