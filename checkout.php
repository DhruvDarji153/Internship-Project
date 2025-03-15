<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data from database
$query = "SELECT * FROM users WHERE id = '$user_id'";
$user_result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($user_result);

// Fetch cart data with product details
$cart_query = "
    SELECT cart.quantity, products.name, products.price, products.image
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = '$user_id'
";
$cart_result = mysqli_query($conn, $cart_query);

$total_price = 0;
$shipping_cost = 50;
$offer_discount = 20;

// Calculate total price before displaying the summary
while ($item = mysqli_fetch_assoc($cart_result)) {
    $product_total = $item['price'] * $item['quantity'];
    $total_price += $product_total;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel='stylesheet' type='text/css' href='checkout.css'>
    <style>
        .checkout-container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            gap: 20px;
        }
        .payment-details, .product-info {
            width: 45%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .product-item {
            margin: 10px 0;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .product-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-right: 10px;
        }
        #upi-details, #place-order-btn {
            margin: 10px 0;
            display: none;
        }
        h1, h2, h3 {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <h1>Checkout</h1>
    <div class='checkout-container'>
        <!-- Payment Details Section -->
        <div class='payment-details'>
            <h2>Payment Details</h2>
            <label>Shipping Type:</label>
            <select id='shipping-type' onchange='togglePaymentMethod()'>
                <option value='cod'>Cash on Delivery (COD)</option>
                <option value='upi'>UPI Payment</option>
            </select>

            <!-- UPI Payment Details -->
            <div id='upi-details'>
                <p>Pay to UPI ID: dhruvdarji1503@okhdfcbank</p>
                <p>Total Amount: ₹<span id='total-amount'></span></p>
                <button onclick='initiatePayment()'>Pay Now</button>
            </div>

            <!-- Place Order Button -->
            <form action="place_order.php" method="POST">
                <input type="hidden" name="total_price" value="<?php echo $total_price + $shipping_cost - $offer_discount; ?>">
                <button id="place-order-btn" type="submit">Place Order</button>
            </form>

            <!-- Summary -->
            <h3>Summary</h3>
            <p>Subtotal: ₹<?php echo number_format($total_price, 2); ?></p>
            <p>Shipping Cost: ₹<?php echo number_format($shipping_cost, 2); ?></p>
            <p>Discount: ₹<?php echo number_format($offer_discount, 2); ?></p>
            <p>Total: ₹<?php echo number_format($total_price + $shipping_cost - $offer_discount, 2); ?></p>
        </div>

        <!-- Order Summary Section -->
        <div class='product-info'>
            <h2>Order Summary</h2>
            <?php
            // Reset cart result for display
            $cart_result = mysqli_query($conn, $cart_query);
            while ($item = mysqli_fetch_assoc($cart_result)) {
                $product_total = $item['price'] * $item['quantity'];
            ?>
            <div class='product-item'>
                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Product">
                <p><?php echo htmlspecialchars($item['name']); ?></p>
                <p>Price: ₹<?php echo number_format($item['price'], 2); ?></p>
                <p>Quantity: <?php echo $item['quantity']; ?></p>
                <p>Total: ₹<?php echo number_format($product_total, 2); ?></p>
            </div>
            <?php } ?>
        </div>
    </div>

    <script>
        // Toggle payment method visibility
        function togglePaymentMethod() {
            const paymentType = document.getElementById('shipping-type').value;
            const upiDetails = document.getElementById('upi-details');
            const placeOrderBtn = document.getElementById('place-order-btn');
            const totalAmount = <?php echo $total_price + $shipping_cost - $offer_discount; ?>;
            document.getElementById('total-amount').innerText = totalAmount.toFixed(2);
            upiDetails.style.display = (paymentType === 'upi') ? 'block' : 'none';
            placeOrderBtn.style.display = (paymentType === 'cod') ? 'block' : 'none';
        }

        // Initiate UPI payment
        function initiatePayment() {
            alert('Redirecting to UPI payment...');
            window.location.href = 'upi_payment.php';
        }
    </script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
