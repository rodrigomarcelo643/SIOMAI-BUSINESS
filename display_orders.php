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

// Query to retrieve data grouped by transaction time
$sql = "SELECT transaction_time, GROUP_CONCAT(CONCAT(product, ' (', quantity, ')') SEPARATOR ', ') AS items, SUM(total_price) AS total_price
        FROM receipt_table
        GROUP BY transaction_time
        ORDER BY transaction_time DESC"; // Group by transaction_time and sort by descending order

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Initialize counter variable
    $customerNumber = 1;
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $transactionTime = $row["transaction_time"];
        $items = $row["items"];
        $totalPrice = $row["total_price"];
        
        // Escape special characters in the receipt details
        $transactionTime = htmlspecialchars($transactionTime);
        $items = htmlspecialchars($items);
        $totalPrice = htmlspecialchars($totalPrice);

        echo "<div class='transaction-container'>";
        echo "<strong class='transaction-time'>Customer </strong> " . $customerNumber++ . "<br>";
        echo "<strong class='transaction-time'>Transaction Time:</strong> " . $transactionTime . "<br>";
        echo "<strong class='transaction-items'>Items:</strong> " . $items . "<br>";
        echo "<strong class='transaction-total-price'>Grand Total:</strong> ₱" . $totalPrice . "<br>";

        // Add a print button to each transaction container
        echo "<button class ='buts' onclick='printTransaction(\"" . $transactionTime . "\", \"" . $items . "\", \"" . $totalPrice . "\")'>Print</button>";

        echo "</div>";
    }
} else {
    echo "No transactions found.";
}

// Close the connection
$conn->close();
?>
