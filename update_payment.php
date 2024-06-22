<?php
session_start();


include 'conn.php';

// Your remaining PHP code goes here...


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in and session phone is set
if (!isset($_SESSION['phone'])) {
    echo "Please log in to checkout.";
    exit;
}

$phone = $_SESSION['phone'];

// Update payment status to "pending" for all records associated with the session phone
$update_sql = "UPDATE cart SET payment = 'pending' WHERE phone_number = '$phone'";
if ($conn->query($update_sql) === TRUE) {
    echo "Payment status updated to 'pending' for all your ordered items.";
} else {
    echo "Error updating payment status: " . $conn->error;
}

// Close the connection after performing database operations
$conn->close();
?>
