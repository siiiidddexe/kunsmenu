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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['phone'], $_POST['status'])) {
        $phone_number = $_POST['phone'];
        $status = $_POST['status'];

        // Update order status
        $update_sql = "UPDATE cart SET order_status = '$status' WHERE phone_number = '$phone_number' AND payment = 'checkout'";
        if ($conn->query($update_sql) === TRUE) {
            echo "Order status updated to $status.";
        } else {
            echo "Error updating order status: " . $conn->error;
        }
    } else {
        echo "Invalid request.";
    }
}

$conn->close();
?>
