<?php
// Connect to the database (update connection details as needed)
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST["product_name"];
    $price = $_POST["price"];
    $discount = $_POST["discount"];
    $product_image = $_POST["product_image"]; // Assuming you upload the image separately

    // Insert product into the database
    $insert_sql = "INSERT INTO products (product_name, price, discount, product_image)
                   VALUES ('$product_name', $price, $discount, '$product_image')";
    if ($conn->query($insert_sql) === TRUE) {
        echo "Product uploaded successfully.";
    } else {
        echo "Error uploading product: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Product</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
        }


        .signout-btn {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            float: right;
        }

        .signout-btn:hover {
            background-color: #c82333;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .product {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 20px;
            transition: all 0.3s ease;
        }

        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .product img {
            max-width: 100px;
            height: auto;
            margin-right: 20px;
            border-radius: 5px;
        }

        .product-info {
            flex-grow: 1;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .empty-message {
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>
    <h1>Upload Product</h1>
    <form method="post">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required><br><br>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" required><br><br>
        <label for="discount">Discount:</label>
        <input type="number" id="discount" name="discount"><br><br>
        <!-- Assuming you have a separate file upload mechanism for the image -->
        <label for="product_image">Product Image:</label>
        <input type="text" id="product_image" name="product_image" required><br><br>
        <input type="submit" value="Upload Product">
    </form>
</body>
</html>
