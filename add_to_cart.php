<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Please log in first.");
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['id'];

// Check if the product is already in the cart
$query = "SELECT * FROM cart WHERE product_id = '$product_id' AND user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Update quantity
    $update_query = "UPDATE cart SET quantity = quantity + 1 WHERE product_id = '$product_id' AND user_id = '$user_id'";
    mysqli_query($conn, $update_query);
} else {
    // Insert new item into cart
    $insert_query = "INSERT INTO cart (product_id, user_id, quantity) VALUES ('$product_id', '$user_id', 1)";
    mysqli_query($conn, $insert_query);
}

header("Location: cart.php");
exit();
?>
