<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        /* Your CSS styles here */
    </style>

    <!-- Include necessary Bootstrap and JavaScript libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>Order Acceptance</h1>
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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['accept_order'])) {
                $order_id = $_POST['order_id'];
                // Update the order status to "Paid" in the database
                $update_sql = "UPDATE cart SET payment = 'paid' WHERE id = $order_id AND payment = 'pending'";
                if ($conn->query($update_sql) === TRUE) {
                    echo "Order with ID $order_id has been marked as Paid.";
                } else {
                    echo "Error updating order status: " . $conn->error;
                }
            } elseif (isset($_POST['reject_order'])) {
                $order_id = $_POST['order_id'];
                // Update the order status to "Rejected" in the database
                $update_sql = "UPDATE cart SET payment = 'rejected' WHERE id = $order_id AND payment = 'pending'";
                if ($conn->query($update_sql) === TRUE) {
                    echo "Order with ID $order_id has been rejected.";
                } else {
                    echo "Error updating order status: " . $conn->error;
                }
            }
        }

        // Fetch orders with status "pending" from the cart table
        $fetch_sql = "SELECT * FROM cart WHERE payment = 'pending'";
        $result = $conn->query($fetch_sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>Order ID: " . $row['id'] . "</h5>";
                echo "<p class='card-text'>Customer Name: " . $row['customer_name'] . "</p>";
                echo "<p class='card-text'>Total Amount: ₹" . $row['total_amount'] . "</p>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='order_id' value='" . $row['id'] . "'>";
                echo "<button type='submit' name='accept_order' class='btn btn-success'>Accept</button>";
                echo "<button type='submit' name='reject_order' class='btn btn-danger'>Reject</button>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No orders with status 'pending' found.</p>";
        }

        $conn->close();
        ?>
    </div>

    <!-- Add your JavaScript code here if needed -->

</body>

</html>
