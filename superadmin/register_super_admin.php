<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Super Admin</title>
    <style>
        /* Basic styling for better UI */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        body {
            background-image: url('../images/banner3.png');
            background-size: cover;
        }

        .container {
            width: 500px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: -webkit-fill-available;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* The message box is shown when the user clicks on the password field */
        #message {
            display: none;
            background: #f1f1f1;
            color: #000;
            position: relative;
            padding: 20px;
            margin-top: 10px;
        }

        #message p {
            padding: 10px 35px;
            font-size: 18px;
        }

        /* Add a green text color and a checkmark when the requirements are right */
        .valid {
            color: green;
        }

        .valid:before {
            position: relative;
            left: -35px;
            content: "✔";
        }

        /* Add a red text color and an "x" when the requirements are wrong */
        .invalid {
            color: red;
        }

        .invalid:before {
            position: relative;
            left: -35px;
            content: "✖";
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Register Super Admin</h2>
        <form action="verify_otp.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <span id="userError" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <span id="emailError" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" class="form-control" name="password"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{12,}"
                    title="Must contain at least one number and one uppercase and lowercase letter, and at least 12 or more characters"
                    required>
                <div id="message">
                    <h3>Password must contain the following:</h3>
                    <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                    <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                    <p id="number" class="invalid">A <b>number</b></p>
                    <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                </div>
            </div>
            <button id="registerBtn" type="submit" onclick="send_otp()">Register</button>
        </form>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    document.getElementById("email").addEventListener("blur", function () {
        const emailInput = this.value;
        const emailError = document.getElementById("emailError");
        const registerBtn = document.getElementById("registerBtn");

        // Send AJAX request to check if email exists
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "check_email_ajax.php");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.exists) {
                    emailError.textContent = "Email already exists. Please use a different email.";
                    registerBtn.disabled = true; // Disable register button
                } else {
                    emailError.textContent = ""; // Clear error message
                    registerBtn.disabled = false; // Enable register button
                }
            }
        };
        xhr.send("email=" + encodeURIComponent(emailInput));
    });

    document.getElementById("username").addEventListener("blur", function () {
        const userInput = this.value;
        const userError = document.getElementById("userError");
        const registerBtn = document.getElementById("registerBtn");

        // Send AJAX request to check if email exists
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "check_email_ajax.php");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.exists) {
                    userError.textContent = "username already exists. Please use a different username.";
                    registerBtn.disabled = true; // Disable register button
                } else {
                    userError.textContent = ""; // Clear error message
                    registerBtn.disabled = false; // Enable register button
                }
            }
        };
        xhr.send("username=" + encodeURIComponent(userInput));
    });
</script>
<script>
    function send_otp() {
        var email = jQuery('#email').val();
        var password = jQuery('#password').val();
        var username = jQuery('#username').val();
        if (email !== '' && password !== '' && username !== '') {
            $.ajax({
                url: '../otp/send_otp.php',
                type: 'POST',
                data: { email: email },
                success: function (response) {
                    var parsedResponse = JSON.parse(response);
                    if (parsedResponse.error) {
                        alert(parsedResponse.error);
                    } else if (parsedResponse.success) {
                        alert(parsedResponse.success);
                    }
                },
                error: function (xhr, status, error) {
                    // Handle low-level AJAX errors (e.g., connection issues)
                    console.error('AJAX Error:', status, error);
                }
            });
        }
        else {
            alert("please fill the required filed")
        }
    }


    document.addEventListener("DOMContentLoaded", function () {
        var myInput = document.getElementById("password");
        var letter = document.getElementById("letter");
        var capital = document.getElementById("capital");
        var number = document.getElementById("number");
        var length = document.getElementById("length");

        // When the user clicks on the password field, show the message box
        myInput.onfocus = function () {
            document.getElementById("message").style.display = "block";
        }

        // When the user clicks outside of the password field, hide the message box
        myInput.onblur = function () {
            document.getElementById("message").style.display = "none";
        }

        // When the user starts to type something inside the password field
        myInput.onkeyup = function () {
            // Validate lowercase letters
            var lowerCaseLetters = /[a-z]/g;
            if (myInput.value.match(lowerCaseLetters)) {
                letter.classList.remove("invalid");
                letter.classList.add("valid");
            } else {
                letter.classList.remove("valid");
                letter.classList.add("invalid");
            }

            // Validate capital letters
            var upperCaseLetters = /[A-Z]/g;
            if (myInput.value.match(upperCaseLetters)) {
                capital.classList.remove("invalid");
                capital.classList.add("valid");
            } else {
                capital.classList.remove("valid");
                capital.classList.add("invalid");
            }

            // Validate numbers
            var numbers = /[0-9]/g;
            if (myInput.value.match(numbers)) {
                number.classList.remove("invalid");
                number.classList.add("valid");
            } else {
                number.classList.remove("valid");
                number.classList.add("invalid");
            }

            // Validate length
            if (myInput.value.length >= 12) {
                length.classList.remove("invalid");
                length.classList.add("valid");
            } else {
                length.classList.remove("valid");
                length.classList.add("invalid");
            }
        }
    });

</script>

</html>