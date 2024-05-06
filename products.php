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

if (isset($_POST['signout'])) {
    session_start(); // Start the session
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header('Location: login.php'); // Redirect to the login page after signing out
    exit;
}

// Check if phone number is not set in session, redirect to login
if (!isset($_SESSION['phone'])) {
    header('Location: login.php');
    exit;
}
echo "Client_id:"," " , $_SESSION['phone'];
// Fetch products from the database
$sql = "SELECT * FROM products";
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
    <title>Products Page</title>


    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
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
        }

        .product img {
            max-width: 100px;
            height: auto;
            margin-right: 20px;
            border-radius: 5px;
        }

        .product-info {
            flex-grow: 1;
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
    
    </style>
</head>
<body>

<div class="container">
        <!-- Bootstrap row with two columns for Cart and Sign Out -->
        <div class="row">
            <!-- First column for Cart button -->
            <div class="col-l" style="padding-left:10px; padding-top:10px;" >
                <button class="btn btn-primary mr-2" onclick="redirectToCart()">Cart</button>
            </div>
            <!-- Second column for Sign Out button -->
            <div class="col-l" style=" padding-top:10px;"  >
                <form method="post">
                    <button class="btn btn-danger" type="submit" name="signout">Sign Out</button>
                </form>
            </div>
        </div>
        <!-- Your other content -->
    </div>

<div class="container">
    <h1>Browse Products</h1>
    <div class="products-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<div class='product-info'>";
                echo "<h3>" . $row["product_name"] . "</h3>";
                echo "<p>Price: ₹" . $row["price"] . "</p>";
            
                // Add input field for quantity
  // Add input field for quantity
                echo "<label for='quantity" . $row["id"] . "'>Quantity:</label>";
                echo "<input type='number' id='quantity" . $row["id"] . "' name='quantity' value='1' min='1'>";
                echo "</div>";
                echo "<img src='" . $row["product_image"] . "' alt='Product Image'>";
                
                // Add a new button to trigger cart update
                echo "<button  onclick='addToCart(" . $row["id"] . ")'>Add to Cart</button>";
                echo "</div>";
            }
        } else {
            echo "<div class='empty-message'>No products available.</div>";
        }
        ?>
    </div>
</div>




<script>

    
    function addToCart(productId) {
    var phoneNumber = "<?php echo $_SESSION['phone'] ?? ''; ?>";
    var quantity = document.getElementById('quantity' + productId).value; // Get the selected quantity
        //alert(quantity);   alert(productId);
    if (phoneNumber) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                alert("Added to cart");
              
            }
        };
        // Send product ID, quantity, and phone number
        xhr.open("GET", "add_to_cart.php?product_id=" + productId + "&quantity=" + quantity + "&phone=" + phoneNumber, true);
        xhr.send();
    } else {
        alert("Please log in to add items to cart.");
    }
}


    function signOut() {
        // Redirect to login page
        window.location.href = "login.php";
        
    }

      // Function to redirect to add_to_cart.php securely
      function redirectToCart() {
            // Get the current page URL and replace "products.php" with "add_to_cart.php"
            var currentUrl = window.location.href;
            var redirectUrl = currentUrl.replace("products.php", "add_to_cart.php");
            // Redirect to the new URL
            window.location.href = redirectUrl;
        }
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</body>
</html>
