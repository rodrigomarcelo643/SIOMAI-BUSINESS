<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
  
        /* General styles */
        body {
            margin: 0;
            font-family: 'Comic Sans MS', cursive, sans-serif; /* Amusing font */
            background-color: #ffffff; /* White background */
            overflow-x:hidden;
            transition: background-color 0.5s;
          
        }

        /* Sidebar styles */
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0; /* Always on the left side */
            background: #800000; /* Maroon sidebar */
            overflow-x: hidden;
            transition: width 0.5s;
            padding-top: 60px;
            position:fixed;
            z-index: 1000;
            border-right: 2px solid #4d0000; /* Darker maroon border */
        }

        .sidebar a {
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            color: #ffffff;
            display: block;
            transition: background-color 0.3s;
            border-bottom: 2px solid #4d0000; /* Darker maroon border bottom */
        }

        .sidebar a:hover {
            background-color: #4d0000; /* Darker maroon on hover */
        }

        /* Main content styles */
        .content_section {
            background-image:url('siomai.png');
            margin-left: 250px; /* Adjusted for the width of the sidebar */
            padding: 20px;
            background-color: #ffffff; /* White main content background */
            color: #000000; /* Black text color */
            transition: margin-left 0.5s;
            min-height: 100vh;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align:center;
            padding:300px;
    
        }

        /* Other styles */
        h2 {
            margin-top: 0;
            color: white;
    
        }

        .transaction-container {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border-top: 2px dashed #800000; 
            border-bottom: 2px dashed #800000; /* Maroon dashed border bottom */
            padding-bottom: 10px;
            margin-top:100px;
            padding-top:50px;
            border-radius:15px;
            background-color:white;
            padding-bottom:50px;
            height:auto;
           
        }
        

        .transaction-time {
            font-weight: bold;
            color: #800000;
            line-height:45px;   
            font-size:25px;
        }
        .transaction-items{
            line-height:45px;
            font-size:25px;
        }

        .transaction-total-price {
            font-weight: bold;
            font-size:25px;
            color: green; /* Darker maroon total price */
        }
        .content_section h2{
            text-align:center;
            margin-top:-200px;
            font-size:45px;
        }
        .buts{
            padding:10px 23px 10px 23px;
            color: #4d0000; 
            text-transform:uppercase;
            font-weight:bold;
            letter-spacing:1.5px;
            font-family:'Montserrat';
            margin-top:25px;
            border-radius:25px;
            border:2px solid  #4d0000;
            cursor:pointer;
            font-family:'Montserrat';
            box-shadow:0 0 10px 10px rgba(0,0,0,0.1);
            
        }
        .buts:hover{
            background-color:#4d0000;
            color:white;
            transition:.5s;
            transform:translateY(-5px) scale(1.1);
            box-shadow:0 0 40px 40px rgba(0,0,0,0.1);
        }
        .links{
            margin-top:120px;
        }
        .logo{
    font-size: 15.74px;
    font-family: "Krona One", sans-serif;
    font-weight: 700;
    color: white;
    border-bottom: none;
    cursor: pointer;
    background-color: #4d0000;
 }
 .madnes{
    color: #af0303;
    font-family: "Krona One", sans-serif;
    left: 4px;
    color: 15.74px;
    font-weight: 700;
 }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="logo">
        <a href="#home" class="logo">SIOMAI <span class="madnes">MADNESS</span></a>
    </div>
    <div class="links">
        <a href="#" onclick="showSection('admin')">Admin</a>
        <a href="#" onclick="showSection('cashier')">Cashier</a>
    </div>
</div>


<!-- Main content -->
<div class="content_section" id="admin" >
    <!-- Home content goes here -->
    <h2>Welcome to Admin Panel</h2>

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

        

        echo "</div>";
    }
} else {
    echo "No transactions found.";
}

// Close the connection
$conn->close();
?>

</div>
<div class="content_section" id="cashier" style="display:none;">
    <!-- Orders content goes here -->
    <h2>Costumer Orders</h2>
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
       // Add a cancel button to each transaction container
        echo "<button class='buts' style='margin-left:20px;' onclick='cancelTransaction(\"" . $transactionTime . "\")'>Cancel</button>";

        echo "</div>";
    }
} else {
    echo "No transactions found.";
}

// Close the connection
$conn->close();
?>

</div>

<script>
 function showSection(sectionId) {
        // Hide home_section if it's currently displayed
        const homeSection = document.getElementById('admin');
        if (homeSection.style.display !== 'none') {
            homeSection.style.display = 'none';
        }
        else{
            (homeSection.style.display =='none')
        }
        
        // Get all content sections
        const sections = document.querySelectorAll('.content-section');
        // Hide all sections
        sections.forEach(section => {
            section.style.display = 'none';
        });
        // Show the selected section
        document.getElementById(sectionId).style.display = 'block';

        // Add active class to the clicked navigation item
        const navigationItems = document.querySelectorAll('.sidebar a');
        navigationItems.forEach(item => {
            if (item.getAttribute('onclick') === `showSection('${sectionId}')`) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }






  function cancelTransaction(transactionTime) {
        // Send an AJAX request to delete the group
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_group.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Display SweetAlert confirmation
                    Swal.fire({
                        icon: 'success',
                        title: 'Order Canceled',
                        text: 'The order has been successfully canceled.',
                        showConfirmButton: true,
                        timer: 1500
                    }).then(function () {
                        // Reload the page to reflect changes
                        location.reload();
                    });
                } else {
                    // Display error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Unable to cancel the order.'
                    });
                }
            }
        };
        xhr.send("transactionTime=" + encodeURIComponent(transactionTime));
    }
    // Function to print the transaction
    function printTransaction(transactionTime, items, total) {
        // Check if items and total are defined
        if (typeof items === 'undefined' || typeof total === 'undefined') {
            // Show a message indicating that transaction details are not available
            Swal.fire({
                title: 'Print Transaction?',
                text: 'Transaction details are not available.',
                icon: 'error',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        } else {
            // Construct receipt details
            const receiptDetails = `
                <strong>Transaction Time:</strong> ${transactionTime}<br>
                <strong>Items:</strong> ${items}<br>
                <strong>Grand Total:</strong> ₱ ${total}
            `;
            
            // Show confirmation dialog with receipt details
            Swal.fire({
                title: 'Transaction Details',
                html: receiptDetails,
                icon: 'info',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Print the transaction
                    // Remove the transaction container after printing
                    var transactionContainer = document.querySelector('.transaction-container');
                    transactionContainer.parentNode.removeChild(transactionContainer);

                    // After printing, delete the transaction from the database
                    deleteTransaction(transactionTime);
                }
            });
        }
    }

    function deleteTransaction(transactionTime) {
        // Send an AJAX request to delete the transaction
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Display an alert indicating successful deletion
                Swal.fire({
                    title: 'Order Printed ',
                    text: ' ',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Reload the page after deletion
                        location.reload();
                    }
                });
            }
        };
        xhttp.open('POST', 'delete_admin.php', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send('transaction_time=' + transactionTime);
    }

    // Function to toggle active class on sidebar links and display corresponding main section
    function toggleActive(elem) {
        var sidebarLinks = document.querySelectorAll('.sidebar a');
        for (var i = 0; i < sidebarLinks.length; i++) {
            sidebarLinks[i].classList.remove('active');
        }
        elem.classList.add('active');
        var targetId = elem.getAttribute('href').substring(1);
        var mainSections = document.querySelectorAll('.main');
        for (var i = 0; i < mainSections.length; i++) {
            if (mainSections[i].id === targetId) {
                mainSections[i].classList.add('active'); // Add active class to the target main section
            } else {
                mainSections[i].classList.remove('active'); // Remove active class from other main sections
            }
        }
    }
</script>

</body>
</html>
