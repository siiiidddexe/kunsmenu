
<?php include 'auth.php'; ?>

<?php

include 'conn.php';

// Your remaining PHP code goes here...
?>

<?php


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for completing orders
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['complete_order'])) {
    $phone = $_POST['phone'];

    // Update delivery status to "Completed" for the selected order
    $update_sql = "UPDATE cart SET delivery_status = 'Completed' WHERE phone_number = '$phone' AND delivery_status = 'Pending'";
    if ($conn->query($update_sql) === TRUE) {
        // Redirect back to the kitchen display page after updating status
        header("Location: kds.php");
        exit();
    } else {
        echo "Error updating delivery status: " . $conn->error;
    }
}

// Fetch accepted orders with pending delivery status
$sql = "SELECT c.id, c.phone_number, c.name, p.product_name, c.quantity 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.delivery_status = 'Pending' AND c.order_status = 'accepted' 
        ORDER BY c.phone_number";

$result = $conn->query($sql);

$orders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $phone_number = $row['phone_number'];
        if (!isset($orders[$phone_number])) {
            $orders[$phone_number] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'items' => []
            ];
        }
        $orders[$phone_number]['items'][] = [
            'product_name' => $row['product_name'],
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
    <title>Kitchen Display System | Kun Rolls</title>
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
            text-align: center;
        }
        .order {
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        .order ul {
            list-style-type: disc;
            padding-left: 20px;
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
        .btn-complete {
            background-color: #28a745;
            color: #fff;
        }
        .btn-complete:hover {
            background-color: #218838;
        }

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
        <h1>Kitchen Display System</h1>
        <?php if (empty($orders)) : ?>
            <p>No pending orders.</p>
        <?php else : ?>
            <?php foreach ($orders as $phone => $order) : ?>
                <div class="order">
                    <p><strong>Customer ID:</strong> <?php echo $order['id']; ?></p>
                    <p><strong>Customer Name:</strong> <?php echo $order['name']; ?></p>
                    <p><strong>Phone Number:</strong> <?php echo $phone; ?></p>
                    <p><strong>Items Ordered:</strong></p>
                    <ul>
                        <?php foreach ($order['items'] as $item) : ?>
                            <li><?php echo $item['product_name'] . " x " . $item['quantity']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <!-- Complete Order Button -->
                    <form method="POST">
                        <input type="hidden" name="phone" value="<?php echo $phone; ?>">
                        <button class="btn btn-complete" type="submit" name="complete_order">Complete Order</button>
                    </form>
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
