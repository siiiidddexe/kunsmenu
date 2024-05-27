<?php include 'auth.php'; ?>

<?php


// Check if the user is logged in
if (!isset($_SESSION['phone'])) {
    echo "Please log in to add items to the cart.";
    exit;
}

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$phone = $_SESSION['phone'];
$client_name = $_SESSION['name'];
$quantity = "";

// Handle adding items to the cart or updating quantities
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['productId'], $_POST['quantity'], $_POST['phone'], $_POST['name'])) {
        $product_id = $_POST['productId'];
        $quantity = intval($_POST['quantity']);
        $phone_number = $_POST['phone'];
        $client_name = $_POST['name'];

        // Check if the product is already in the cart for the user
        $check_sql = "SELECT * FROM cart WHERE product_id = $product_id AND phone_number = '$phone_number' AND payment = 'pending' ";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            // Update the quantity if the product is already in the cart
            $update_sql = "UPDATE cart SET quantity = quantity + $quantity, name = '$client_name' WHERE product_id = $product_id AND phone_number = '$phone_number'";
            if ($conn->query($update_sql) === TRUE) {
              
            } else {
                echo "Error updating cart: " . $conn->error;
            }
        } else {
            // Add the product to the cart
            $insert_sql = "INSERT INTO cart (product_id, phone_number, name, quantity, payment, order_status , delivery_status) VALUES ($product_id, '$phone_number', '$client_name', $quantity, 'pending', 'pending', 'pending')";
            if ($conn->query($insert_sql) === TRUE) {
                
            } else {
                echo "Error adding product to cart: " . $conn->error;
            }
        }
    } else if (isset($_POST['checkout'])) {
        // Handle the checkout process
        $update_sql = "UPDATE cart SET payment = 'checkout' WHERE phone_number = '$phone'";
        if ($conn->query($update_sql) === TRUE) {
           
            echo "Order Placed ✅";
       
            exit();
        } else {
            echo "Error updating payment status: " . $conn->error;
        }
        exit();

      
    }


    
}

//echo "Client_Id: " . $phone;
//echo " Client_Name: " . $client_name;

// Handle removing items from the cart
if (isset($_GET['remove_product_id'])) {
    $remove_product_id = $_GET['remove_product_id'];

    // Delete the product from the cart
    $delete_sql = "DELETE FROM cart WHERE id = $remove_product_id AND phone_number = '$phone'";
    if ($conn->query($delete_sql) === TRUE) {
        echo "";
    } else {
        echo "Error removing product from cart: " . $conn->error;
    }
}

// Calculate and display Cart Total
$cart_sql = "SELECT products.price, cart.quantity FROM cart INNER JOIN products ON cart.product_id = products.id WHERE cart.phone_number = '$phone'  AND cart.payment = 'pending'";
$cart_result = $conn->query($cart_sql);

$cart_total = 0;
$_SESSION['cart_total'] = $cart_total;
if ($cart_result->num_rows > 0) {
    while ($row = $cart_result->fetch_assoc()) {
        $cart_total += ($row['price'] * $row['quantity']); // Calculate total for each item
        $_SESSION['cart_total'] = $cart_total;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Viewport meta tag -->
<title> Cart | Kun Rolls</title>
<link rel="icon" href="kunrolltext.png" type="image/x-icon">
<style>
     body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    padding: 20px;
    font-size: 18px; /* Increased global font size */
}

.container {
    max-width: 100%;
    margin-top: 25px;
    margin-right: 25px;
    background-color: #fff;
    padding: 20px;
    border-radius: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

h1 {
    color: #333;
    margin-bottom: 20px;
    font-size: 24px; /* Increased font size */
}

.cart-item {
    display: flex;
    align-items: center;
    margin-bottom: 20px; /* Combined duplicate margin-bottom */
    border-bottom: 1px solid #ccc;
    padding-bottom: 20px; /* Combined duplicate padding-bottom */
    transition: all 0.3s ease;
    padding: 10px;
}

.cart-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    border-radius: 20px;
}

.cart-item img {
    max-width: 170px;
    height: auto;
    margin-right: 20px;
    border-radius: 5px;
}

.product-details {
    flex-grow: 1;
}

.quantity-select {
    margin-left: auto;
}

.message {
    font-size: 18px; /* Increased font size */
    margin-bottom: 20px;
}

.back-btn {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 15px 20px; /* Increased padding for better touch area */
    border-radius: 10px; /* Increased border-radius */
    cursor: pointer;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    font-size: 18px; /* Increased font size */
}

.back-btn:hover {
    background-color: #0056b3;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Added shadow on hover */
}

.cart-total {
    margin-top: 20px;
    font-size: 20px; /* Increased font size */
    font-weight: bold;
}

    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body >
<div class="container" >
        <h1 style='font-weight: bold; color: #333; '><svg xmlns="http://www.w3.org/2000/svg" style="margin-top: -10px; " width="32" height="32" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
  <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
</svg> CHECKOUT  BAG</h1>
        <div class="cart-total" style='font-weight: bold; color: #333;   font-size: 20px;  '>
            <?php
            // Your PHP code for calculating and displaying Cart Total
            echo "Cart Total: ₹" . $cart_total;
            ?>
            </br></br>
        </div>
        
        
        <div class="message">
            <?php
            // Check if the user is logged in
            if (isset($_SESSION['phone'])) {
                // Connect to the database
                $servername = "localhost";
                $username = "root";
                $password = "root";
                $dbname = "ecommerce";
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch cart items for the logged-in user
                $phone_number = $_SESSION['phone'];
                $cart_sql = "SELECT cart.id, products.product_name, products.price, products.product_image, cart.quantity 
                             FROM cart INNER JOIN products ON cart.product_id = products.id 
                             WHERE cart.phone_number = '$phone_number' 
                             AND payment='pending'";
                $cart_result = $conn->query($cart_sql);

                if ($cart_result->num_rows > 0) {
                    while ($row = $cart_result->fetch_assoc()) {
                        echo "<div class='cart-item' style='display: flex; align-items: center;'>";
                        echo "<img src='" . $row['product_image'] . "' alt='Product Image'>";
                        echo "<div class='product-details'>";
                        echo "<h3 style='font-weight: bold; color: #333; '>" . $row['product_name'] . "</h3>";
                        echo "<p style='font-weight: bold; color: #333; '>Price: ₹" . $row['price'] . "</p>";
                        echo "<p style='font-weight: bold; color: #333; '>Quantity: " . $row['quantity'] . "</p>"; // Display quantity
                        
                        // Add remove item button with product_id as parameter
                        echo "<a href='add_to_cart.php?remove_product_id=" . $row['id'] . "' class='btn btn-danger' style='margin-left: auto;'>Remove</a>";
                        
                        echo "</div>";
                        echo "</div>";
                        
                    }
                } else {
                    echo "<div class='empty-cart' style='font-weight: bold; color: #333; text-decoration:underline ; font-size: 16px;'>Your cart is empty.</div>";
                }

                $conn->close();
            } else {
                echo "<div class='not-logged-in'>Please log in to view your cart.</div>";
            }
            ?>
        </div>
        <a href="products.php" style="text-decoration: none; padding: 8px 12px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;" class="back-btn">Back to Products</a>

        <button type="button"  style="text-decoration: none; margin-top:-5px ; padding:6.5px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;" class="btn btn-primary" id="checkoutBtn" data-toggle="modal" data-target="#exampleModal">Checkout</button>

        <!-- Modal -->
  
    </div>

    <script>
       

        document.getElementById('checkoutBtn').addEventListener('click', function() {
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'checkout=true',
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Function to handle redirection after checkout button is clicked
    function redirectToThankYouPage() {
        window.location.href = "thankyou.php";
    }

    // Event listener for the checkout button
    document.getElementById("checkoutBtn").addEventListener("click", function() {
        // You can add additional logic here if needed
        // For example, validation checks before redirecting

        // Call the redirection function
        redirectToThankYouPage();
    });
});
</script>
</body>
</html>
