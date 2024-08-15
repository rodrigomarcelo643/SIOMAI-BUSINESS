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

if (isset($_POST['transaction_time'])) {
    $transactionTime = $_POST['transaction_time'];

    // Prepare SQL statement to delete order from the database
    $delete_sql = "DELETE FROM receipt_table WHERE transaction_time = '$transactionTime'";

    if ($conn->query($delete_sql) === TRUE) {
        echo "Transaction deleted successfully.";
    } else {
        echo "Error deleting transaction: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
