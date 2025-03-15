<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Please log in first.");
}

$user_id = $_SESSION['user_id'];
$query = "SELECT cart.*, products.name, products.price, products.image 
          FROM cart 
          JOIN products ON cart.product_id = products.id 
          WHERE cart.user_id = '$user_id'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shopping Cart</title>
     <link rel="stylesheet" href="cart.css">
</head>
<body>

<h2>Your Cart</h2>
<table border="1">
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Remove</th>
    </tr>

    <?php 
    $total_price = 0;
    while ($row = mysqli_fetch_assoc($result)) { 
        $subtotal = $row['price'] * $row['quantity'];
        $total_price += $subtotal;
    ?>
        <tr>
            <td><img src="<?php echo $row['image']; ?>" width="50"></td>
            <td><?php echo $row['name']; ?></td>
            <td>₹<?php echo $row['price']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td>₹<?php echo $subtotal; ?></td>
            <td><a href="remove_from_cart.php?id=<?php echo $row['id']; ?>">Remove</a></td>
        </tr>
    <?php } ?>

</table>

<h3>Total Price: ₹<?php echo $total_price; ?></h3>
<a href="checkout.php">Proceed to Checkout</a>

</body>
</html>
