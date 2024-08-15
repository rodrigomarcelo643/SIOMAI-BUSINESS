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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $product = $_POST['product'];
    $quantity = $_POST['quantity'];
    // Get the total price based on product and quantity
    $total_price = getTotalPrice($product, $quantity);

    // Prepare and bind SQL statement to insert data into the database
    $stmt = $conn->prepare("INSERT INTO orders (product, quantity, total_price) VALUES (?, ?, ?)");
    $stmt->bind_param("sid", $product, $quantity, $total_price);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close prepared statement
    $stmt->close();
}

// Function to calculate total price for a product
function getTotalPrice($product, $quantity) {
    $priceMap = array(
        'tofu' => 9.00,
        'siomai' => 24.00,
        'NGOHIONG' => 9.00,
        'beef' => 24.00,
        'chicken' => 24.00,
        'tempura' => 22.00,
        'pork' => 24.00,
        'lumpia' => 10.00,
        'japanese' => 24.00,
        'squid' => 10.00,
        'hotdog' => 13.00,
        'puso' => 4.00,
        // Add more products here
    );

    // Get the price per item
    $price = $priceMap[$product];

    // Calculate total price
    $total_price = $price * $quantity;

    return $total_price;
}

// Close the database connection
$conn->close();
?>
