<?php

// Start the session 
session_start();
// Include the CSRF token management script
require ("../csrf_token.php");

// Generate unique player ID
$player_id = "BCA" . time() . mt_rand(100, 999);
$_SESSION['player_id'] = $player_id;
clearstatcache();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Player</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: url(../images/banner3.png) no-repeat;
            background-size: cover;
        }

        /* Additional custom styling */
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .text-danger {
            color: #dc3545;
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="../index.php">
            <img src="../images/new/logo.png" width="50" height="50" class="d-inline-block align-top" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="../index.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../club/register_club.php">Register as Club</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../player/register_player.php">Register as Player </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../club/login_club.php">Club Login </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../player/login_player.php">Player Login </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h2 class="text-center mb-4">Register Player</h2>
        <form id="playerForm" action="paymentgateway.php" method="POST" enctype="multipart/form-data">

            <!-- Hidden input for player_id -->
            <input type="hidden" id="player_id" name="player_id" value="<?php echo $player_id; ?>">

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <div class="input-group date">
                    <input type="text" id="dob" name="dob" class="form-control" required>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="mobile">Mobile Number:</label>
                <input type="text" id="mobile" name="mobile" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
                <span id="emailError" class="error" style="color: red;"></span>
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
                    <p id="length" class="invalid">Minimum <b>12 characters</b></p>
                </div>
            </div>
            <div class="form-group">
                <label for="type">Type of Player:</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="bowler">Bowler</option>
                    <option value="batsman">Batsman</option>
                    <option value="wicketkeeper_batsman">Wicketkeeper/Batsman</option>
                    <option value="allrounder">Allrounder</option>
                </select>
            </div>
            <div class="form-group">
                <label for="club">Club:</label>
                <select id="club" name="club" class="form-control">
                    <option value="0">Independent</option>
                    <?php
                    // Include the database connection file
                    include '../db_connection.php';

                    // Fetch clubs from the database
                    $sql = "SELECT * FROM clubs";
                    $result = $conn->query($sql);

                    // Check if clubs are found
                    if ($result->num_rows > 0) {
                        // Loop through each club and generate option elements
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No clubs found</option>";
                    }

                    // Close the database connection
                    $conn->close();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="state">State:</label>
                <select id="state" name="state" class="form-control" required>
                    <!-- Options will be dynamically populated using JavaScript -->
                </select>
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <select id="city" name="city" class="form-control" required>
                    <!-- Options will be dynamically populated using JavaScript -->
                </select>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address" class="form-control" required></textarea>
            </div>
            <input class="form-group" type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($token); ?>">
            <button type="submit" id="registerBtn" class="btn btn-primary btn-block" disabled>Register</button>
        </form>
    </div>

    <script src="statedataset.js"></script>
    <script>
        // Define states and cities data (you can replace it with dynamic data from a database)

        // Function to populate states dropdown
        function populateStatesDropdown() {
            const statesDropdown = document.getElementById("state");
            statesDropdown.innerHTML = "<option value=''>Select State</option>";
            statesData.forEach(state => {
                const option = document.createElement("option");
                option.text = state.name;
                option.value = state.name;
                statesDropdown.add(option);
            });
        }

        // Function to populate cities dropdown based on selected state
        function populateCitiesDropdown(selectedState) {
            const citiesDropdown = document.getElementById("city");
            citiesDropdown.innerHTML = "<option value=''>Select City</option>";
            const selectedStateData = statesData.find(state => state.name === selectedState);
            if (selectedStateData) {
                selectedStateData.cities.forEach(city => {
                    const option = document.createElement("option");
                    option.text = city;
                    option.value = city;
                    citiesDropdown.add(option);
                });
            }
        }

        // Populate states dropdown on page load
        populateStatesDropdown();

        // Event listener for state dropdown change
        document.getElementById("state").addEventListener("change", function () {
            const selectedState = this.value;
            populateCitiesDropdown(selectedState);
        });

            // Form validation for file inputs

    </script>

    <script>
        document.getElementById("email").addEventListener("input", function () {
            const emailInput = this.value;
            const registerBtn = document.getElementById("registerBtn");

            // Reset error message
            document.getElementById("emailError").textContent = "";

            // Disable register button by default
            registerBtn.disabled = true;

            // Send AJAX request to check if email exists
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "check_email_ajax.php");
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.exists) {
                        document.getElementById("emailError").textContent = "Email already exists. Please use a different email.";
                    } else {
                        // Enable register button if email does not exist
                        registerBtn.disabled = false;
                    }
                }
            };
            xhr.send("email=" + encodeURIComponent(emailInput));
        });
    </script>
    <!-- Bootstrap Datepicker CSS -->


    <!-- Bootstrap Datepicker JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>



    <script>
        $(document).ready(function () {
            $('#dob').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });

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

</body>

</html>