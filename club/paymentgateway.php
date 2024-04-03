<?php
// Replace these with your actual PhonePe API credentials
session_start();
$_SESSION['FormData'] = $_POST;
$formData = $_POST;

$cookie_name = "FormData";
$cookie_value = json_encode($formData);
setcookie($cookie_name, $cookie_value, time() + 86400, "/");
$merchantId = 'PGTESTPAYUAT'; // sandbox or test merchantId
$apiKey = "099eb0cd-02cf-4e2a-8aca-3e6c6aff0399"; // sandbox or test APIKEY
$base_url = $_SERVER['HTTP_HOST'] . '/';
$redirectUrl = 'https://badacricket.000webhostapp.com/club/register_club_process.php';

// Set transaction details
$order_id = uniqid();
$name = "Tutorials Website";
$email = "info@tutorialswebsite.com";
$mobile = 9999999999;
$amount = 10; // amount in INR
$description = 'Payment for Product/Service';


$paymentData = array(
  'merchantId' => $merchantId,
  'merchantTransactionId' => "MT7850590068188104", // test transactionID
  "merchantUserId" => "MUID123",
  'amount' => $amount * 100,
  'redirectUrl' => $redirectUrl,
  'redirectMode' => "POST",
  'callbackUrl' => $redirectUrl,
  "merchantOrderId" => $order_id,
  "mobileNumber" => $mobile,
  "message" => $description,
  "email" => $email,
  "shortName" => $name,
  "paymentInstrument" => array(
    "type" => "PAY_PAGE",
  )
);


$jsonencode = json_encode($paymentData);
$payloadMain = base64_encode($jsonencode);
$salt_index = 1; //key index 1
$payload = $payloadMain . "/pg/v1/pay" . $apiKey;
$sha256 = hash("sha256", $payload);
$final_x_header = $sha256 . '###' . $salt_index;
$request = json_encode(array('request' => $payloadMain));

$curl = curl_init();
curl_setopt_array($curl, [
  CURLOPT_URL => "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $request,
  CURLOPT_HTTPHEADER => [
    "Content-Type: application/json",
    "X-VERIFY: " . $final_x_header,
    "accept: application/json"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

// Here's a simplified response handling example:
if (!$err && $res = json_decode($response)) {
  if (isset ($res->success) && $res->success == '1') {
    // Success: PhonePe provided a payment URL
    $_SESSION['FormData'] = $_POST; // Store form data in session
    echo json_encode(['success' => '1', 'payUrl' => $res->data->instrumentResponse->redirectInfo->url]);
  } else {
    // Failure: PhonePe did not initiate payment
    echo json_encode(['success' => '0', 'message' => 'Failed to initiate payment']);
  }
} else {
  // cURL error
  echo json_encode(['success' => '0', 'message' => 'cURL Error: ' . $err]);
}
?>