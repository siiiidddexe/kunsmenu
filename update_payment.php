<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "ecommerce";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'update_payment') {
    // Check if the user is logged in
    if (!isset($_SESSION['phone'])) {
        echo "Please log in to checkout.";
        exit;
    }

    $phone = $_SESSION['phone'];

    // Update payment status to "pending" for the user's ordered items
    $update_sql = "UPDATE cart SET payment = 'pending' WHERE phone_number = '$phone' AND payment = 'null'";
    if ($conn->query($update_sql) === TRUE) {
        echo "Payment status updated to 'pending' for your ordered items.";
    } else {
        echo "Error updating payment status: " . $conn->error;
    }
}

$conn->close();
?>
