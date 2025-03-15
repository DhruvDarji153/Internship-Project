<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $total_price = $_POST['total_price'];
    $payment_method = $_POST['payment_method'];

    // Clear cart after checkout
    unset($_SESSION['cart']);

    echo "Order placed successfully! Payment Method: $payment_method. Total: ₹$total_price";
}
?>
