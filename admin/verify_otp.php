<?php
session_start();
$_SESSION['form_data'] = $_POST;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>verify OTP</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">
        .login-form {
            width: 340px;
            margin: 50px auto;
        }

        .login-form form {
            margin-bottom: 15px;
            background: #f7f7f7;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 30px;
        }

        .login-form h2 {
            margin: 0 0 15px;
        }

        .form-control,
        .btn {
            min-height: 38px;
            border-radius: 2px;
        }

        .btn {
            font-size: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="login-form">
        <h2>Enter OTP </h2>
        <form method="post">
            <h5 class="text-center">Check your email for the OTP</h5>
            <div class="form-group second_box">
                <input type="text" id="otp" class="form-control" placeholder="OTP" required="required">
                <span id="otp_error" class="field_error"></span>
            </div>
            <div class="form-group second_box">
                <button type="button" class="btn btn-primary " onclick="submit_otp()">Submit OTP</button>
            </div>
        </form>
    </div>
    <script>

        function submit_otp() {
            var otp = jQuery('#otp').val();
            var formData = <?php echo json_encode($_SESSION['form_data']); ?>;;

            var dataToSend = $.extend({}, formData, { otp: otp });

            jQuery.ajax({
                url: 'register_admin_process.php',
                type: 'post',
                data: dataToSend,
                success: function (response) {
                    var parsedResponse = JSON.parse(response);
                    if (parsedResponse.error) {
                        // If there's an error, display it
                        alert(parsedResponse.error)
                    } else if (parsedResponse.success) {
                        window.location.href = 'login_admin.php';
                        // Redirect to login page or any page
                    }
                },
                error: function (xhr, status, error) {
                    // Handle low-level AJAX errors (e.g., connection issues)
                    console.error('AJAX Error:', status, error);
                }
            });
        }

    </script>
    <style>
        .field_error {
            color: red;
        }
    </style>
</body>

</html>