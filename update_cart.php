<?php
session_start();
$phone_number = $_SESSION['phone'];

if (isset($_GET['product_id']) && isset($_GET['quantity'])) {
    $product_id = $_GET['product_id'];
    $quantity = $_GET['quantity'];

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "ecommerce";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the quantity in the cart table
    $update_sql = "UPDATE cart SET quantity = $quantity WHERE product_id = $product_id AND phone_number = '$phone_number'";
    if ($conn->query($update_sql) === TRUE) {
        echo "Quantity updated successfully";
    } else {
        echo "Error updating quantity: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Product ID and quantity not provided";
}
?>
