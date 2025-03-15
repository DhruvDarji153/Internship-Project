<?php
include 'db_connect.php';

$gender = $_GET['gender'];
$offset = $_GET['offset'];
$limit = 24;

$query = "SELECT * FROM products WHERE gender='$gender' LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

while ($product = mysqli_fetch_assoc($result)): ?>
    <div class="product-card">
        <img src="uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
        <h3><?php echo $product['name']; ?></h3>
        <p>₹<?php echo $product['price']; ?></p>
        <a href="product_detail.php?id=<?php echo $product['id']; ?>">View Details</a>
    </div>
<?php endwhile; ?>
