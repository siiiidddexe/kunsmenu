
<?php
session_start(); 
$phone= $_SESSION['phone'];
// Start the session to access session variables
echo "Client_Id:"," ",$phone;

// Check if product_id and phone are provided
if (isset($_GET['product_id']) && isset($_GET['phone'])) {
    // Connect to the database (update connection details as needed)
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "ecommerce";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $product_id = $_GET['product_id'];
    $phone_number = $_GET['phone'];

    // Check if the product is already in the cart for the user
    $check_sql = "SELECT * FROM cart WHERE product_id = $product_id AND phone_number = '$phone_number'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "Product already in cart.";
    } else {
        // Add the product to the cart
        $insert_sql = "INSERT INTO cart (product_id, phone_number, quantity) VALUES ($product_id, '$phone_number', 1)";
        if ($conn->query($insert_sql) === TRUE) {
            echo "Product added to cart successfully.";
        } else {
            echo "Error adding product to cart: " . $conn->error;
        }
    }

    $conn->close();
} else {
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add to Cart </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .cart-item img {
            max-width: 80px;
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
            font-size: 18px;
            margin-bottom: 20px;
        }

        .back-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }











    </style>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Add to Cart Response</h1>
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
                 WHERE cart.phone_number = '$phone_number'";
    $cart_result = $conn->query($cart_sql);

    if ($cart_result->num_rows > 0) {
        while ($row = $cart_result->fetch_assoc()) {
            echo "<div class='cart-item'>";
            echo "<img src='" . $row['product_image'] . "' alt='Product Image'>";
            echo "<div class='product-details'>";
            echo "<h3>" . $row['product_name'] . "</h3>";
            echo "<p>Price: ₹" . $row['price'] . "</p>";
            echo "<p>Quantity: " . $row['quantity'] . "</p>"; // Display quantity
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<div class='empty-cart'>Your cart is empty.</div>";
    }

    $conn->close();
} else {
    echo "<div class='not-logged-in'>Please log in to view your cart.</div>";
}
?>

    </div>
    <a href="products.php" style="text-decoration: none;" class="back-btn">Back to Products</a>
  
  
    <button type="button" style="font-size:19px; padding-bottom: 6px; margin-top: -6px;  " class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Checkout
</button>

</div>
</div>

</div>

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered"   >
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Payment Method</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="align-items: center; ">
      <img src="g (1).png" style="height:100% ; width: 100%; " alt="Pay At Cashier">

      </div>
      <div class="modal-footer">
       
        <button type="button" class="btn btn-primary" id="paidBtn" data-bs-dismiss="modal">Paid</button>
      </div>
    </div>
  </div>
</div>
<script>
    function updateQuantity(productId, quantity) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                alert("Quantity updated successfully");
            }
        };
        xhr.open("GET", "update_quantity.php?product_id=" + productId + "&quantity=" + quantity, true);
        xhr.send();
    }


// Get the button element by its ID
var paidBtn = document.getElementById('paidBtn');

// Add a click event listener to the button
paidBtn.addEventListener('click', function() {
    // Display the alert
    alert('Order Will Be Placed after Payment✅');
});

</script>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    
</body>
</html>

