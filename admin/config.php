<?php
define('DB_SERVER', 'localhost'); // Replace with your database server
define('DB_USERNAME', 'root');    // Replace with your database username
define('DB_PASSWORD', 'root');    // Replace with your database password
define('DB_NAME', 'ecommerce');




// Attempt to connect to MySQL database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check the connection
if($conn === false){
    die("ERROR: Could not connect. " . $conn->connect_error);
}
?>
