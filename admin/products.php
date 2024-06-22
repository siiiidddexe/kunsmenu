<?php include 'auth.php'; ?>
<?php


include './conn.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['phone'])) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['signout'])) {
 
   
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Browse Products | Kun Rolls</title>
    <link rel="icon" href="kunrolltext.png" type="image/x-icon">

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
            flex-direction: column;
            align-items: center;
            justify-content: center;
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
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .product-info {
            flex-grow: 1;
            padding: 20px;
            text-align: center;
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

        .quantity-label {
            display: inline-block;
            margin-right: 10px;
            font-weight: bold;
        }

        .quantity-input {
            width: 60px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

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

        @media (min-width: 0px) {
            .logo {
                max-width: 300%;
                height: auto;
            }
        }

        @media (min-width: 768px) {
            body {
                margin-left: 50px;
                margin-right: 50px;
            }

            .logo {
                max-width: 110%;
                height: auto;
            }

            .product {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }

            .product img {
                margin-right: 20px;
                max-width: 100px;
            }

            .product-info {
                text-align: left;
                padding: 0 20px;
            }
        }

        @media (min-width: 1200px) {
            body {
                margin-left: 100px;
                margin-right: 100px;
            }

            .logo {
                max-width: 80%;
            }
        }

        body {
            background-color: #fbfbfb;
        }

        @media (min-width: 992px) {
            main {
                margin-left: 200px;
            }
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding: 58px 0 0;
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
            width: 240px;
            z-index: 600;
            background-color: #fff;
        }

        #searchInput {
            border-radius: 30px;
            height: 50px;
            padding-left: 40px;
            font-family: 'Font Awesome 5 Free';
        }

        #searchInput::placeholder {
            font-family: 'Font Awesome 5 Free';
            content: '\f002'; /* Unicode for search icon */
        }
    
.quantity-btn {
   
    color: white;
    border: none;
    padding: 8.3px 19px;
    cursor: pointer;
    font-size: 18px;
    border-radius: 100%;
    transition: background-color 0.3s ease;
}

.quantity-btn:hover {
    background-color: #0056b3;
}

.quantity-container {
    display: flex;
    align-items: center;
    padding:20px;
}



    </style>
</head>
<body>

<div class="container">
    <div class="row align-items-center">
        <div class="col-2">
            <img src="web-logo-02.png" alt="Logo" height="120%" width="120%" class="logo">
        </div>
        <div class="col-10 d-flex justify-content-end align-items-center">
        <button class="btn btn-primary mr-2" style="background-color: #4CAF50; border: none;" onclick="redirectToCart()">Cart (<span id="cartItemCount">0</span>)</button>

            <form method="post">
                <button class="btn btn-danger" type="submit" name="signout">Sign Out</button>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <h1 style='font-weight: bold; color: #333;'>Browse Products</h1>
    <h6 style='font-weight: bold; text-align:center; margin-top:-20px; margin-bottom:30px; color: #333;'>To Add To Cart</h6>
    
    <form method="post" class="mb-4" id="searchForm">
        <div class="input-group">
            <input type="text" name="search" style="border-radius: 30px; height:50px; font-weight:solid;" id="searchInput" class="form-control" placeholder="&#xf002; Search for products..." value="">
        </div>
    </form>

    <div class="products-container" id="productsContainer">
        <!-- Products will be loaded here -->
    </div>
</div>

<script>
function addToCartWithQuantity(productId) {
    var quantity = document.getElementById('quantity' + productId).value;
    var form = document.getElementById('form' + productId);

    form.action = 'add_to_cart.php?product_id=' + productId + '&quantity=' + quantity + '&phone=<?php echo $_SESSION['phone']; ?>';
    form.submit();
}

function redirectToCart() {
    window.location.href = "add_to_cart.php";
}

document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('searchInput');
    var productsContainer = document.getElementById('productsContainer');

    function fetchProducts(query = '') {
        $.ajax({
            url: 'search_products.php',
            method: 'POST',
            data: { search: query },
            success: function(response) {
                productsContainer.innerHTML = response;
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    searchInput.addEventListener('input', function() {
        fetchProducts(searchInput.value);
    });

    searchInput.addEventListener('focus', function() {
        searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
    });

    fetchProducts(); // Load all products on page load
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    $('#checkoutBtn').click(function() {
        $.ajax({
            url: 'update_payment.php',
            type: 'POST',
            data: { action: 'update_payment' },
            success: function(response) {
                alert(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});
</script>

<script>
function increaseQuantity(productId) {
    var quantityInput = document.getElementById('quantity' + productId);
    quantityInput.value = parseInt(quantityInput.value) + 1;
}

function decreaseQuantity(productId) {
    var quantityInput = document.getElementById('quantity' + productId);
    if (quantityInput.value > 1) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
    }
}
</script>

<script>
function updateQuantity(productId, change) {
    var quantityInput = document.getElementById('quantity' + productId);
    var currentQuantity = parseInt(quantityInput.value);
    var newQuantity = currentQuantity + change;

    if (newQuantity < 0) {
        newQuantity = 0;
    }

    quantityInput.value = newQuantity;

    var formData = new FormData();
    formData.append('productId', productId);
    formData.append('quantity', newQuantity);
    formData.append('phone', "<?php echo $_SESSION['phone']; ?>");
    formData.append('name', "<?php echo $_SESSION['name']; ?>");

    fetch('add_to_cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    updateCartItemCount(); // Update cart item count when the page loads

    // Function to update cart item count
    function updateCartItemCount() {
        $.ajax({
            url: 'get_cart_item_count.php', // Replace this with the actual URL to fetch cart item count
            type: 'GET',
            success: function(response) {
                $('#cartItemCount').text(response); // Update the cart item count in the button
            },
            error: function(xhr, status, error) {
                console.error(status, error); // Log any errors to the console
            }
        });
    }

    // Function to redirect to cart page
    function redirectToCart() {
        // Replace 'cart.php' with the actual URL of your cart page
        window.location.href = 'cart.php';
    }

    // Call updateCartItemCount function periodically (every 5 seconds in this example)
    setInterval(updateCartItemCount, 500);
});
</script>

</body>
</html>
