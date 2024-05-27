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
    $product_image = $_POST["product_image"]; // Assuming you upload the image separately
    $availability = isset($_POST["availability"]) ? $_POST["availability"] : "available"; // Default to "available" if not set

    // Insert product into the database
    $insert_sql = "INSERT INTO products (product_name, price, product_image, availability)
                   VALUES ('$product_name', $price, '$product_image', '$availability')";
    if ($conn->query($insert_sql) === TRUE) {
        echo "Product uploaded successfully.";
    } else {
        echo "Error uploading product: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["product_id"];
    $available = isset($_POST["availability"]) && $_POST["availability"] === "available" ? 1 : 0;

    // Update product availability in the database
    $update_sql = "UPDATE products SET availability = $available WHERE id = $product_id";
    if ($conn->query($update_sql) === TRUE) {
        echo "Product availability updated successfully.";
    } else {
        echo "Error updating product availability: " . $conn->error;
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
            margin: 200px;
        
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 200px auto;
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

        body {
            font-family: Arial, sans-serif;
            margin: 0;
          
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

        .form-control {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
    </style>
</head>
<body style="padding : 25% ">

    <h1>Upload Product</h1>
    <form method="post">
    <label for="product_name">Product Name:</label>
    <input type="text" id="product_name" name="product_name" required><br><br>
    <label for="price">Price:</label>
    <input type="number" id="price" name="price" required><br><br>

    <!-- Assuming you have a separate file upload mechanism for the image -->
    <label for="product_image">Product Image:</label>
    <input type="text" id="product_image" name="product_image" required><br><br>

    <!-- Checkboxes for availability -->


        <label for="product_id">Product ID:</label>
    <input type="text" id="product_id" name="product_id" required><br><br>
    <label for="availability">Availability:</label><br>
    <input type="checkbox" id="available" name="availability" value="available">
    <label for="available">Available</label><br>
    <input type="checkbox" id="unavailable" name="availability" value="unavailable">
    <label for="unavailable">Unavailable</label><br><br>

    <input type="submit" value="Upload Product">
</form>

</body>
</html>
