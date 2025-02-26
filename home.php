<?php
include 'db.php'; // Database connection

// Fetch carousel items from the database
$sql = "SELECT * FROM carousel ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jewelry Shop</title>
    <link rel="stylesheet" href="style.css"> <!-- External CSS -->
</head>
<body>
    
    <!-- Navbar Section -->
    <?php include 'navbar.php'; ?>

    <!-- Dynamic Carousel Section -->
    <div class="carousel-container">
        <div class="carousel">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="slide">
                    <img src="<?php echo $row['image_path'];?>" width="100%" alt="Carousel Image">
                    <div class="carousel-content">
                        <h1><?php echo $row['heading']; ?></h1>
                        <p><?php echo $row['description']; ?> <span><?php echo $row['highlighted_text']; ?></span></p>
                        <a href="<?php echo $row['button_link']; ?>" class="button"> <?php echo $row['button_text']; ?> </a>
                    </div>
                </div>
            <?php } ?>
        </div>
        
        <!-- Carousel Controls -->
        <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
        <button class="next" onclick="moveSlide(1)">&#10095;</button>
    </div>

    <!-- New Arrivals Section -->
    <section class="new-arrivals">
        <h2>New Arrivals</h2>
        <div class="product-container">
            <!-- Dynamic Product Cards Here -->
        </div>
    </section>

    <!-- JavaScript for Carousel Auto-Sliding & Controls -->
    <script>
          document.addEventListener("DOMContentLoaded", () => {
    let index = 0;
    const slides = document.querySelectorAll(".slide");

    function showSlides() {
        slides.forEach(slide => slide.style.display = "none");
        slides[index].style.display = "block";
    }

    function moveSlide(step) {
        index = (index + step + slides.length) % slides.length;
        showSlides();
    }

    function autoSlide() {
        moveSlide(1);
        setTimeout(autoSlide, 3000);
    }

    showSlides();
    setTimeout(autoSlide, 3000);


   

    document.querySelector(".prev").addEventListener("click", () => moveSlide(-1));
    document.querySelector(".next").addEventListener("click", () => moveSlide(1));
});

    </script>

</body>
</html>
