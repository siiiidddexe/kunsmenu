<?php
include 'conn.php'; // Ensure your database connection file is included

// Query to check for new orders
$query = "SELECT COUNT(*) AS new_orders FROM cart WHERE order_status = 'pending' AND payment = 'checkout'";
$result = $conn->query($query);
$row = $result->fetch_assoc();

$new_orders = $row['new_orders'];

// Outputting the new orders count for the parent page to check
echo json_encode(['new_orders' => $new_orders]);
?>
