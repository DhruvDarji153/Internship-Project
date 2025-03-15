<?php
include 'db_connect.php';

$gender = $_GET['gender'];
$offset = $_GET['offset'];

$query = "SELECT * FROM products WHERE gender='$gender' LIMIT 24 OFFSET $offset";
$result = mysqli_query($conn, $query);

while ($product = mysqli_fetch_assoc($result)) {
    echo "
        <div class='product-item'>
            <img src='uploads/{$product['image']}' alt='{$product['name']}'>
            <h4>{$product['name']}</h4>
            <p>₹{$product['price']}</p>
            <a href='product_detail.php?id={$product['id']}' class='view-details'>View Details</a>
            <button class='add-to-cart' data-id='{$product['id']}'>Add to Cart</button>
        </div>
    ";
}
?>
