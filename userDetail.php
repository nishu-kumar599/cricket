<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Detail</title>
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

        .container {
            background-color: #fff;
            padding: 20px;
            width: 50%;
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
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        select {
            width: 100%;
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
    </style>
</head>

<body>
    <div class="container w-75 mt-5">
        <h3>Billing Address</h3>
        <form action="paymentgateway.php" method="POST">
            <div class="form-group">
                <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                <input type="text" id="fname" class="form-control" name="firstname" pattern="^[a-zA-Z ]+$">
            </div>
            <div class="form-group">
                <label for="city"><i class="fa fa-institution"></i> City</label>
                <input type="text" id="city" name="city" class="form-control" pattern="^[a-zA-Z ]+$" required>
            </div>
            <div class="form-group">
                <label for="LandMark"><i class="fa fa-institution"></i> LandMark</label>
                <input type="text" id="LandMark" name="LandMark" class="form-control" pattern="^[a-zA-Z ]+$" required>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <label for="state">State</label>
                    <input type="text" id="state" name="state" class="form-control" pattern="^[a-zA-Z ]+$" required>
                </div>
                <div class="col-sm-6 form-group">
                    <label for="zip">Zip</label>
                    <input type="text" id="zip" name="zip" class="form-control" pattern="^[0-9]{6}(?:-[0-9]{4})?$"
                        required>
                </div>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="contact_number">Contact Number</label>
                <input type="text" id="contact_number" name="contact_number" class="form-control">
            </div>
            <!-- Hidden Inputs -->
            <input type="hidden" id="qty" name="qty" value="<?php echo $_SESSION['qty']; ?>">
            <input type="hidden" id="total_price" name="total_price" value="<?php echo $_SESSION['total_price']; ?>">
            <input type="hidden" id="product_id" name="product_id" value="<?php echo $_SESSION['product_id']; ?>">
            <input type="hidden" id="ip_add" name="ip_add" value="<?php echo $_SESSION['ip_add']; ?>">
            <button type="submit" class="btn btn-primary">Continue</button>
        </form>
    </div>

</body>

</html>