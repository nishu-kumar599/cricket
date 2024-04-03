<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connection.php';

// Function to generate tax invoice
if (isset($_POST['code']) && $_POST['code'] === 'PAYMENT_SUCCESS') {
    if (isset($_COOKIE['FormData'])) {
        $formData = json_decode($_COOKIE['FormData'], true);
        // Access data
        $email = $formData['email'];
        $address = $formData['address'];
        $contactNumber = $formData['contact_number'];
        $productId = $formData['product_id'];
        $qty = $formData['qty'];
        $totalPrice = $formData['total_price'];
        $pStatus = $_POST['code'];
        $fname = $formData['firstname'];
        $city = $formData['city'];
        $LandMark = $formData['LandMark'];
        $state = $formData['state'];
        $zip = $formData['zip'];
        $transactionId = $_POST['transactionId'];


        $sql = "INSERT INTO orders (email, address, phoneNumber, product_id, qty, amount, trx_id, p_status,fname,city,LandMark,state,zip) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiiissssssi", $email, $address, $contactNumber, $productId, $qty, $totalPrice, $transactionId, $pStatus, $fname, $city, $LandMark, $state, $zip);


        if ($stmt->execute()) {
            $_SESSION['tax_invoice'] = [
                'email' => $email,
                'address' => $address,
                'contactNumber' => $contactNumber,
                'productId' => $productId,
                'qty' => $qty,
                'totalPrice' => $totalPrice,
                'transactionId' => $transactionId,
                'fname' => $fname,
                'city' => $city,
                'LandMark' => $LandMark,
                'state' => $state,
                'zip' => $zip,
            ];
            setcookie('FormData', '', time() - 3600, '/');
            setcookie('productid', '', time() - 3600, '/');
            header("Location: taxInvoice.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Form data not found.";
    }
} else {
    echo "Payment was not successful.";
}
$conn->close();
?>