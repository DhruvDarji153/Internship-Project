<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "jwellary_shop");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch attraction data from the database
$sql = "SELECT * FROM attractions";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attractions</title>
    <link rel="stylesheet" href="attraction.css"> <!-- External CSS File -->
</head>
<body>

<div class="attraction-container">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="attraction-box">
            <div class="attraction-image">
                <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Attraction">
            </div>
            <div class="attraction-content">
                <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
                <p><?php echo htmlspecialchars($row['heading']); ?></p>
                <a href="<?php echo htmlspecialchars($row['shop_now_link']); ?>" class="shop-now">Shop Now</a>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php $conn->close(); ?>
</body>
</html>
