<?php
session_start();
$phone = $_SESSION['phone'];

// Start the session to access session variables
echo "Client_Id:", " ", $phone;


if (isset($_POST['quantity']) && isset($_POST['product_id'])) {
    $quantity = $_POST['quantity'];
}
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
} else if (isset($_GET['remove_product_id'])) {
    // Remove product from cart
    $remove_product_id = $_GET['remove_product_id'];

    // Connect to the database (update connection details as needed)
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "ecommerce";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete the product from the cart
    $delete_sql = "DELETE FROM cart WHERE id = $remove_product_id AND phone_number = '$phone'";
    if ($conn->query($delete_sql) === TRUE) {
      
    } else {
        echo "Error removing product from cart: " . $conn->error;
    }

    $conn->close();
} else {
}












?>
<!DOCTYPE html>
<html lang="en">

<head>
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

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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

                        // Add remove item button with product_id as parameter
                        echo "<a href='add_to_cart.php?remove_product_id=" . $row['id'] . "' class='btn btn-danger'>Remove</a>";

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

      
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Checkout
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment Mode</h5>

          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <img src="g (1).png" alt="" width="100%" height="100%">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="check()" >Paid</button>
      </div>
    </div>
  </div>
</div>

    </div>
    <!-- Add your modal and script tags here -->
<script>

function check()
{
    alert('Confirm Order Status With Cashier ✅')
}
</script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>
