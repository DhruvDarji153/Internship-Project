<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "jwellary_shop");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch featured products (limit 6)
$sql = "SELECT * FROM featured_products ORDER BY id DESC LIMIT 6";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Featured Products</title>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    
    <link rel="stylesheet" href="styles.css"> <!-- External CSS -->
</head>
<body>

<h2 class="section-title">Featured Products</h2>
<p class="section-description">Add Featured products to weekly lineup</p>

<div class="swiper-container">
    <div class="swiper-wrapper">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="swiper-slide">
                <div class="product-card">
                    <?php if ($row['is_new'] == 1): ?>
                        <span class="new-badge">New</span>
                    <?php endif; ?>
                    <img src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['name']; ?>" class="product-image">
                    <div class="product-info">
                        <h3><?php echo $row['name']; ?></h3>
                        <p><?php echo $row['description']; ?></p>
                        <span class="price">₹<?php echo number_format($row['price']); ?></span>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Pagination & Navigation -->
    <!-- <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div> -->
</div>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".swiper-container", {
        slidesPerView: 3, 
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        }
    });
</script>

</body>
</html>

<?php $conn->close(); ?>
