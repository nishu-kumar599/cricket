<?php
session_start();
ob_clean();
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
//Load Composer's autoloader
require '../vendor/autoload.php';


$otp = rand(10000, 999999);
$email = $_POST['email'];
$html = "Your otp verification code is " . $otp;
$_SESSION['EMAIL'] = $email;
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;   
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                   //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
    $mail->Username = 'lapvipul123@gmail.com';                     //SMTP username
    $mail->Password = 'szryfokuptzvqhgs';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('from@example.com', 'Banda Cricket Association');
    $mail->addAddress($email, 'Joe User');     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'opt verification ';
    $mail->Body = $html;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();
    echo json_encode(["success" => "Message has been sent"]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Message could not be sent. Mailer Error: ' . "'{ $mail->ErrorInfo}'"]);
}
$_SESSION['otp'] = $otp;


?>