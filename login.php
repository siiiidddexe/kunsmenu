<?php
session_start(); // Start the session to track logged-in users

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if name and phone number are provided
    if (!empty($_POST['name']) && !empty($_POST['phone'])) {
        // Store the name and phone number in session variables
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['phone'] = $_POST['phone'];
        // Redirect the user to the products page
        header('Location: products.php');
        exit;
    } else {
        $error = "Please enter your name and phone number.";
    }
}

// Check if the form is submitted
if (isset($_POST['phone'])) {
    $phone = $_POST['phone'];

    // Example validation (you should add proper validation and authentication logic)
    if ($phone === "1234567890") {  // Replace with your actual authentication logic
        $_SESSION['phone'] = $phone;  // Set phone number in session
        header('Location: products.php');  // Redirect to products page or any authorized page
        exit;
    } else {
        $error = "Invalid phone number";  // Handle invalid login
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Kun Roll</title>
    <link rel="icon" href="kunrolltext.png" type="image/x-icon">

    <style>


    body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-container {
            max-width: 360px;
            width: 100%;
            padding: 40px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            text-align: center;
            animation: fadeInDown 0.6s ease;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
            align-items: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #555;
            font-weight: bold;
        }

        input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: #ff6347;
            margin-top: 10px;
        }

        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        
      
    </style>

</head>
<body>
    
    <form method="POST">
    <div><img src="web-logo-02.png" alt="" width="300" height="100"></div>
   
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required
                pattern="\d{10}" minlength="10" maxlength="10"
                title="Please enter exactly 10 digits">
        <input type="submit" value="Login">
    </form>
    <?php
    if (isset($error)) {
        echo "<p>$error</p>";
    }
    ?>
</body>
</html>
