<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "jwellary_shop");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch up to 6 featured products
$sql = "SELECT * FROM featured_products ORDER BY id DESC LIMIT 6";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Featured Products</title>
    <link rel="stylesheet" href="featured_products.css"> <!-- Link to CSS file -->
</head>
<body>

<section class="featured-section">
    <h2>Featured Products</h2>
    <p>Add Featured products to weekly lineup</p>

    <div class="slider">
        <div class="slider-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="slide">
                    <div class="product-card">
                        <?php if ($row['is_new']): ?>
                            <span class="new-badge">New</span>
                        <?php endif; ?>
                        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="product-image">
                        <div class="product-info">
                            <h3><?php echo $row['name']; ?></h3>
                            <p><?php echo $row['description']; ?></p>
                            <span class="price">₹<?php echo number_format($row['price'], 2); ?></span>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector(".slider-container");
    const slides = document.querySelectorAll(".slide");
    let index = 0;

    function slideNext() {
        index++;
        if (index >= slides.length) {
            index = 0;
        }
        slider.style.transform = `translateX(-${index * 300}px)`;
    }

    setInterval(slideNext, 3000); // Auto-slide every 3 seconds
});
</script>

</body>
</html>

<?php $conn->close(); ?>
