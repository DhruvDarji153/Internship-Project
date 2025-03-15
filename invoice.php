<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user email
$user_query = "SELECT email FROM users WHERE id = '$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);
$user_email = $user['email'];

// Payment type (assumed to be passed or set)
$payment_type = 'Cash on Delivery';
$shipping_cost = 50;
$offer = '10% Discount on Orders Above ₹1000';
$discount = 0;

// Fetch cart data for calculating total price
$cart_query = "
    SELECT cart.quantity, products.name, products.price, products.image, products.description
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = '$user_id'
";
$cart_result = mysqli_query($conn, $cart_query);

// Calculate total price from the cart
$total_price = 0;
$order_details = "";
while ($item = mysqli_fetch_assoc($cart_result)) {
    $product_total = $item['price'] * $item['quantity'];
    $total_price += $product_total;
    $order_details .= "Product: " . $item['name'] . "\nQuantity: " . $item['quantity'] . "\nPrice: ₹" . number_format($item['price'], 2) . "\nTotal: ₹" . number_format($product_total, 2) . "\nDescription: " . $item['description'] . "\n\n";
}

// Apply discount if eligible
if ($total_price > 1000) {
    $discount = $total_price * 0.10;
    $total_price -= $discount;
}

// Add shipping cost
$total_price += $shipping_cost;

// Generate a unique order ID
$order_id = uniqid('ORD-');

// Store order details in the database
$order_query = "INSERT INTO orders (order_id, user_id, total_price, order_date) VALUES ('$order_id', '$user_id', '$total_price', NOW())";
mysqli_query($conn, $order_query);

// Clear cart after order
mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'");

// Email invoice to the user
$subject = "Order Confirmation - " . $order_id;
$invoice = "Jewelry Luxurious\nThank you for your order!\n\nOrder ID: $order_id\nPayment Type: $payment_type\nShipping Cost: ₹" . number_format($shipping_cost, 2) . "\nOffer: $offer\nDiscount: ₹" . number_format($discount, 2) . "\nTotal Price: ₹" . number_format($total_price, 2) . "\n\n$order_details";
$headers = "From: shop@jewelryluxurious.com";
mail($user_email, $subject, $invoice, $headers);

// Generate downloadable invoice file
$invoice_filename = "invoice_" . $order_id . ".txt";
file_put_contents($invoice_filename, $invoice);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thank You for Your Order</title>
    <style>
        body { text-align: center; padding: 50px; font-family: Arial, sans-serif; }
        .thank-you { font-size: 28px; color: #28a745; }
        .order-details { margin-top: 20px; text-align: left; display: inline-block; }
        .download-btn { margin-top: 20px; padding: 10px 20px; background-color: #007bff; color: white; border: none; cursor: pointer; border-radius: 5px; }
        .download-btn:hover { background-color: #0056b3; }
        img { width: 100px; height: auto; margin: 5px; }
    </style>
</head>
<body>
    <h1 class="thank-you">Thank You for Your Order!</h1>
    <h3>Your order has been placed successfully.</h3>
    <div class="order-details">
        <p>Shop Name: Jewelry Luxurious</p>
        <p>Order ID: <?php echo $order_id; ?></p>
        <p>Payment Type: <?php echo $payment_type; ?></p>
        <p>Shipping Cost: ₹<?php echo number_format($shipping_cost, 2); ?></p>
        <p>Offer: <?php echo $offer; ?></p>
        <p>Discount: ₹<?php echo number_format($discount, 2); ?></p>
        <p>Total Price: ₹<?php echo number_format($total_price, 2); ?></p>
        <h4>Product Details:</h4>
        <?php echo $order_details; ?>
    </div>
    <form method="post" action="download_invoice.php">
        <input type="hidden" name="invoice_filename" value="<?php echo $invoice_filename; ?>">
        <button type="submit" class="download-btn">Download Invoice</button>
    </form>
</body>
</html>
