<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "ecommerce";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if phone number is not set in session, redirect to login
if (!isset($_SESSION['phone'])) {
    header('Location: login.php');
    exit;
}

$quantity = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['quantity'])) {
    $quantity = $_POST["quantity"];
}

if (isset($_POST['signout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}


//echo "Client_id: " . $_SESSION['phone'];
//echo "Client_Name: " . $_SESSION['name'];
// Fetch only available products from the database
$sql = "SELECT * FROM products WHERE availability = 'available'";
$result = $conn->query($sql);

if ($result === false) {
    die("Error fetching products: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title> Browse Products | Kun Rolls</title>
    <link rel="icon" href="kunrolltext.png" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin-left: 100px;
            margin-right: 100px;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            overflow: hidden;
        }
        .signout-btn {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 3px 4px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            float: right;
        }
        .signout-btn:hover {
            background-color: #c82333;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .product {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 20px;
            transition: all 0.3s ease;
        }
        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
        }
        .product img {
            max-width: 100px;
            height: auto;
            margin-right: 20px;
            border-radius: 5px;
        }
        .product-info {
            flex-grow: 1;
            padding: 20px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .empty-message {
            text-align: center;
            color: #888;
        }

        /* Styling for the quantity label */
        .quantity-label {
            display: inline-block;
            margin-right: 10px;
            font-weight: bold;
        }

        /* Styling for the quantity input */
        .quantity-input {
            width: 60px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Styling for the add to cart button */
        .add-to-cart-btn {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-to-cart-btn:hover {
            background-color: #45a049;
        }


    </style>
</head>
<body>

<div class="container">
    <!-- Bootstrap row with two columns for Cart, Logo, and Sign Out -->
    <div class="row align-items-center">
        <!-- Logo column -->
        <div class="col-2">
            <img src="web-logo-02.png" alt="Logo" style="max-width: 100%;">
        </div>
        <!-- Cart and Sign Out buttons column -->
        <div class="col-10 d-flex justify-content-end align-items-center">
            <!-- Cart button -->
            <button class="btn btn-primary mr-2" style="background-color: #4CAF50; border: none;" onclick="redirectToCart()">Cart</button>
            <!-- Sign Out button -->
            <form method="post">
                <button class="btn btn-danger" type="submit" name="signout">Sign Out</button>
            </form>
        </div>
    </div>
</div>

    <!-- Your other content -->
</div>

<div class="container">
    <h1 style='font-weight: bold; color: #333; '>Browse Products</h1>
    <div class="products-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<div class='product-info'>";
                echo "<h3 style='font-weight: bold; color: #333; font-size: 24px;'>" . $row["product_name"] . "</h3>";
                echo "<p style='font-weight: bold; color: #333; font-size: 16px;'>Price: ₹" . $row["price"] . "</p>";

                // Add input field for quantity
                echo "<form id='form" . $row["id"] . "' action='add_to_cart.php' method='POST'>";
                echo "<input type='hidden' name='productId' value='" . $row["id"] . "'>";

                echo "<input type='hidden' name='phone' value='" . $_SESSION['phone'] . "'>";
                echo "<input type='hidden' name='name' value='" . $_SESSION['name'] . "'>";
                echo "<label for='quantity' style='display: inline-block; margin-right: 10px; font-weight: bold;'>Quantity:</label>";
                echo "<input type='number' id='quantity" . $row["id"] . "' name='quantity' value='1' min='1' style='width: 60px; padding: 5px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; margin-right: 10px;'>"; 
                echo "<button type='button' onclick='addToCartWithQuantity(" . $row["id"] . ")' style='padding: 8px 12px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;'>Add to Cart</button>";
                echo "</form>";

                echo "</div>";
                echo "<img src='" . $row["product_image"] . "' alt='Product Image'>";
                echo "</div>";
            }
        } else {
            echo "<div class='empty-message'>No products available.</div>";
        }
        ?>
    </div>
</div>

<script>
function addToCartWithQuantity(productId) {
    var quantity = document.getElementById('quantity' + productId).value; // Get the quantity
    var form = document.getElementById('form' + productId);

    // Update form action with productId and quantity as GET parameters
    form.action = 'add_to_cart.php?product_id=' + productId + '&quantity=' + quantity + '&phone=<?php echo $_SESSION['phone']; ?>';
    
    // Submit the form
    form.submit();
}

function redirectToCart() {
    // Redirect to add_to_cart.php
    window.location.href = "add_to_cart.php";
}
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#checkoutBtn').click(function() {
        $.ajax({
            url: 'update_payment.php', // PHP script to handle the update
            type: 'POST',
            data: { action: 'update_payment' }, // Send action parameter to identify the request
            success: function(response) {
                alert(response); // Show the response message
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});
</script>

</body>
</html>
