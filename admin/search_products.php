<?php
session_start();

include './conn.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchQuery = "";
if (isset($_POST['search'])) {
    $searchQuery = $_POST["search"];
    $sql = "SELECT * FROM products WHERE availability = 'available' AND product_name LIKE '%" . $conn->real_escape_string($searchQuery) . "%' ORDER BY id ASC";
} else {
    $sql = "SELECT * FROM products WHERE availability = 'available' ORDER BY id ASC";
}

$result = $conn->query($sql);

if ($result === false) {
    die("Error fetching products: " . $conn->error);
}

$output = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= "<div class='product'>";
        $output .= "<div class='product-info'>";
        $output .= "<h3 style='font-weight: bold; color: #333; font-size: 24px;'>" . htmlspecialchars($row["product_name"]) . "</h3>";
        $output .= "<p style='font-weight: bold; color: #333; font-size: 16px;'>Price: ₹" . htmlspecialchars($row["price"]) . "</p>";
        $output .= "<form id='form" . htmlspecialchars($row["id"]) . "' action='add_to_cart.php' method='POST'>";
        $output .= "<input type='hidden' name='productId' value='" . htmlspecialchars($row["id"]) . "'>";
        $output .= "<input type='hidden' name='phone' value='" . htmlspecialchars($_SESSION['phone']) . "'>";
        $output .= "<input type='hidden' name='name' value='" . htmlspecialchars($_SESSION['name']) . "'>";
        $output .= "<label for='quantity' style='display: inline-block; margin-right: 10px; font-weight: bold;'>Quantity:</label>";
        $output .= "<div class='quantity-container' style='display: inline-block;'>";
        $output .= "<button type='button' style=' background-color: #c82333;' class='quantity-btn' onclick='updateQuantity(" . htmlspecialchars($row["id"]) . ", -1)'>-</button>";
        $output .= "<input type='number' id='quantity" . htmlspecialchars($row["id"]) . "' name='quantity' value='0' min='0' style='width: 60px; padding: 5px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; margin: 0 5px; text-align: center;' readonly>";
        $output .= "<button type='button' style=' background-color: #45a049;' class='quantity-btn' onclick='updateQuantity(" . htmlspecialchars($row["id"]) . ", 1)'>+</button>";
        $output .= "</div>";
        $output .= "</form>";
        $output .= "</div>";
        $output .= "<img src='" . htmlspecialchars($row["product_image"]) . "' alt='Product Image'>";
        $output .= "</div>";
    }
} else {
    $output = "<div class='empty-message'>No products available.</div>";
}

echo $output;

?>

