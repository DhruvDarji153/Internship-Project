<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$total_price = $_POST['total_price'];

// Fetch user email
$user_query = "SELECT email FROM users WHERE id = '$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);
$user_email = $user['email'];

// Generate a unique order ID
$order_id = uniqid('ORD-');

// Store order details in the database
$order_query = "INSERT INTO orders (order_id, user_id, total_price, order_date) VALUES ('$order_id', '$user_id', '$total_price', NOW())";
mysqli_query($conn, $order_query);

// Fetch cart data for the order
$cart_query = "
    SELECT cart.quantity, products.name, products.price, products.image
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = '$user_id'
";
$cart_result = mysqli_query($conn, $cart_query);

$order_details = "";
while ($item = mysqli_fetch_assoc($cart_result)) {
    $product_total = $item['price'] * $item['quantity'];
    $order_details .= "
        Product: " . $item['name'] . "\n
        Quantity: " . $item['quantity'] . "\n
        Price: ₹" . number_format($item['price'], 2) . "\n
        Total: ₹" . number_format($product_total, 2) . "\n\n";
}

// Clear cart after order
mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'");

// Email invoice to the user
$subject = "Order Confirmation - " . $order_id;
$invoice = "Thank you for your order!\n\nOrder ID: $order_id\nTotal Price: ₹" . number_format($total_price, 2) . "\n\n$order_details";
$headers = "From: shop@jewelryshop.com";
mail($user_email, $subject, $invoice, $headers);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thank You for Your Order</title>
    <style>
        body {
            text-align: center;
            padding: 50px;
            font-family: Arial, sans-serif;
        }
        .thank-you {
            font-size: 28px;
            color: #28a745;
        }
        .order-details {
            margin-top: 20px;
            text-align: left;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1 class="thank-you">Thank You for Your Order!</h1>
    <h3>Your order has been placed successfully.</h3>
    <div class="order-details">
        <p>Order ID: <?php echo $order_id; ?></p>
        <p>Total Price: ₹<?php echo number_format($total_price, 2); ?></p>
        <h4>Order Details:</h4>
        <pre><?php echo $order_details; ?></pre>
    </div>


   <a href='invoice.php'>Downlod Invoice</a>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
