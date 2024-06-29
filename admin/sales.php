
<?php include 'auth.php'; ?>
<?php

include 'conn.php';

// Your remaining PHP code goes here...
?>

<?php


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Calculate total sales for today
$today_sales_sql = "SELECT SUM(products.price * cart.quantity) AS total_sales 
                    FROM cart 
                    INNER JOIN products ON cart.product_id = products.id 
                    WHERE cart.delivery_status = 'Completed' 
                    AND DATE(cart.timestamp) = CURDATE()";
$today_sales_result = $conn->query($today_sales_sql);
$row_today_sales = $today_sales_result->fetch_assoc();
$today_sales = $row_today_sales['total_sales'] ?? 0; // Use null coalescing operator

// Calculate total sales for the month
$month_sales_sql = "SELECT SUM(products.price * cart.quantity) AS total_sales 
                    FROM cart 
                    INNER JOIN products ON cart.product_id = products.id 
                    WHERE cart.delivery_status = 'Completed' 
                    AND MONTH(cart.timestamp) = MONTH(CURDATE())";
$month_sales_result = $conn->query($month_sales_sql);
$row_month_sales = $month_sales_result->fetch_assoc();
$month_sales = $row_month_sales['total_sales'] ?? 0; // Use null coalescing operator

// Calculate total sales for the year
$year_sales_sql = "SELECT SUM(products.price * cart.quantity) AS total_sales 
                   FROM cart 
                   INNER JOIN products ON cart.product_id = products.id 
                   WHERE cart.delivery_status = 'Completed' 
                   AND YEAR(cart.timestamp) = YEAR(CURDATE())";
$year_sales_result = $conn->query($year_sales_sql);
$row_year_sales = $year_sales_result->fetch_assoc();
$year_sales = $row_year_sales['total_sales'] ?? 0; // Use null coalescing operator

// Calculate total units sold for all products
$total_units_sql = "SELECT SUM(quantity) AS total_units_sold 
                    FROM cart 
                    WHERE delivery_status = 'Completed'";
$total_units_result = $conn->query($total_units_sql);
$row_total_units = $total_units_result->fetch_assoc();
$total_units_sold = $row_total_units['total_units_sold'] ?? 0; // Use null coalescing operator

// Fetch product sales data
$product_sales_sql = "SELECT products.product_name, 
                            SUM(CASE WHEN DATE(cart.timestamp) = CURDATE() THEN cart.quantity ELSE 0 END) AS qty_sold_today, 
                            SUM(CASE WHEN MONTH(cart.timestamp) = MONTH(CURDATE()) THEN cart.quantity ELSE 0 END) AS qty_sold_monthly, 
                            SUM(CASE WHEN YEAR(cart.timestamp) = YEAR(CURDATE()) THEN cart.quantity ELSE 0 END) AS qty_sold_yearly, 
                            products.price 
                        FROM cart 
                        INNER JOIN products ON cart.product_id = products.id 
                        WHERE cart.delivery_status = 'Completed' 
                        GROUP BY products.product_name, products.price";  // Include products.price in GROUP BY
$product_sales_result = $conn->query($product_sales_sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 1200px;
    margin: 20px auto;
    margin-bottom: 50px;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.section-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

.sales-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 30px;
}

.sales-info-box {
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    flex: 1;
    transition: all 0.3s ease;
    cursor: pointer;
}

.sales-info-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.sales-info-box h3 {
    font-size: 18px;
    margin-bottom: 10px;
}

.product-sales-tiles {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.product-tile {
    background-color: #f2f2f2;
    border-radius: 10px;
    padding: 20px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.product-tile:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.product-info h3 {
    font-size: 18px;
    margin-bottom: 10px;
}

.product-info p {
    margin-bottom: 5px;
}

.product-info p i {
    margin-right: 5px;
}

/* Font Awesome icons */
.fas {
    margin-right: 5px;
}

/* Responsive Styles */

/* For tablets and larger devices */
@media (min-width: 768px) {
    .container {
        padding: 30px;
    }

    .section-title {
        font-size: 32px;
    }

    .sales-info-box {
        padding: 30px;
    }

    .product-tile {
        padding: 30px;
    }
}

/* For phones and smaller devices */
@media (max-width: 767px) {
    .container {
        padding: 15px;
    }

    .section-title {
        font-size: 20px;
    }

    .sales-info {
        flex-direction: column;
        gap: 15px;
    }

    .sales-info-box {
        padding: 15px;
    }

    .product-sales-tiles {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    }

    .product-tile {
        padding: 15px;
    }
}


    </style>
</head>

<body>
    <div class="container">
        <h1 class="section-title">Sales Overview Dashboard</h1>
        <div class="sales-info">
            <div class="sales-info-box">
                <h3><i class="fas fa-money-bill-wave"></i> Today's Sales</h3>
                <p>₹<?php echo $today_sales; ?></p>
            </div>
            <div class="sales-info-box">
                <h3><i class="fas fa-chart-line"></i> Monthly Sales</h3>
                <p>₹<?php echo $month_sales; ?></p>
            </div>
            <div class="sales-info-box">
                <h3><i class="fas fa-chart-bar"></i> Yearly Sales</h3>
                <p>₹<?php echo $year_sales; ?></p>
            </div>
            <div class="sales-info-box">
                <h3><i class="fas fa-cubes"></i> Total Units Sold</h3>
                <p><?php echo $total_units_sold; ?></p>
            </div>
        </div>
        <h2 class="section-title">Product Sales Data</h2>
        <div class="product-sales-tiles">
            <?php
            while ($row = $product_sales_result->fetch_assoc()) {

                $total_revenue_day = $row['qty_sold_today'] * $row['price'];
                $total_revenue_month = $row['qty_sold_monthly'] * $row['price'];
                $total_revenue_year = $row['qty_sold_yearly'] * $row['price'];
            ?>
                <div class="product-tile">
                    <div class="product-info">
                      
                    <h3><?php echo $row['product_name']; ?></h3>
                        <p><i class="fas fa-chart-line"></i> Qty Sold Today: <?php echo $row['qty_sold_today']; ?></p>
                        <p><i class="fas fa-chart-bar"></i> Qty Sold Monthly: <?php echo $row['qty_sold_monthly']; ?></p>
                        <p><i class="fas fa-chart-pie"></i> Qty Sold Yearly: <?php echo $row['qty_sold_yearly']; ?></p>
                        <p><i class="fas fa-coins"></i> Total Revenue Today: ₹<?php echo $total_revenue_day; ?></p>
                        <p><i class="fas fa-coins"></i> Total Revenue Monthly: ₹<?php echo $total_revenue_month; ?></p>
                        <p><i class="fas fa-coins"></i> Total Revenue Yearly: ₹<?php echo $total_revenue_year; ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <script>
        // Function to reload the page after 2 seconds
        function autoRefreshPage() {
            setTimeout(function() {
                location.reload();
            }, 2000); // 2000 milliseconds = 2 seconds
        }

        // Call the function when the page loads
        window.onload = autoRefreshPage;
    </script>
</body>

</html>
