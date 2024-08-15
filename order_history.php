<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the raw POST data
    $json_data = file_get_contents("php://input");

    // Decode the JSON data
    $receipt_data = json_decode($json_data, true);

    // Get the current timestamp for the transaction time
    $transaction_time = date("Y-m-d H:i:s");

    // Database connection parameters for the other database
    $other_servername = "localhost";
    $other_username = "root";
    $other_password = "";
    $other_dbname = "receipt_db";

    // Create connection to the other database
    $other_conn = new mysqli($other_servername, $other_username, $other_password, $other_dbname);

    // Check connection to the other database
    if ($other_conn->connect_error) {
        die("Connection to other database failed: " . $other_conn->connect_error);
    }

    // Prepare and execute SQL statement to insert receipt data into the other database
    $insert_query = "INSERT INTO receipt_table (product, quantity, total_price, transaction_time) VALUES (?, ?, ?, ?)";
    $insert_statement = $other_conn->prepare($insert_query);
    $insert_statement->bind_param("ssis", $product, $quantity, $total_price, $transaction_time);

    foreach ($receipt_data as $row) {
        // Exclude grand total from receipt data
        if ($row['product'] !== 'Grand Total') {
            $product = $row['product'];
            $quantity = $row['quantity'];
            $total_price = $row['total_price'];
            $insert_statement->execute();
        }
    }

    

    // Close the prepared statement
    $insert_statement->close();

    // Close the connection to the other database
    $other_conn->close();

    // Send a response indicating success
    http_response_code(200);
    echo "Receipt data successfully saved to the other database.";

} else {
    // Invalid request method
    http_response_code(405);
    echo "Invalid request method.";
}
?>
