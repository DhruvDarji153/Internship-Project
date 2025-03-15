<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Please log in first.");
}

$cart_id = $_GET['id'];
$query = "DELETE FROM cart WHERE id = '$cart_id'";
mysqli_query($conn, $query);

header("Location: cart.php");
exit();
?>
