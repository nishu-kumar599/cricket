<?php
session_start();
include 'db_connection.php';
// Check if tax invoice data is set in session
if (!isset($_SESSION['tax_invoice'])) {
    echo "Invoice data not found.";
    exit;
}

// Assuming your session contains product_id, use it to fetch the order and product details
$product_id = $_SESSION['tax_invoice']['productId'];

$sql = 'SELECT orders.*, products.product_title 
        FROM orders 
        JOIN products ON orders.product_id = products.product_id 
        WHERE orders.product_id = ?';

// Prepare the SQL statement
if ($stmt = $conn->prepare($sql)) {
    // Bind parameters
    $stmt->bind_param("i", $product_id); // 'i' denotes the type 'integer'
    // Execute the query
    $stmt->execute();
    // Get the result set from the executed statement
    $results = $stmt->get_result();
    // Fetch the row
    $row = $results->fetch_assoc();

    if (!$row) {
        echo "Order not found.";
        exit;
    }

    // Now you can access $row['product_title'] and other order details directly
} else {
    echo "SQL error: " . $conn->error;
    exit;
}
$invoiceData = $_SESSION['tax_invoice'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Invoice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .invoice-container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
        }

        .invoice-info {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 4px solid #007bff;
        }

        .invoice-info p {
            margin: 0;
            line-height: 1.5;
            color: #333;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer a {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <h1>Tax Invoice</h1>
        <div class="invoice-info">
            <p>Email:
                <?= htmlspecialchars($invoiceData['email']) ?>
            </p>
            <p>Address:
                <?= htmlspecialchars($invoiceData['address']) ?>
            </p>
            <p>Contact Number:
                <?= htmlspecialchars($invoiceData['contactNumber']) ?>
            </p>
            <p>Product ID:
                <?= htmlspecialchars($invoiceData['productId']) ?>
            </p>
            <p>Product Title:
                <?= htmlspecialchars($row['product_title']) ?>
            </p>
            <p>Quantity:
                <?= htmlspecialchars($invoiceData['qty']) ?>
            </p>
            <p>Total Price:
                <?= htmlspecialchars($invoiceData['totalPrice']) ?>
            </p>
            <p>Transaction ID:
                <?= htmlspecialchars($invoiceData['transactionId']) ?>
            </p>
            <!-- Add more fields as needed -->
        </div>
        <div class="footer">
            <a href="store.php">Go Back to Store</a>
        </div>
    </div>
</body>

</html>