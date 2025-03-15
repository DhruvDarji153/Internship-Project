<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$upi_id = 'dhruvdarji1503@okhdfcbank';
$total_amount = $_SESSION['total_amount'] ?? 0;

if ($total_amount <= 0) {
    echo 'Invalid payment amount!';
    exit();
}

echo "<h1>UPI Payment</h1>";
echo "<p>Scan the QR code or use the following UPI ID to make the payment:</p>";
echo "<p>UPI ID: $upi_id</p>";
echo "<p>Total Amount: ₹$total_amount</p>";
echo "<p>Once payment is completed, click the button below to verify and complete the order.</p>";
echo "<button onclick='verifyPayment()'>Verify Payment</button>";
?>

<script>
function verifyPayment() {
    alert('Payment verification in progress...');
    window.location.href = 'invoice.php';
}
</script>
