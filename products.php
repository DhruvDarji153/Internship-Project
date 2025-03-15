<?php
session_start();
include 'db_connect.php'; // Database connection

$category = isset($_GET['category']) ? $_GET['category'] : 'Men'; // Default to Men
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - <?php echo $category; ?></title>
    <link rel="stylesheet" href="products.css"> <!-- External CSS -->
</head>
<body>

<h2><?php echo $category; ?> Jewelry</h2>

<div class="product-container">
    <?php
    $query = "SELECT * FROM products WHERE category='$category' LIMIT 24";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='product-card'>
                <img src='{$row['image']}' alt='{$row['name']}'>
                <h3>{$row['name']}</h3>
                <p>₹{$row['price']}</p>
                <a href='product_detail.php?id={$row['id']}'>View Details</a>
                <a href='add_to_cart.php?id={$row['id']}'>Add to Cart</a>
                
              </div>";
    }
    ?>
</div>
<?php
 include('add_review.php')
?>
</body>
</html>
