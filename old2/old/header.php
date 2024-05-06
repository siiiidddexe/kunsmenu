<?php
require_once 'connection.php';
session_start();
$phone = $_SESSION['phone'];
$sql_cart_count = "SELECT COUNT(DISTINCT product_id) AS num_items FROM cart WHERE phone='$phone'";
$cart_count_result = $conn->query($sql_cart_count);
$cart_count_row = $cart_count_result->fetch_assoc();
$cart_count = $cart_count_row['num_items'];

if (isset($_POST['signout'])) {
    session_destroy();
    header('location: home.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header.css">
</head>
<body>
     <header>
     <form method="POST" action="">
            <button type="submit" name="signout">Sign-out</button>
        </form>
         <h1><a href="homee.php"></a></h1>
         <div id="main_tabs">
             <a href="homee.php">
                 <div class="logo-container">
                     <img src="weblogo.png" alt="Web Logo" style="height: 60px; width: 100px; margin-top: -30px;"  class="weblogo">
                 </div>
             </a>
         </div>
         <a href="cart.php">Cart <span id="badge"><?php echo $cart_count; ?></span></a>
     </header>
</body>
</html>
