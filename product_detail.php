<?php
session_start();
include 'db_connect.php'; // Database connection

if (!isset($_GET['id'])) {
    die("Product ID not found!");
}

$id = $_GET['id'];
$query = "SELECT * FROM products WHERE id=$id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?></title>
    <link rel="stylesheet" href="product_detail.css"> <!-- External CSS -->
</head>
<body>

<div class="product-detail">
    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
    <h2><?php echo $product['name']; ?></h2>
    <p><?php echo $product['description']; ?></p>
    <p>Price: ₹<?php echo $product['price']; ?></p>
    <button class="add-to-cart" data-id="<?php echo $product['id']; ?>">Add to Cart</button>
</div>

</body>
</html>
