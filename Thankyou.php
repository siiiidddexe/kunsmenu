<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['phone'])) {
    // Redirect to the login page or any other page as needed
    header("Location: login.php"); // Replace "login.php" with your login page URL
    exit(); // Ensure that no further code is executed after redirection
}

$cart_total = isset($_SESSION['cart_total']) ? $_SESSION['cart_total'] : 125;

session_destroy();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanks For Ordering | Kun Rolls</title>
    <link rel="icon" href="kunrolltext.png" type="image/x-icon">
   
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #000;
            color: #fff;
            text-align: center;
        }
        .error-container {
            max-width: 600px;
        }
        .error-code {
            font-size: 30px;
            font-weight: bold;
        }
        .error-message {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            font-weight: bold;
        }
        .back-button {
            background-color: #007bff;
            color: #fff;
            padding: 0.5rem 1rem;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
        }
        .back-button:hover {
            background-color: #003166;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div><img src="web-logo-02.png" alt="" width="300" height="100"></div>
        <div class="error-code">Thanks For Ordering | Kun Rolls</div>
       
        <div class="error-message" >Complete Payment at Cashier ✅  <h1>₹<?php echo "$cart_total"?></h1>  </div>
    </br>
        <a href="index.php" style="text-decoration:solid" class="back-button">Place New Order</a>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
