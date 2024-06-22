<?php include 'auth.php'; ?>

<?php
// Check if the user is logged in
if (!isset($_SESSION['phone'])) {
    // Redirect to the login page or any other page as needed
    header("Location: login.php"); // Replace "login.php" with your login page URL
    exit(); // Ensure that no further code is executed after redirection
}

$cart_total = isset($_SESSION['cart_total']) ? $_SESSION['cart_total'] : 125;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            color: white;
            border-radius: 30px;
            transition: background-color 0.3s, transform 0.3s;
        }
        .button i {
            margin-right: 10px;
        }
        .button.instagram {
            background: radial-gradient(circle farthest-corner at 35% 90%, #fec564, transparent 50%), radial-gradient(circle farthest-corner at 0 140%, #fec564, transparent 50%), radial-gradient(ellipse farthest-corner at 0 -25%, #5258cf, transparent 50%), radial-gradient(ellipse farthest-corner at 20% -50%, #5258cf, transparent 50%), radial-gradient(ellipse farthest-corner at 100% 0, #893dc2, transparent 50%), radial-gradient(ellipse farthest-corner at 60% -20%, #893dc2, transparent 50%), radial-gradient(ellipse farthest-corner at 100% 100%, #d9317a, transparent), linear-gradient(#6559ca, #bc318f 30%, #e33f5f 50%, #f77638 70%, #fec66d 100%);
        }
        .button.instagram:hover {
            background-color: #ffff;
            text-decoration: none;
            transform: scale(1.05);
            color: white;
        }
        .button.website {
            background-color: #007BFF;
        }
        .button.website:hover {
            background-color: #0056b3;
            text-decoration: none;
            transform: scale(1.05);
            color: white;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div><img src="web-logo-02.png" alt="" width="300" height="100"></div>
        <div class="error-code">Thanks For Ordering | Kun Rolls</div>
       
        <div class="error-message">Complete Payment at Cashier ✅  <h1>₹<?php echo "$cart_total"?></h1></div>
        <br>
        <a href="index.php" style="text-decoration:solid" class="back-button">Place New Order</a>
        <div class="button-container" style="padding-top:10%" >
            <a href="https://www.instagram.com" class="button instagram" target="_blank">
                <i class="fab fa-instagram"></i> Follow us on Instagram
            </a>
            <a href="https://www.example.com" class="button website" target="_blank">
                <i class="fas fa-globe"></i> Visit Our Website
            </a>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
