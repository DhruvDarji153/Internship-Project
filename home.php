<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="home.css">

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- jQuery (Required for Slick) -->
    <script src="assets/js/jquery-1.11.0.min.js"></script>

</head>
<body>

    <!-- Navbar -->
    <header class="header">
        <nav>
            <div class="logo">
                <a href="index.html">Jewelry <span>Luxurious</span></a>
            </div>
            <input type="checkbox" id="menu-toggle">
            <label for="menu-toggle" class="menu-icon">&#9776;</label>
            <ul class="menu">
                <li><a href="#">Home</a></li>
                <li class="dropdown">
                    <a href="#">Product</a>
                    <div class="dropdown-content">
                        <a href="#">Gold</a>
                        <a href="#">Diamond</a>
                        <a href="#">Silver</a>
                    </div>
                </li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Custom Jewelry</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">&#128722; Cart</a></li>
                <li class="dropdown">
                    <a href="#">Profile</a>
                    <div class="dropdown-content">
                        <a href="login.php">Login</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Carousel Section -->
    <div class="container" data-autoplay="true">
        <div class="slide">
            <img src="images/1.png" alt="Jewelry Banner">
        </div>
        <div class="slide">
            <img src="images/3 (2).jpg" alt="Jewelry Banner">
        </div>
        <div class="slide">
            <img src="images/2 (3).jpg" alt="Jewelry Banner">
        </div>

        <button class="prev" onclick="prevSlide()"><i class="fa fa-angle-left"></i></button>
        <button class="next" onclick="nextSlide()"><i class="fa fa-angle-right"></i></button>
    </div>
    <div class="dots_container" id="indicator"></div>

    <!-- New Arrivals Section -->
    <div class="new-arrivals">
        <h2>New Arrivals</h2>
        <div class="product-container">
            <?php
                $products = [
                    ["image" => "images/necklace.png", "name" => "Gold Necklace", "price" => "$1200"],
                    ["image" => "images/diamond.jpg", "name" => "Diamond Necklace", "price" => "$4500"],
                    ["image" => "images/bracelet.jpg", "name" => "Silver Bracelet", "price" => "$850"],
                    ["image" => "images/earrings.jpg", "name" => "Pearl Earrings", "price" => "$650"]
                ];

                foreach ($products as $product) {
                    echo '
                    <div class="product-card">
                        <img src="'.$product["image"].'" alt="'.$product["name"].'">
                        <h3>'.$product["name"].'</h3>
                        <p class="price">'.$product["price"].'</p>
                    </div>';
                }
            ?>
        </div>
    </div>

    <script>
        var slides = document.getElementsByClassName("slide");
        var dotsContainer = document.getElementById("indicator");
        var dots = [];
        var count = 0;
        var interval = 3500;
        var autoplay = document.querySelector(".container").getAttribute("data-autoplay");

        window.onload = function () {
            initializeSlider();
            slides[0].style.opacity = "1";
            for (var i = 0; i < slides.length; i++) {
                var dot = document.createElement("div");
                dot.classList.add("dots");
                dot.setAttribute("onclick", "changeSlide(" + i + ")");
                dotsContainer.appendChild(dot);
                dots.push(dot);
            }
            dots[0].classList.add("active");
        }

        function initializeSlider() {
            if (autoplay === "true") {
                setInterval(nextSlide, interval);
            }
        }

        function changeSlide(index) {
            count = index;
            updateSlides();
        }

        function nextSlide() {
            count = (count + 1) % slides.length;
            updateSlides();
        }

        function prevSlide() {
            count = (count - 1 + slides.length) % slides.length;
            updateSlides();
        }

        function updateSlides() {
            for (var i = 0; i < slides.length; i++) {
                slides[i].style.opacity = "0";
                dots[i].classList.remove("active");
            }
            slides[count].style.opacity = "1";
            dots[count].classList.add("active");
        }
    </script>

</body>
</html>
