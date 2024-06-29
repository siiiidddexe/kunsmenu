<?php
session_start();

// Check if the user is logged in and if the phone number is set
if (!isset($_SESSION['phone'])) {
    echo '0'; // If not logged in, return 0
    exit;
}

include 'conn.php';

$phone = $_SESSION['phone'];

// Establish a database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo '0'; // Return 0 if there's a connection error
    exit;
}

// Fetch the cart item count for the specific phone number with pending payment
$sql = "SELECT COUNT(*) AS cartItemCount FROM cart WHERE phone_number = ? AND payment = 'pending'";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $phone);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cartItemCount = $row['cartItemCount'];
    echo $cartItemCount; // Return the cart item count
} else {
    echo '0'; // If no rows returned, return 0
}

$stmt->close();
$conn->close();
?>
