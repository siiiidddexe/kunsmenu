
<?php include 'auth.php'; ?>

<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "ecommerce";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle accept and reject buttons
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['phone'], $_POST['status'])) {
        $phone = $_POST['phone'];
        $status = $_POST['status'];

        // Update order status
        $update_sql = "UPDATE cart SET order_status = '$status' WHERE phone_number = '$phone' AND payment = 'checkout'";
        if ($conn->query($update_sql) === TRUE) {
            // Redirect back to the order management page after updating status
            header("Location: orderstatus.php");
            exit();
        } else {
            echo "Error updating order status: " . $conn->error;
        }
    }
}

// Fetch pending orders with payment status 'checkout' and order_status 'pending'
$sql = "SELECT c.phone_number, p.product_name, p.price, c.quantity, c.name, c.order_status
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.payment = 'checkout' AND c.order_status = 'pending'
        ORDER BY c.phone_number";

$result = $conn->query($sql);

$orders = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $phone_number = $row['phone_number'];
        if (!isset($orders[$phone_number])) {
            $orders[$phone_number] = [
                'name' => $row['name'],
                'products' => [],
                'order_status' => $row['order_status']
            ];
        }
        $orders[$phone_number]['products'][] = [
            'product_name' => $row['product_name'],
            'price' => $row['price'],
            'quantity' => $row['quantity']
        ];
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Incoming Orders | Kun Rolls</title>
<link rel="icon" href="../kunrolltext.png" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
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
        .order {
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        .order-total {
            font-weight: bold;
            margin-top: 10px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-right: 10px;
        }
        .btn-accept {
            background-color: #28a745;
            color: #fff;
        }
        .btn-accept:hover {
            background-color: #218838;
        }
        .btn-reject {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-reject:hover {
            background-color: #c82333;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            font-size: 32px;
        }

        .order {
            margin-bottom: 30px;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 20px;
            transition: all 0.3s ease;
            padding: 30px;
            border-radius: 20px;
        }

        .order:hover {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .order-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .order-details p {
            margin: 0;
            font-size: 18px;
            color: #555;
        }

        .order-total {
            font-weight: bold;
            margin-top: 10px;
            font-size: 20px;
            color: #333;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            color: #fff;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-accept {
            background-color: #28a745;
        }

        .btn-reject {
            background-color: #dc3545;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .order-status {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
            color: #333;
            text-transform: uppercase;
        }

        .btn-group {
    display: flex;
   
    margin-top: 10px;
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Management</h1>
        <?php if (empty($orders)) : ?>
            <p>No orders pending.</p>
        <?php else : ?>
            <?php foreach ($orders as $phone => $order) : ?>
                <div class="order">
                    <p><strong>Name:</strong> <?php echo $order['name']; ?></p>
                    <p><strong>Phone Number:</strong> <?php echo $phone; ?></p>
                    <p><strong>Products:</strong></p>
                    <ul>
                        <?php 
                        $order_total = 0;
                        foreach ($order['products'] as $product) : 
                            $total_price = $product['price'] * $product['quantity'];
                            $order_total += $total_price;
                        ?>
                            <li><?php echo $product['product_name'] . " x " . $product['quantity'] . " = ₹" . $total_price; ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <p class="order-total">Order Total: ₹<?php echo $order_total; ?></p>
                    <p style=" font-weight: solid;">Status: <?php echo $order['order_status']; ?></p>
   <div class="btn-group">
    <form method="POST" style="display: flex;">
        <input type="hidden" name="phone" value="<?php echo $phone; ?>">
        <input type="hidden" name="status" value="accepted">
        <button class="btn btn-accept" type="submit">Accept</button>
    </form>
    <form method="POST" style="display: flex;">
        <input type="hidden" name="phone" value="<?php echo $phone; ?>">
        <input type="hidden" name="status" value="rejected">
        <button class="btn btn-reject" type="submit">Reject</button>
    </form>
</div>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <script>
        // Function to reload the page after 3 seconds
        function autoRefreshPage() {
            setTimeout(function() {
                location.reload();
            }, 2000); // 3000 milliseconds = 3 seconds
        }

        // Call the function when the page loads
        window.onload = autoRefreshPage;
    </script>
</body>
</html>
