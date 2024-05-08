<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['phone'])) {
    echo "Please log in to update quantities.";
    exit;
}

$phone = $_SESSION['phone'];

// Check if product_id and quantity are provided via POST
if (isset($_POST['product_id'], $_POST['quantity'], $_POST['phone'])) {
    $product_id = $_POST['product_id'];
    $quantity = intval($_POST['quantity']); // Ensure quantity is an integer
    $phone_number = $_POST['phone'];

    // Connect to the database (update connection details as needed)
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
        echo "Quantity updated successfully for Product ID: $product_id";
    } else {
        echo "Error updating quantity for Product ID: $product_id - " . $conn->error;
    }

    $conn->close();
} else {
    echo "Missing data.";
}
?>
