<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'jwellary_shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the total amount of all orders
$result = $conn->query("SELECT SUM(total_price) AS total_amount FROM orders");
$total_amount = 0;
if ($result && $row = $result->fetch_assoc()) {
    $total_amount = $row['total_amount'];
}
$conn->close();

echo number_format($total_amount, 2); // Format as a currency value
?>
