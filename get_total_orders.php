<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'jwellary_shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the total number of orders from the orders table
$result = $conn->query("SELECT COUNT(order_id) AS total_orders FROM orders");
$total_orders = 0;
if ($result && $row = $result->fetch_assoc()) {
    $total_orders = $row['total_orders'];
}
$conn->close();

echo $total_orders;
?>
